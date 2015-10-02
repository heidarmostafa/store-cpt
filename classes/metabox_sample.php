<?php

/**
 * Defines metabox form used when editing custom post types
 */
class SampleMetaBox extends SpectrOMMetaBox
{
	const META_KEY = '_meta_key';

	private $_properties = NULL;					// holds postmeta data
	private $_settings = NULL;						// instance of the SpectrOMSettings class

	const CPT_NAME = 'spectrom_cpt';				// name of the Custom Post Type this metabox is for

	/**
	 * Create the metabox, setting the CSS class, title, etc.
	 */
	public function __construct()
	{
		parent::__construct(
			'sample-metabox',						// CSS class for metbox
			__('Metabox Title', 'spectrom'),		// metabox title
			array(&$this, 'output_metabox'),		// metabox callback
			// remaining parameters are defaults
			self::CPT_NAME,							// post type
			'normal',								// context
			'high'									// priority
		);

		// register the javascript
		add_action('admin_enqueue_scripts', array(&$this, 'admin_scripts'));
	}

	/*
	 * Output the contents for the metabox using a SpectrOMSettings object
	 * @param WP_Post $post The post object that is being edited
	 */
	public function output_metabox($post)
	{
		if (self::CPT_NAME !== $post->post_type)
			return;

		$this->_create_settings($post->ID);
		$this->_settings->output_settings();

		// only enqueue the scripts when the metabox is drawn
		$this->enqueue_scripts();
	}

	/**
	 * Registers the scripts and styles that the metabox uses
	 * @param type $page
	 */
	public function admin_scripts($page)
	{
		// add scripts, if needed
//		wp_register_script('metabox-script', plugin_dir_url(dirname(__FILE__)) . 'spectrommetabox.js',
//			array('jquery') /*, 'media-upload', 'thickbox')*/, '1.0', TRUE);
	}

	/**
	 * Enqueues the scripts needed for the metabox
	 */
	private function enqueue_scripts()
	{
		wp_enqueue_script('metabox-script');
	}

	/*
	 * Callback for the 'save_post' action.
	 * @param int $post_id The ID of the post being saved.
	 */
	public function save_data($post_id)
	{
		global $post;
		if (is_object($post) && self::CPT_NAME !== $post->post_type)
			return;

		$input = new SpectrOMInput();

		// TODO: nonce verification

		$form_data = $_POST['spectrom_metabox'];
		$this->_create_settings($post_id);
		$valid = new SpectrOMValidation();
		if ($valid->validate_all($this->_settings, $form_data)) {
			// save meta data
		}
	}

	/**
	 * Creates the SpectrOMSettings object used to define this MetaBoxe's form fields
	 * @return SpectrOMSettings The settings instance
	 */
	private function _create_settings($post_id)
	{
		$this->_properties = new SpectrOMMetaData($post_id, '_spectrom_');

		$args = array(
			'page' => 'post',
			'group' => 'spectrom_metabox', // _group
			'option' => 'spectrom_sample_metabox',
			'sections' => array(
				'settings_section' => array(
					'title' => __('Metabox Title', 'spectrom'),
					'description' => __('Metabox Heading', 'spectrom'),
					'fields' => array(
						'field_name' => array(
							'title' => __('Field Label:', 'spectrom'),
							'type' => 'text',
							'validation' => 'maxlen:64',
							'value' => $this->_properties->field_name,
						),
					),
				),
			),
		);

		$this->_settings = new SpectrOMSettings($args);
	}
}
