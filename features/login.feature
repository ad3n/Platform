Feature: Try to login
    In order to login
    As a guest
    I try to login

    @javascript
    Scenario: Try to login
        Given I try to login with path "/admin"
        Then I should be redirected to "/admin/login"