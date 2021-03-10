<?php
/**
* Holt die JSON Daten. Beachtet die Sicherheit und nutzt einen Cache.
*/

class getData
{
	private static $url = 'https://jsonplaceholder.typicode.com/users';
	private static $ds;
	private static $json;

	public static function setJsonData()
	{
		$contents = file_get_contents(self::$url);

		self::$ds = json_decode($contents, true);

		return self::$ds;
	}
}