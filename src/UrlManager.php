<?php

/**
 * Contains the UrlManager class.
 *
 * @package Common
 * @author  John Salis <jsalis@stetson.edu>
 */

namespace Common;

/**
 * The UrlManager class is used to parse urls with camel case into hyphenated urls.
 *
 * @author John Salis <jsalis@stetson.edu>
 */
class UrlManager extends \CUrlManager {

    /**
     * The createUrl method goes and generates the url by using regular expressions
     * meaning that the url and have minus signs to allow for a seperation of words.
     *
     * @param  string  $route      A direction to the called controller and action.
     * @param  array   $params     Parameters of the url (GET's).
     * @param  string  $ampersand  Self explanatory.
     * @return string              The url of the parent.
     */
    public function createUrl($route, $params = array(), $ampersand = '&')
    {
        $route = preg_replace_callback('/(?<![A-Z])[A-Z]/', function ($matches) {
            return '-' . lcfirst($matches[0]);
        }, $route);
        return parent::createUrl($route, $params, $ampersand);
    }
 
    /**
     * The parseURL method goes and parses the URL to check if there is any information
     * that needs to be removed (spaces and minus signs).
     *
     * @param  CHttpRequest $request The request application component
     * @return string                The filtered url.
     */
    public function parseUrl($request)
    {
        $route = parent::parseUrl($request);
        return lcfirst(str_replace(' ', '', ucwords(str_replace('-', ' ', $route))));
    }
}