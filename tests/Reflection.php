<?php

/**
 * Contains the ReflectionTest class.
 * 
 * @package Common\Test
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */

namespace Common\Test;

use Common\Reflection;

/**
 * ReflectionTest class. A PHPUnit Test case class.
 *
 * Tests the "test only" (Relfection) class.
 * 
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */

class ReflectionTest extends \PHPUnit_Framework_TestCase
{
    const PRIVATE_DUMMY_RESULT = 'private_dummy_result';
    const STATIC_DUMMY_RESULT = 'static_dummy_result';

    private $private_property;
    private static $static_property;

    /**
     * Tests calling a private function in the current class.
     */
    public function test_callMethod()
    {
        $this->assertEquals(self::PRIVATE_DUMMY_RESULT, Reflection::callMethod('private_dummy_function', null, [], $this));
        $this->assertEquals(self::STATIC_DUMMY_RESULT, Reflection::callMethod('static_dummy_function', null, []));
    }


    /**
     * Tests to see that a private property can be retrieved and set.
     */
    public function test_private_property()
    {
        $this->private_property = 'not_set';
        $value = 'is_set';

        $this->assertNotEquals($value, Reflection::getProperty('private_property', null, $this));
        Reflection::setProperty('private_property', null, $this, $value);
        $this->assertEquals($value, Reflection::getProperty('private_property', null, $this));
    }

    /**
     * Tests to see that a static property can be retrieved and set.
     */
    public function test_static_property()
    {
        self::$static_property = 'not_set';
        $value = 'is_set';

        $this->assertNotEquals($value, Reflection::getProperty('static_property', null, $this));
        Reflection::setProperty('static_property', null, $this, $value);
        $this->assertEquals($value, Reflection::getProperty('static_property', null, $this));
    }

    /**
     * Functions used for reflection.
     *
     * @return string
     */

    private function private_dummy_function()
    {
        return self::PRIVATE_DUMMY_RESULT;
    }

    private static function static_dummy_function()
    {
        return self::STATIC_DUMMY_RESULT;
    }
}



