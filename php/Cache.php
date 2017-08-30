<?php
class Cache
{
	private static $_driver;
	private static $_pool;

	public static function getDriver()
	{
		if (!self::$_driver) {
			self::$_driver = new Stash\Driver\FileSystem(array(
				'path' => CACHE_PATH,
				'filePermissions' => 0777,
				'dirPermissions' => 0777,
			));			
		}
		return self::$_driver;
	}

	public static function getPool()
	{
		if (!self::$_pool) {
			$driver = self::getDriver();
			self::$_pool = new Stash\Pool($driver);
		}
		return self::$_pool;
	}

}