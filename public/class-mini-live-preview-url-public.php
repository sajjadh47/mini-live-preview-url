<?php
/**
 * This file contains the definition of the Mini_Live_Preview_Url_Public class, which
 * is used to load the plugin's public-facing functionality.
 *
 * @package       Mini_Live_Preview_Url
 * @subpackage    Mini_Live_Preview_Url/public
 * @author        Sajjad Hossain Sagor <sagorh672@gmail.com>
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version and other methods.
 *
 * @since    2.0.0
 */
class Mini_Live_Preview_Url_Public {
	/**
	 * The ID of this plugin.
	 *
	 * @since     2.0.0
	 * @access    private
	 * @var       string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since     2.0.0
	 * @access    private
	 * @var       string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since     2.0.0
	 * @access    public
	 * @param     string $plugin_name The name of the plugin.
	 * @param     string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since     2.0.0
	 * @access    public
	 */
	public function enqueue_styles() {
		$enable_preview = Mini_Live_Preview_Url::get_option( 'enable', 'wpmlpu_basic_settings', 'off' );

		if ( 'off' === $enable_preview ) {
			return;
		}

		wp_enqueue_style( $this->plugin_name, MINI_LIVE_PREVIEW_URL_PLUGIN_URL . 'public/css/public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since     2.0.0
	 * @access    public
	 */
	public function enqueue_scripts() {
		$enable_preview = Mini_Live_Preview_Url::get_option( 'enable', 'wpmlpu_basic_settings', 'off' );

		if ( 'off' === $enable_preview ) {
			return;
		}

		wp_enqueue_script( $this->plugin_name, MINI_LIVE_PREVIEW_URL_PLUGIN_URL . 'public/js/public.js', array( 'jquery' ), $this->version, false );

		wp_localize_script(
			$this->plugin_name,
			'MiniLivePreviewUrl',
			array(
				'ajaxurl'         => admin_url( 'admin-ajax.php' ),
				'previewLinkType' => Mini_Live_Preview_Url::get_option( 'preview_link', 'wpmlpu_basic_settings', 'both' ),
			)
		);
	}
}
