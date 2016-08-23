<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\MinkExtension\Context\RawMinkContext;

/**
 * Defines application features from the specific context.
 */
class HomepageContext extends RawMinkContext implements Context, SnippetAcceptingContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given I am on :visit
     */
    public function iAmOn($visit)
    {
        $this->visitPath($visit);
    }

    /**
     * @Then I see :welcome
     */
    public function iSeeOnHomepage($welcome)
    {
        $this->assertSession()->elementContains('css', 'h1', $welcome);
    }
}
