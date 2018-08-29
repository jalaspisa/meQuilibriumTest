<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Support\WebDriverExpectedCondition;



/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */

    /**
    * @var \RemoteWebDriver
    */
    Protected $webDriver;

    Protected $BaseUrl;
    Protected $TermsAndConditionsUrl;
    Protected $ElementClick;
    Protected $DateElement;
    

    public function __construct()
    {
        $this->BaseUrl = "https://www.mequilibrium.com/";
        $this->TermsAndConditionsUrl = $this->BaseUrl."terms-and-conditions/";
     
    }

        /**
     * @Given I have a web browser
     */
    public function iHaveAWebBrowser()
    {
        
    }

    /**
     * @When I go to the HomePage
     */
    public function iGoToTheHomepage()
    {
        $this->webDriver->get($this->BaseUrl);
    }

    /**
     * @Then I should see a :arg1 link
     */
    public function iShouldSeeALink($text)
    {
       
       if (count($this->webDriver->findElements(WebDriverBy::linkText($text)))==0) throw new Exception ("Cannot find link ".$text);
    }

    /**
     * @Then I can click the :arg1 link and go to the Terms and Conditions Page
     */
    public function iCanClickTheLinkAndGoToTheTermsAndConditionsPage($text)
    {
      

        $this->webDriver->findElement(WebDriverBy::linkText($text))->click();
        if($this->webDriver->getCurrentURL()!= $this->TermsAndConditionsUrl) throw new Exception ("Link is ". $this->webDriver->getCurrentURL(). "not ".$this->TermsAndConditionsUrl);
    }

    /**
     * @When I go to the Terms and Conditions Page
     */
    public function iGoToTheTermsAndConditionsPage()
    {
        $this->webDriver->get($this->TermsAndConditionsUrl);
    }

    /**
     * @Then the date should be :arg1
     */
    public function theDateShouldBe($date)
    {
        $pageSource = $this->webDriver->getPageSource();
        $contentFound = strpos($pageSource, $date);
        if($contentFound === false) throw new Exception ("The date has been changed or there is no date present");
    }

    /**
    * @BeforeScenario
    */

    public function openWebBrowser(BeforeScenarioScope $event){
        $capabilities = DesiredCapabilities::chrome();
        $this->webDriver = RemoteWebDriver::create('http://127.0.0.1:4444/wd/hub', $capabilities);
    }

    /**
    * @AfterScenario
    */
    public function closeWebBrowser(AfterScenarioScope $event){
        if($this->webDriver) $this->webDriver->quit();
        
    }

}
