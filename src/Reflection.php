<?php

/**
 * Houses the Reflection class. This class should only be used for testing.
 *
 * @package Common
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */

namespace Common;

/**
 * Reflection class.
 *
 * Allows using public, private, and protected methods / variables from both
 * static reference points and object reference points.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 */
class Reflection
{

    /**
     * Calls the method of a specified class.
     *
     * Passes the list of arguments as parameters to the method. If an object is
     * sent then it associates that method (if its not static)with the object to
     * allow the method to alter its (the objects)state.
     *
     * @param string $method_name The method to call inside of a class.
     * @param string $class_name The name of the class to access, namespace
     *                           and all. If left blank then the class/object
     *                           that called this method is used.
     * @param array  $args The arguments to send to the method.
     * @param null   $object THe object to use when calling the method.
     * @return mixed The result of the method being called.
     */
    public static function callMethod(
        $method_name = "",
        $class_name = null,
        array $args = [],
        &$object = null
    ) {
        $method = self::getReflectionMethod($method_name, $class_name);

        if ($method->isStatic()) {
            $object = null;
        }

        return $method->invokeArgs($object, $args);
    }


    /**
     * Gets the property value.
     *
     * Gets the property
     *
     * @param string $property_name The property to access inside of a class.
     * @param string $class_name The name of the class to access, namespace
     *                           and all. If left blank then the class/object
     *                           that called this method is used.
     * @param null   $object THe object to use when calling the function.
     * @return mixed The property contained in the object.
     */
    public static function getProperty(
        $property_name = "",
        $class_name = null,
        &$object = null
    ) {
        $property = self::getReflectionProperty($property_name, $class_name);

        if ($property->isStatic()) {
            $object = null;
        }

        return $property->getValue($object);
    }

    /**
     * Sets the property value
     *
     * @param string $property_name The property to access inside of a class.
     * @param string $class_name The name of the class to access, namespace
     *                           and all. If left blank then the class/object
     *                           that called this method is used.
     * @param null   $object The object to use when calling the function.
     * @param mixed  $new_value The new value of the property.
     */
    public static function setProperty(
        $property_name = "",
        $class_name = null,
        &$object = null,
        $new_value = ""
    ) {
        $property = self::getReflectionProperty($property_name, $class_name);

        if ($property->isStatic()) {
            $property->setValue($new_value);
        } else {
            $property->setValue($object, $new_value);
        }
    }

    /**
     *
     *
     *
     * Getters
     *
     *
     *
     */
    
    /**
     * Gets the ReflectionMethod object, an executable object to pass arguments to.
     *
     * Accesses the public, private, or protected method of a class and returns
     * it as a \ReflectionClass object. If the class name is not given it tries
     * to get the class name that called this class.
     *
     * @param string $method_name The method to retrieve inside of a class.
     * @param string $class_name The name of the class to access, namespace
     *                           and all. If left blank then the class/object
     *                           that called this method is used.
     * @return \ReflectionMethod The method asked for.
     */
    private static function getReflectionMethod($method_name = "", $class_name = null)
    {
        if (is_null($class_name)) {
            $class_name = self::getCalledClassName();
        }

        $reflection = new \ReflectionClass($class_name);
        $method = $reflection->getMethod($method_name);

        if ($method->isPrivate()) {
            $method->setAccessible(true);
        }

        return $method;
    }

    /**
     * Returns the reflection property object.
     *
     * @param string $method_name The method to retrieve inside of a class.
     * @param string $class_name The name of the class to access, namespace
     *                           and all. If left blank then the class/object
     *                           that called this method is used.
     * @return \ReflectionProperty The property asked for.
     */
    private static function getReflectionProperty($property_name = "", $class_name = null)
    {
        if (is_null($class_name)) {
            $class_name = self::getCalledClassName();
        }

        $reflection = new \ReflectionClass($class_name);
        $property = $reflection->getProperty($property_name);

        if ($property->isPrivate()) {
            $property->setAccessible(true);
        }

        return $property;
    }


    /**
     * Gets the class that called any of the functions in this class.
     *
     * Returns the class name that called this current class. If not available
     * it will return the name of the current class.
     *
     * @return string The class name
     */
    private static function getCalledClassName()
    {
        $traces = debug_backtrace();

        foreach ($traces as $trace) {
            if ($trace['class'] !== get_class()) {
                return $trace['class'];
            }
        }

        return get_class();
    }
}