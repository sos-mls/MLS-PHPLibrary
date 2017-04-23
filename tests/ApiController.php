<?php

/**
 * Contains the ApiControllerTest class.
 * 
 * @package Common\Test
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */


namespace Common\Test;

use Common\ApiController;
use Common\Reflection;

/**
 * ApiControllerTest class. A PHPUnit Test case class.
 *
 * Tests the ApiController by going through expected outputs
 * 
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */

class ApiControllerTest extends \PHPUnit_Framework_TestCase
{
    
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
     * Input array for the renderJSON method.
     * 
     * @return array The data, status, and expected output for a list of tests.
     */
    public function input_renderJSON()
    {
        return [
            [ // test default
                [],
                200,
                "HTTP/1.1 200 OK\nContent-type: application/json\n[]"
            ],
            [ // test specific info
                [
                    'artsy' => 'fartsy',
                    'this' => 'is',
                    'a' => 'test'
                ],
                204,
                "HTTP/1.1 204 No Content\n" .
                "Content-type: application/json\n" .
                '{"artsy":"fartsy","this":"is","a":"test"}'
            ],
            [ // test 500
                [
                    'error' => 'Missing password field'
                ],
                500,
                "HTTP/1.1 500 Internal Server Error\n" .
                "Content-type: application/json\n" .
                '{"error":"Missing password field"}'
            ]
        ];
    }

    /**
     * Input method for the getReadLink method.
     * 
     * @return array The Controller name, hash_id, server host, and expected output.
     */
    public function input_getReadLink()
    {
        return [
            [ // test default result
                "",
                "",
                "",
                "//"
            ],
            [
                "reviews",
                "default_hash_id",
                "salecents.com",
                "salecents.com/reviews/default_hash_id"
            ]
        ];
    }

    /**
     * Input method for the getHashID method.
     * 
     * @return array The controller naem, redirect_url, and expected result.
     */
    public function input_getHashID()
    {
        return [
            [ // test default result
                "",
                "",
                false
            ],
            [
                "shrekoning",
                "/default_hash_id",
                "default_hash_id"
            ]
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
     * Checks that the output of the renderJSON matches the expected output given.
     *
     * Tests the renderJSON method to product a proper header and body from the given
     * data and status.
     *
     * @dataProvider input_renderJSON
     * @runInSeparateProcess
     *
     * @param  array   $data            An array to become a json object.
     * @param  integer $status          The status header.
     * @param  string  $expected_output What renderJSON is to output.
     */
    public function test_renderJSON(
        array $data = [], 
        $status = 200, 
        $expected_output = "HTTP/1.1 200 OK\nContent-type: application/json\n[]"
    ) {

        $this->expectOutputString($expected_output);
        
        $apiController = new ApiController(rand(0,1000));

        Reflection::callMethod('renderJSON', 'Common\ApiController', [
            $data,
            $status,
            false
        ], $apiController);
    }

    /**
     * Tests the getReadLink of the ApiController.
     *
     * @dataProvider input_getReadLink
     * 
     * @param  string $controller_name The name of the controller as source of the reading.
     * @param  string $hash_id         The hash id to be read.
     * @param  string $host_name       The host name of the current server.
     * @param  string $read_link       The expected link.
     */
    public function test_getReadLink(
        $controller_name = "", 
        $hash_id = "", 
        $host_name = "", 
        $read_link = ""
    ) {

        $_SERVER['HTTP_HOST'] = $host_name;

        $apiController = new ApiController(rand(0,1000));

        $link = Reflection::callMethod('getReadLink', 'Common\ApiController', [
            $controller_name,
            $hash_id
        ], $apiController);

        $this->assertEquals($link, $read_link);
    }

    /**
     * Tests the getHashID of the ApiController class.
     *
     * @dataProvider input_getHashID
     * 
     * @param  string $controller_name The name of the controller.
     * @param  string $redirect_url    The expected client request.
     * @param  string $result          The hash_id.
     */
    public function test_getHashID($controller_name = "", $redirect_url = "", $result = "")
    {
        $_SERVER['REDIRECT_URL'] = $redirect_url;

        $apiController = new ApiController(rand(0,1000));

        $hash_id = Reflection::callMethod('getHashID', 'Common\ApiController', [
            $controller_name
        ], $apiController);

        $this->assertEquals($result, $hash_id);
    }
}