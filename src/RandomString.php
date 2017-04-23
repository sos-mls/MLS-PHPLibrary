<?php 

/**
 * Contains the RandomString class, simply creates a random string.
 *
 * @package Common
 * @author  Christian Micklisch <christian.micklisch@successwithsos.com>
 */

namespace Common;

/**
 * Creates random values from PBKDF2's hasing system and removes unecessary characters from those strings.
 * 
 * @author   <christian.micklisch@successwithsos.edu>
 * @since 	 v0.0.0
 */
class RandomString extends \CApplicationComponent {

	const FIND_KEY = "find";
	const REPLACE_KEY = "replace";

	const SHORT_HASH_SALT = "1234LetusPlayAGameOfWar5678NowsTheTimeTProcreate";

	private static $_file_name_clean = [
		[
			self::FIND_KEY    => ':',
			self::REPLACE_KEY =>  '_'
		],
		[
			self::FIND_KEY    => "/",
			self::REPLACE_KEY => "_",
		],
		[
			self::FIND_KEY    => "+",
			self::REPLACE_KEY => "_",
		],
		[
			self::FIND_KEY    => "?",
			self::REPLACE_KEY => "_",
		],
		[
			self::FIND_KEY    => "=",
			self::REPLACE_KEY => "_",
		],
		[
			self::FIND_KEY    => "&",
			self::REPLACE_KEY => "_",
		],
		[
			self::FIND_KEY    => "sha256:1000:",
			self::REPLACE_KEY =>  ""
		],
	];

	private static $_hash_id_clean = [
		[
			self::FIND_KEY    => ':',
			self::REPLACE_KEY =>  ''
		],
		[
			self::FIND_KEY    => "/",
			self::REPLACE_KEY => "_",
		],
		[
			self::FIND_KEY    => "+",
			self::REPLACE_KEY => "_",
		],
		[
			self::FIND_KEY    => "?",
			self::REPLACE_KEY => "_",
		],
		[
			self::FIND_KEY    => "=",
			self::REPLACE_KEY => "_",
		],
		[
			self::FIND_KEY    => "&",
			self::REPLACE_KEY => "_",
		],
		[
			self::FIND_KEY    => "sha256:1000:",
			self::REPLACE_KEY =>  ""
		],
	];

	/**
	 * Generates the name of a random file
	 *
	 * Gets a random string and cleans it with the _file_name_clean array.
	 * 
	 * @return string A random file name
	 */
	public function fileName() {
		return $this->get_clean_string(self::$_file_name_clean);
	}

	/**
	 * Creates a Random Hash ID for Sales and Businesses.
	 *
	 * Gets a random string and cleans it according to the hash_id_clean array.
	 * 
	 * @return string A random hash ID.
	 */
	public function hashID() {
		return $this->get_clean_string(self::$_hash_id_clean);
	}

	/**
	 * Gets a random string and cleans it according to the clean array.
	 *
	 * Gets a random number from the current system time and a random number, 
	 * creates a hash from the random string, and cleans the array.
	 * 
	 * @param  array  $find_replace_arr An array with a list of find and replace arrays.
	 * @return string                   A clean random string.
	 */
	private function get_clean_string($clean_arr = []) {
		$str_key = strval(microtime()) . strval(mt_rand(1, 10000));
		$file_name = PBKDF2Hash::create_hash($str_key);

		foreach ($clean_arr as $clean) {
			$file_name = str_replace(
				$clean[self::FIND_KEY], 
				$clean[self::REPLACE_KEY], 
				$file_name
			);
		}

		return $file_name;
	}

	/**
	 * Generates a short hash id from Hash ids.
	 * 
	 * @param  int 	$id A positive integer.
	 * @return string 	A hash id from the id given.
	 */
	public function shortHashID($id, $salt = self::SHORT_HASH_SALT) {
		require_once(dirname(__FILE__) . '/../vendor/hashids/hashids/lib/Hashids/HashGenerator.php');
		require_once(dirname(__FILE__) . '/../vendor/hashids/hashids/lib/Hashids/Hashids.php');

		$hashid = new \Hashids\Hashids($salt);
		return $hashid->encode($id);
	}
}