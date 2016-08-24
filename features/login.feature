Feature: Try to login
    In order to login
    As a guest
    I try to login

    @javascript
    Scenario: Try to login
        Given I am on "/admin/"
        Then I should be on "/admin/login"
        When I fill in "username" with "siab"
        Then I fill in "password" with "siab"
        And I press "Login"
        Then I should be on "/admin/"
        Then I should see "Dashboard"