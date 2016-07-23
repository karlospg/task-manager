<?php


class WorkspaceControllerTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testShowAction()
    {
        $workspaceId  = $this->tester->grabFromRepository(
            'AppBundle:Workspace', 'id',
            array('title' => 'Writing')
        );

        $projectTitle = $this->tester->grabFromRepository(
            'AppBundle:Project', 'title',
            array('workspace' => $workspaceId)
        );

        $this->assertEquals('Symfony book', $projectTitle, 'no match found');

        $this->tester->amOnRoute('workspace_show', array('name' => 'Writing'));
        $this->tester->seeResponseContains('Symfony book');
    }
}