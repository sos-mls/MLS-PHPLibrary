<?php

/**
 * Contains the PBKDF2Test class.
 * 
 * @package Common\Test
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */

namespace Common\Test;

use Common\PBKDF2Hash;

/**
 * PBKDF2Test class. A PHPUnit Test case class.
 *
 * Goes through the PBKDF2 class testing the encoding process and the 
 * validation of the encoding.
 * 
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */

class PBKDF2Test extends \PHPUnit_Framework_TestCase
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
     * Input for the createHash method.
     *
     * The resulting hash is a previous result of the given string.
     * 
     * @return array The string to hash and the resulting hash.
     */
    public function input_createHash() 
    {
        return [
            [ // test default result
                'leggo-of-ma-eggo',
                'sha256:1000:pxbKdZPyKI/lw0XOBUpEAZKvHMTBF7fF:5aoFZQjr+P7Hq+1ymZ2XwmfpY3WzyeCW'
            ],
            [
                'doesnt-anybody-wanna',
                'sha256:1000:UddSdJJ7f2AisoRaxcxyCXWEz98l994C:c4P7ZFXgxJ378vMh9y2lTMmibYF5ZMeT'
            ],
            [
                'test123',
                'sha256:1000:n6rGdsNPEvyi1Bgm9YZ7mRitzjfPWEaJ:dbBiMI89/MuBFTjSOkciWHV2FOfDK27e'
            ],
            [
                'Dr. Data in the house',
                'sha256:1000:SbaaHH5Bs3WVBPRWCslazLmzUHOkBc2L:pyTQMe3M92PUS7ImhucsQOHiJxV6gvLy'            ]
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
     * Tests the createHash function.
     *
     * Runs through the test by checking that the expected hash does not equal
     * the created hash by the string. And then checks that the hash is still 
     * valid by comparing it to the initial string.
     *
     * @dataProvider input_createHash
     * 
     * @param  string $string       The string to hash
     * @param  string $expectedHash The hash to get back from the string.
     */
    public function test_createHash($string = "", $expectedHash = "") 
    {
        $this->assertNotEquals($expectedHash, PBKDF2Hash::createHash($string));
        $this->assertTrue(
            PBKDF2Hash::validatePassword(
                $string, 
                PBKDF2Hash::createHash($string)
            )
        );
    }
}



