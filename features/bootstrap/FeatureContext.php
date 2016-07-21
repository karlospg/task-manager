<?php
// …
use Behat\Behat\Tester\Exception\PendingException;
use Behat\MinkExtension\Context\MinkContext;

class FeatureContext extends MinkContext implements \Behat\Behat\Context\SnippetAcceptingContext
{
    /**
     * @Given There are :arg1 tasks
     */
    public function thereAreTasks($arg1)
    {
        throw new PendingException();
    }
}
