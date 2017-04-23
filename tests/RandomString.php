<?php

/**
 * Contains the RandomStringTest class.
 * 
 * @package Common\Test
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */

namespace Common\Test;

use Common\Reflection;
use Common\RandomString;

/**
 * RandomStringTest class. A PHPUnit Test case class.
 *
 * Goes through the random string methods to ensure that they function.
 * 
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */

class RandomStringTest extends \PHPUnit_Framework_TestCase
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
     * Input for the short_hash_id method.
     * 
     * @return array The id and expected id.
     */
    public function input_short_hash_id() {
        return [
            [ // test default result
                1,
                "1z"
            ],
            [
                12,
                "w2"
            ],
            [
                1337,
                "de3"
            ],
            [
                8403,
                "VLkB"
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
     * Tests the file_name function.
     */
    public function test_file_name() {
        $clean_arr = Reflection::getProperty('_file_name_clean', 'Common\RandomString', $this->_random_str);
        $random_str = new RandomString();

        $file_name = $random_str->file_name();

        foreach ($clean_arr as $clean) {
            $this->assertTrue(strpos($file_name, $clean[RandomString::FIND_KEY]) !== true);
        }
    }

    /**
     * Tests the hash_id function.
     */
    public function test_hash_id() {
        $clean_arr = Reflection::getProperty('_hash_id_clean', 'Common\RandomString', $this->_random_str);
        $random_str = new RandomString();

        $hash_id = $random_str->hash_id();

        foreach ($clean_arr as $clean) {
            $this->assertTrue(strpos($hash_id, $clean[RandomString::FIND_KEY]) !== true);
        }
    }

    /**
     * Tests the short_hash_id function.
     * 
     * @dataProvider input_short_hash_id
     * 
     * @param  integer $id          The id to hash.
     * @param  string  $expected_id The expected short_hash_id.
     */
    public function test_short_hash_id($id = 1, $expected_id = "1z") {
        $random_str = new RandomString();
        $this->assertEquals($expected_id, $random_str->short_hash_id($id));

    }

}



