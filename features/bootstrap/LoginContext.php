<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\MinkExtension\Context\RawMinkContext;

/**
 * Defines application features from the specific context.
 */
class LoginContext extends RawMinkContext implements Context, SnippetAcceptingContext
{
    /**
     * @Given I try to login with path :visit
     */
    public function iTryToLoginWithPath($visit)
    {
        $this->visitPath($visit);
    }

    /**
     * @Then I should be redirected to :path
     */
    public function iShouldBeRedirectedTo($path)
    {
        $this->assertSession()->addressEquals($path);
    }
}