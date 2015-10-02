<?php

/**
 * Plugin loader.
 * Create instances of the SpectrOMRegisterStore and SpectromStoreMetabox classes and use them as appropriate
 */
class PluginStoreLoader
{
	private static $_instance = NULL;

	private function __construct()
	{
	}

	public static function get_instance()
	{
		if (NULL === self::$_instance)
			self::$_instance = new self();
		return (self::$instance);
	}

	public function test()
	{
		$store1 = new SpectrOMStore('test store');
		$store2 = new SpectrOMStore(122, 'id');
	}
}

PluginStoreLoader::get_instance(); // create the singleton instance

// EOF