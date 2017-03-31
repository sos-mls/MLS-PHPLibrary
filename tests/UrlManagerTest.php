<?php

/**
 * The base class for functional test cases.
 * In this class, we set the base URL for the test application.
 * We also provide some common methods to be used by concrete test classes.
 */
class UrlManagerTest extends \PHPUnit_Framework_TestCase {
	/**
	 * Sets up before each test method runs.
	 * This mainly sets the base URL for the test application.
	 */
	protected function setUp() {
		// does nothing
	}

	/**
	 * Creates a list of routes, and parameters along with the expected URLs. 
	 * 
	 * @return array The arguments for the route and params.
	 */
	public function input_createUrl() {
		return [
			[
				'salecents.com',
				[],
				'/usr/local/bin/phpunit?r=salecents.com'
			]
		];
	}

	/**
	 * Tests the createUrl method.
	 *
	 * @dataProvider input_createUrl
	 * 
	 * @param  string $route        The route to be taken
	 * @param  array  $params       [description]
	 * @param  string $expected_url [description]
	 */
	public function test_createUrl($route = "", array $params = [], $expected_url = "") {
		$urlManager = new UrlManager();

		$this->assertEquals($urlManager->createUrl($route, $params), $expected_url);
	}

	/**
	 * Tests the parseUrl Method.
	 */
	public function test_parseUrl() {
		$urlManager = new UrlManager();

	}
}
