Feature: TermsAndConditions
	This test checks to see it there is a Terms & Conditions Link,
	Sees if clicking it brings the user to the right page,
	And chesk that the date updated is correct

	Scenario: TermsAndConditionsLinkIsPresent
		Given I have a web browser
		When I go to the HomePage
		Then I should see a 'PRIVACY [UPDATED]' link

	Scenario: TermsAndConditionsLinkWorks
		Given I have a web browser
		When I go to the HomePage
		Then I can click the "PRIVACY [UPDATED]" link and go to the Privacy Page

	Scenario: CorrectTermsAndConditionsDate
		Given I have a web browser
		When I go to the Privacy Page
		Then the date should be "May 24, 2018"