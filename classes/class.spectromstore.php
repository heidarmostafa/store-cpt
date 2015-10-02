<?php

/**
 * A Model for the Store Custom Post Type
 */
class SpectrOMStore
{
	private $_post_id = NULL;

	public function __construct($value = NULL, $type = 'name')
	{
	}

	/**
	 * Returns the post ID value for the store
	 * @return int The post ID value of the store, or NULL if not initialized
	 */
	public function get_store_id()
	{
		return ($this->_post_id);
	}

	/**
	 * Retrieves specified metadata for the Store
	 * @param string $type The name of the metadata to return
	 * @return string The stored metadata value or NULL
	 */
	public function get_store_data($type)
	{
	}
}
