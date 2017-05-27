Feature: Shopping
  In order to by a jewel
  As a client
  I need to add jewels to my shopping cart

  Scenario: Add a single jewel to an empty cart
    Given I have an empty cart
    And a jewel titled "Gold ring" and priced 100€ is available on the store
    When I add the jewel to my cart
    Then the total of my cart should be 100€
