<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;

class FeatureContext implements Context {
	/** @var  */
	private $client;
	/** @var \GuzzleHttp\Psr7\Response */
	private $response;

	/** @BeforeScenario */
	public function before() {
		$this->executeOccCommand('config:app:delete limit_login_to_ip whitelisted.ranges');
		$this->executeOccCommand('config:app:delete limit_login_to_ip whitelisted.uids');

		$jar = new \GuzzleHttp\Cookie\FileCookieJar('/tmp/cookies_' . md5(openssl_random_pseudo_bytes(12)));
		$this->client = new \GuzzleHttp\Client([
			'cookies' => $jar,
			'verify' => false,
			'allow_redirects' => [
				'referer'         => true,
				'track_redirects' => true,
			],
		]);
	}

	/** @AfterScenario */
	public function after() {
		$this->executeOccCommand('config:app:delete limit_login_to_ip whitelisted.ranges');
		$this->executeOccCommand('config:app:delete limit_login_to_ip whitelisted.uids');
	}

	/**
	 * @param string $command
	 */
	private function executeOccCommand($command) {
		shell_exec('php ' . __DIR__ . '/../../../../../../occ ' . $command);
	}

	/**
	 * @Given The range :range is permitted
	 */
	public function theRangeIsPermitted($range) {
		$this->executeOccCommand('config:app:set limit_login_to_ip whitelisted.ranges --value '. $range);
	}

	/**
	 * @Given The users :uids are permitted
	 */
	public function theUidsArePermitted($uids) {
		$this->executeOccCommand('config:app:set limit_login_to_ip whitelisted.uids --value '. $uids);
	}

	/**
	 * @When I try to login via :endpoint
	 *
	 * @param string $endpoint
	 * @throws \Exception
	 */
	public function iTryToLoginVia($endpoint) {
		switch($endpoint) {
			case 'load login page':
				try {
					$this->response = $this->client->get(
						'http://localhost:8080/index.php/login'
					);
				} catch (\GuzzleHttp\Exception\ClientException $e) {
					$this->response = $e->getResponse();
				}
				break;
			case 'web':
				try {
                    // TODO: this should actually try to login,
                    //       not only load the login page
                    //       How to do that?
					$this->response = $this->client->get(
						'http://localhost:8080/index.php/login'
					);
				} catch (\GuzzleHttp\Exception\ClientException $e) {
					$this->response = $e->getResponse();
				}
				break;
			case 'api':
				try {
					$this->response = $this->client->get(
						'http://localhost:8080/remote.php/webdav',
						[
							'auth' => [
								'admin',
								'admin',
							],
						]
					);
				} catch (\GuzzleHttp\Exception\ClientException $e) {
					$this->response = $e->getResponse();
				}
				break;
			default:
				throw new InvalidArgumentException("$endpoint was not expected");
		}
	}

	/**
	 * @Then the response status code should be :statusCode
	 */
	public function theResponseStatusCodeShouldBe($statusCode) {
		if((int)$statusCode !== (int)$this->response->getStatusCode()) {
			throw new UnexpectedValueException("Expected statuscode {$statusCode}, got {$this->response->getStatusCode()}");
		}
	}

	/**
	 * @Then the response URL should be :responseUrl
	 */
	public function theResponseUrlShouldBe($responseUrl) {
		$redirectHeader = $this->response->getHeader('X-Guzzle-Redirect-History');
		if(is_array($redirectHeader) && count($redirectHeader) > 0) {
			$lastUrl = $redirectHeader[count($redirectHeader) - 1];
			if ($lastUrl !== $responseUrl) {
				throw new InvalidArgumentException("Expected $responseUrl got $lastUrl");
			}
		}
	}

}
