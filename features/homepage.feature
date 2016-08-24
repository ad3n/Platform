Feature: Show Homepage
    In order to show homepage
    As a guest
    I need to see homepage

    @javascript
    Scenario: Show Homepage
        Given I am on "/"
        Then I should see "Welcome"