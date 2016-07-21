Feature: about page
  In order to see about page contents
  As a user
  I am able to visit about page

  Scenario: Visiting about page
    Given I am on "/about"
    Then I should see "No name"

  Scenario: Visiting about page for an existing user
    Given I am on "/about/john"
    Then I should see "Hello john"