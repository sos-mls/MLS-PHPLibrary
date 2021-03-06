<?php

/**
 * Contains the UrlManagerTest class.
 *
 * @package Common\Test
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */

namespace Common\Test;

use Common\UrlManager;

/**
 * UrlManagerTest class. A PHPUnit Test case class.
 * 
 * Tests general functionality for the UrlManager inside of the Common namespace
 * 
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */
class UrlManagerTest extends \PHPUnit_Framework_TestCase {
    
    /**
     *
     *
     *
     * Input 
     *
     *
     * 
     */

    /**
     * Creates a list of routes, and parameters along with the expected URLs. 
     * 
     * @return array The arguments for the route and params.
     */
    public function input_createUrl()
    {
        return [
            [
                'salecents.com',
                [],
                '/usr/local/bin/phpunit?r=salecents.com'
            ],
            [
                '/assets/save',
                [
                    'power' => 'lift'
                ],
                '/usr/local/bin/phpunit?r=assets/save&power=lift'
            ],
            [
                '/assets/save',
                [
                    'big' => 'pimpin',
                    'spending' => 'cheese',
                    'I' => 'gotta',
                    'test' => 'this-please'
                ],
                '/usr/local/bin/phpunit?r=assets/save&big=pimpin&spending=cheese&I=gotta&test=this-please'
            ],
        ];
    }

    public function input_parseUrl()
    {
        return [
            [
                '/vendor.php',
                'vendor.php'
            ],
            [
                '/vendor-is-awesome',
                'vendorIsAwesome'
            ],
        ];
    }

    /**
     *
     *
     *
     * Test
     *
     *
     * 
     */

    /**
     * Tests the createUrl method.
     *
     * @dataProvider input_createUrl
     * 
     * @param  string $route        The route to be taken
     * @param  array  $params       Get parameters
     * @param  string $expected_url The expected url to be generated by the manager.
     */
    public function test_createUrl($route = "", array $params = [], $expected_url = "")
    {
        $urlManager = new UrlManager();

        $this->assertEquals($urlManager->createUrl($route, $params), $expected_url);
    }

    /**
     * Tests the parseUrl Method.
     *
     * @dataProvider input_parseUrl
     *
     * @param  string $request_uri    The request URI for the server.
     * @param  string $expected_parse The expected result.
     */
    public function test_parseUrl($request_uri, $expected_parse)
    {
        $_SERVER['SCRIPT_FILENAME'] = "/var/www/salecents/index.php";
        $_SERVER['SCRIPT_NAME'] = "/index.php";
        $_SERVER['REQUEST_URI'] = $request_uri;
        $request = new \CHttpRequest();
        $urlManager = new UrlManager();
        $urlManager->setUrlFormat(UrlManager::PATH_FORMAT);
        $this->assertEquals($expected_parse, $urlManager->parseUrl($request));
    }
}
