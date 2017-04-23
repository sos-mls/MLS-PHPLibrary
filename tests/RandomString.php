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
     * Input for the shortHashID method.
     * 
     * @return array The id and expected id.
     */
    public function input_shortHashID() 
    {
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
     * Tests the fileName function.
     */
    public function test_fileName() 
    {
        $clean_arr = Reflection::getProperty('_file_name_clean', 'Common\RandomString', $this->_random_str);
        $random_str = new RandomString();

        $file_name = $random_str->fileName();

        foreach ($clean_arr as $clean) {
            $this->assertTrue(strpos($file_name, $clean[RandomString::FIND_KEY]) !== true);
        }
    }

    /**
     * Tests the hashID function.
     */
    public function test_hashID() 
    {
        $clean_arr = Reflection::getProperty('_hash_id_clean', 'Common\RandomString', $this->_random_str);
        $random_str = new RandomString();

        $hash_id = $random_str->hashID();

        foreach ($clean_arr as $clean) {
            $this->assertTrue(strpos($hash_id, $clean[RandomString::FIND_KEY]) !== true);
        }
    }

    /**
     * Tests the shortHashID function.
     * 
     * @dataProvider input_shortHashID
     * 
     * @param  integer $id          The id to hash.
     * @param  string  $expected_id The expected shortHashID.
     */
    public function test_shortHashID($id = 1, $expected_id = "1z") 
    {
        $random_str = new RandomString();
        $this->assertEquals($expected_id, $random_str->shortHashID($id));
    }

}



