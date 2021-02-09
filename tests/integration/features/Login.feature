Feature: Login

  Scenario: Do no harm loading login page when nothing is configured
    When I try to login via "load login page"
    Then the response status code should be "200"

  Scenario: Do no harm authenticating via Web when nothing is configured
    When I try to login via "web"
    Then the response status code should be "200"

  Scenario: Do no harm authenticating via API when nothing is configured
    When I try to login via "api"
    Then the response status code should be "200"

  Scenario: Loading login page with blocked IP and no whitelisted user
    Given The range "192.168.0.0/24" is permitted
    When I try to login via "load login page"
    Then the response status code should be "403"
    And the response URL should be "http://localhost:8080/index.php/apps/limit_login_to_ip/denied"

  Scenario: Loading login page with blocked IP and some whitelisted users
    Given The range "192.168.0.0/24" is permitted
    Given The users "a,b,c" are permitted
    When I try to login via "load login page"
    Then the response status code should be "200"

  Scenario: Authenticating with blocked IP via API
    Given The range "192.168.0.0/24" is permitted
    When I try to login via "api"
    Then the response status code should be "403"
    And the response URL should be "http://localhost:8080/remote.php/webdav/"

  Scenario: Loading login page with whitelisted IP
    Given The range "127.0.0.0/24" is permitted
    When I try to login via "load login page"
    Then the response status code should be "200"

  Scenario: Authenticating with whitelisted IP via API
    Given The range "127.0.0.0/24" is permitted
    When I try to login via "api"
    Then the response status code should be "200"

  Scenario: Authenticating with multiple whitelisted IP via API
    Given The range "192.168.0.0/24,127.0.0.0/24,192.168.1.0/24" is permitted
    When I try to login via "api"
    Then the response status code should be "200"

  Scenario: Authenticating with blocked IP and whitelisted user via Web
    Given The range "192.168.0.0/24" is permitted
    Given The users "foo,admin,bar" are permitted
    When I try to login via "web"
    Then the response status code should be "200"

  Scenario: Authenticating with blocked IP and non-whitelisted user via Web
    Given The range "192.168.0.0/24" is permitted
    Given The users "foo,bar,qux" are permitted
    When I try to login via "web"
    Then the response status code should be "403"
    And the response URL should be "http://localhost:8080/index.php/apps/limit_login_to_ip/denied"

  Scenario: Authenticating with blocked IP and whitelisted user via API
    Given The range "192.168.0.0/24" is permitted
    Given The users "foo,admin,bar" are permitted
    When I try to login via "api"
    Then the response status code should be "200"

  Scenario: Authenticating with blocked IP and non-whitelisted user via API
    Given The range "192.168.0.0/24" is permitted
    Given The users "foo,bar,qux" are permitted
    When I try to login via "api"
    Then the response status code should be "403"
    And the response URL should be "http://localhost:8080/remote.php/webdav/"

  Scenario: Authenticating with no blocked IP and whitelisted user via Web
    Given The users "foo,admin,bar" are permitted
    When I try to login via "web"
    Then the response status code should be "200"

  Scenario: Authenticating with no blocked IP and non-whitelisted user via Web
    Given The users "foo,bar,qux" are permitted
    When I try to login via "web"
    Then the response status code should be "200"

  Scenario: Authenticating with no blocked IP and whitelisted user via API
    Given The users "foo,admin,bar" are permitted
    When I try to login via "api"
    Then the response status code should be "200"

  Scenario: Authenticating with no blocked IP and non-whitelisted user via API
    Given The users "foo,bar,qux" are permitted
    When I try to login via "api"
    Then the response status code should be "200"
