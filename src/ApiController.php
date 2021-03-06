<?php

/**
 * Contains the ApiController class, simplifies rendering and reading as a
 * controller.
 *
 * @package Common
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */

namespace Common;

/**
 * ApiController class.
 *
 * Extends generic information about rendering JSON data and reading hash_id's
 * from the request of the client.
 *
 * @author Christian Micklisch <christian.micklisch@successwithsos.com>
 * @link   http://www.restapitutorial.com
 */
class ApiController extends \CController {

    // naming retreived from: http://www.restapitutorial.com/httpstatuscodes.html
    private $codes = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => '(Unused)',
        307 => 'Temporary Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported'
    ];

    protected $allowGenerateHeader = true;

    /**
     * Renders a json object from the data given and sets up the status header.
     *
     * Generates a header dependent on the status given, and creates a json
     * body. Once the body has ended the application ends.
     *
     * @param  array    $data   The data to be echoed.
     * @param  integer  $status The HTTP status.
     */
    protected function renderJSON(array $data = [], $status = 200)
    {
        $this->generateApiHeader($status);

        if ($status == 200) {
            echo \CJSON::encode($data);

            foreach (\Yii::app()->log->routes as $route) {
                if ($route instanceof CWebLogRoute) {
                    $route->enabled = false; // disable any weblogroutes
                }
            }
        } else {
            echo \CJSON::encode($data);
        }

        if ($this->allowGenerateHeader) {
            \Yii::app()->end();
        }
    }

    /**
     * Renders a JSON erorr response.
     * 
     * Returns a json response in a proper error format to let the 
     * front notify the user a solution to the problem.
     * 
     * @param  array|string $errors The errors that occured.
     * @param  integer      $http_code The code to send to the user.
     */
    protected function renderJSONError($errors, $http_code = 424) 
    {
        if (is_array($errors)) {
            $this->renderJSON([
                'errors' => $errors
            ], $http_code);
        } else {
            $this->renderJSON([
                'errors' => [
                    'general' => [$errors]
                ]
            ], $http_code);
        }
    }

    /**
     * Returns a link to get more information about the object.
     *
     * Creates a link based off of the route given and the hash id to hash.
     *
     * @param  string $route_name The route to the controller and action.
     * @param  string $hash_id    The hash_id.
     * @return string/boolean     Url to get more information about the object.
     */
    protected function getReadLink($route_name, $hash_id)
    {
        return $_SERVER['HTTP_HOST'] . '/' . $route_name . '/' . $hash_id;
    }

    /**
     * Returns the hash id if it exists in the url, otherwise it returns a false.
     *
     * The HashID is in the url if the $_GET variable is empty or the hash id is the only
     * key in the array.
     *
     * @param  string $route_name The route to the controller and action.
     * @return string/boolean     The hash_id or a repsonse that states the url does
     *                            not have a hash_id.
     */
    protected function getHashID($route_name)
    {

        $append_redirect = str_replace('/' . $route_name, '', $_SERVER['REDIRECT_URL']);
        $url_has_append = strpos($append_redirect, '/') !== false;
        $is_get_empty = empty($_GET);
        $is_hash_id_in_get = array_key_exists(str_replace('/', '', $append_redirect), $_GET);
        $is_hash_id_only_get = $is_hash_id_in_get && sizeof($_GET) == 1;

        if ($url_has_append && ($is_get_empty || $is_hash_id_only_get)) {
            return str_replace('/', '', $append_redirect);
        } else {
            return false;
        }
    }

    /**
     * Generates the header for the api response.
     *
     * Generates the status header, creates a function to echo out the header and
     * the current content-type "application/json"
     *
     * @param  integer $status The HTTP status.
     */
    private function generateApiHeader($status = 200)
    {
        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);

        $this->generateHeader($status_header);
        $this->generateHeader('Content-type: application/json');
    }

    /**
     * Generates the header of the server.
     *
     * Outputs the header only when the generation is allowed, otherwise echo the header.
     *
     * @param  string $headerString The output of the header
     */
    protected function generateHeader($headerString)
    {
        $function = "header";

        if (!$this->allowGenerateHeader) {
            $function = function ($string) {
                echo $string . "\n";
            };
        }

        $function($headerString);
    }


    /**
     * Gets the message for a status code.
     *
     * Can't you read! JEEZUZ! If it can't find the status code inside of the list
     * of codes then it returns an empty status message.
     *
     * @param integer $status A http status code.
     * @return string The message to go along with the code.
     */
    private function _getStatusCodeMessage($status = 100)
    {
        return (isset($this->codes[$status])) ? $this->codes[$status] : '';
    }
}
