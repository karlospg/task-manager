<?php

namespace AppBundle\Controller;

use AppBundle\Form\TaskType;
use AppBundle\Entity\Task;
use AppBundle\Repository\TaskRepository;
use Doctrine\DBAL\DBALException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var TaskRepository $taskRepository */
        $taskRepository = $em->getRepository('AppBundle:Task');
        $tasks = $taskRepository->findAllWithOrder();
            
        return array('tasks' => $tasks);
    }

    /**
     * @Route("/task/new", name="new_task")
     * @Template("AppBundle:Default:edit.html.twig")
     */
    public function newAction(Request $request)
    {
        $task = new Task();
        $form = $this->createForm(new TaskType(), $task);

        if ($request->getMethod() == 'POST')
        {
            $form->handleRequest($request);

            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();

                $em->persist($task);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info', 'The task has been created');

                return $this->redirectToRoute('homepage');
            }
        }
        
        return array('form' => $form->createView(), 'task' => $task);
    }

    /**
     * @Route("/task/{task}/edit", name="edit_task")
     * @Template()
     */
    public function editAction(Request $request, Task $task)
    {
        $form = $this->createForm(new TaskType(), $task);

        if ($request->getMethod() == 'POST')
        {
            $form->handleRequest($request);

            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();

                $em->persist($task);
                $em->flush();

                $this->get('session')->getFlashBag()->add('info', 'The task has been saved');

                return $this->redirectToRoute('homepage');
            }
        }

        return array('form' => $form->createView(), 'task' => $task);
    }

    /**
     * @Route("/task/{task}/delete", name="delete_task")
     */
    public function deleteAction(Request $request, Task $task)
    {
        $em = $this->getDoctrine()->getManager();

        try {
            $em->remove($task);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', 'The task has been deleted');
        }
        catch (DBALException $e) {
            $request->getSession()->getFlashBag()->add('error', 'An error happened when deleting the task');
        }

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/task/{task}/move/{direction}", name="move_task", requirements={"direction" = "up|down"})
     */
    public function moveAction(Request $request, Task $task, $direction)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var TaskRepository $taskRepository */
        $taskRepository = $em->getRepository('AppBundle:Task');

        /** @var Task $taskToExchange */
        $taskToExchange = $taskRepository->getTaskToExchangeOrder($task, $direction);
        
        if ($taskToExchange) {
            $task->exchangeOrder($taskToExchange);

            $em->persist($task);
            $em->persist($taskToExchange);
            $em->flush();
        }

        $tasks = $taskRepository->findAllWithOrder();
        
        $response['status'] = 'OK';
        $response['content'] = $this->get('templating')->render("AppBundle:Default:_tasks.html.twig", array('tasks' => $tasks));

        return new JsonResponse($response);
    }
}
