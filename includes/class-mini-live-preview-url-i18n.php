<?php
/**
 * This file contains the definition of the Mini_Live_Preview_Url_I18n class, which
 * is used to load the plugin's internationalization.
 *
 * @package       Mini_Live_Preview_Url
 * @subpackage    Mini_Live_Preview_Url/includes
 * @author        Sajjad Hossain Sagor <sagorh672@gmail.com>
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since    2.0.0
 */
class Mini_Live_Preview_Url_I18n {
	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since     2.0.0
	 * @access    public
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain(
			'mini-live-preview-url',
			false,
			dirname( MINI_LIVE_PREVIEW_URL_PLUGIN_BASENAME ) . '/languages/'
		);
	}
}
