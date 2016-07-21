<?php


class TaskControllerCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    public function indexActionTest(FunctionalTester $I)
    {
        $I->wantTo('too see the welcome message on home page');
        $I->amOnPage('/');
        $I->see('Welcome');
    }

    /*
    public function indexActionWithoutTasksTest(FunctionalTester $I)
    {
        $I->wantTo('Too see no results on table tasks');
        $I->amOnPage('/');
        $I->see('No results');
    }

    public function indexActionWithTasksTest(FunctionalTester $I)
    {
        $I->haveInDatabase('task', array('name' => 'Task1', 'order' => '1'));
        $I->haveInDatabase('task', array('name' => 'Task2', 'order' => '2'));

        $I->wantTo('Too see 2 results on table tasks');
        $I->amOnPage('/');
        $I->seeNumberOfElements('#tasks-table > tbody > tr', 2);
        $I->dontSee('No results');
    }
    */
}
