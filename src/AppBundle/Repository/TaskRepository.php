<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Task;
use Doctrine\ORM\EntityRepository;

class TaskRepository extends EntityRepository
{
    public function findAllWithOrder()
    {
        $qb = $this->createQueryBuilder('t')->orderBy('t.order', 'ASC');

        return $qb->getQuery()->getResult();
    }
    
    public function getTaskToExchangeOrder(Task $task, $direction)
    {
        $order = $direction == 'up' ? '<' : '>';

        $qb = $this->createQueryBuilder('t')
            ->where("t.order $order :order")
            ->setParameter('order', $task->getOrder())
            ->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
