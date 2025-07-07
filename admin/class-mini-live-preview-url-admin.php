<?php
/**
 * This file contains the definition of the Mini_Live_Preview_Url_Admin class, which
 * is used to load the plugin's admin-specific functionality.
 *
 * @package       Mini_Live_Preview_Url
 * @subpackage    Mini_Live_Preview_Url/admin
 * @author        Sajjad Hossain Sagor <sagorh672@gmail.com>
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version and other methods.
 *
 * @since    2.0.0
 */
class Mini_Live_Preview_Url_Admin {
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
	 * The plugin options api wrapper object.
	 *
	 * @since     2.0.0
	 * @access    private
	 * @var       array $settings_api Holds the plugin options api wrapper class object.
	 */
	private $settings_api;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since     2.0.0
	 * @access    public
	 * @param     string $plugin_name The name of this plugin.
	 * @param     string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name  = $plugin_name;
		$this->version      = $version;
		$this->settings_api = new Sajjad_Dev_Settings_API();
	}

	/**
	 * Adds a settings link to the plugin's action links on the plugin list table.
	 *
	 * @since     2.0.0
	 * @access    public
	 * @param     array $links The existing array of plugin action links.
	 * @return    array $links The updated array of plugin action links, including the settings link.
	 */
	public function add_plugin_action_links( $links ) {
		$links[] = sprintf( '<a href="%s">%s</a>', esc_url( admin_url( 'admin.php?page=mini-live-preview-url' ) ), __( 'Settings', 'mini-live-preview-url' ) );

		return $links;
	}

	/**
	 * Adds the plugin settings page to the WordPress dashboard menu.
	 *
	 * @since     2.0.0
	 * @access    public
	 */
	public function admin_menu() {
		add_menu_page(
			__( 'Mini Live Preview URL', 'mini-live-preview-url' ),
			__( 'Live Preview URL', 'mini-live-preview-url' ),
			'manage_options',
			'mini-live-preview-url',
			array( $this, 'menu_page' ),
			'dashicons-visibility'
		);
	}

	/**
	 * Renders the plugin menu page content.
	 *
	 * @since     2.0.0
	 * @access    public
	 */
	public function menu_page() {
		$this->settings_api->show_forms();
	}

	/**
	 * Initializes admin-specific functionality.
	 *
	 * This function is hooked to the 'admin_init' action and is used to perform
	 * various administrative tasks, such as registering settings, enqueuing scripts,
	 * or adding admin notices.
	 *
	 * @since     2.0.0
	 * @access    public
	 */
	public function admin_init() {
		// set the settings.
		$this->settings_api->set_sections( $this->get_settings_sections() );

		$this->settings_api->set_fields( $this->get_settings_fields() );

		// initialize settings.
		$this->settings_api->admin_init();
	}

	/**
	 * Returns the settings sections for the plugin settings page.
	 *
	 * @since     2.0.0
	 * @access    public
	 * @return    array An array of settings sections, where each section is an array
	 *                  with 'id' and 'title' keys.
	 */
	public function get_settings_sections() {
		$settings_sections = array(
			array(
				'id'    => 'wpmlpu_basic_settings',
				'title' => __( 'General Settings', 'mini-live-preview-url' ),
			),
		);

		/**
		 * Filters the plugin settings sections.
		 *
		 * This filter allows you to modify the plugin settings sections.
		 * You can use this filter to add/remove/edit any settings sections.
		 *
		 * @since     2.0.0
		 * @param     array $settings_sections Default settings sections.
		 * @return    array $settings_sections Modified settings sections.
		 */
		return apply_filters( 'wpmlpu_settings_sections', $settings_sections );
	}

	/**
	 * Returns all the settings fields for the plugin settings page.
	 *
	 * @since     2.0.0
	 * @access    public
	 * @return    array An array of settings fields, organized by section ID.  Each
	 *                  section ID is a key in the array, and the value is an array
	 *                  of settings fields for that section. Each settings field is
	 *                  an array with 'name', 'label', 'type', 'desc', and other keys
	 *                  depending on the field type.
	 */
	public function get_settings_fields() {
		$settings_fields = array(
			'wpmlpu_basic_settings' => array(
				array(
					'name'  => 'enable',
					'label' => __( 'Enable Live Preview', 'mini-live-preview-url' ),
					'type'  => 'checkbox',
					'desc'  => __( 'Checking this box will enable live preview of links on the front.', 'mini-live-preview-url' ),
				),
				array(
					'name'    => 'preview_link',
					'label'   => __( 'Preview Links Type', 'mini-live-preview-url' ),
					'type'    => 'select',
					'options' => array(
						'both'          => __( 'Preview Both Internal & External Links', 'mini-live-preview-url' ),
						'internal_only' => __( 'Preview Internal Links Only', 'mini-live-preview-url' ),
						'external_only' => __( 'Preview External Links Only', 'mini-live-preview-url' ),
					),
				),
			),
		);

		/**
		 * Filters the plugin settings fields.
		 *
		 * This filter allows you to modify the plugin settings fields.
		 * You can use this filter to add/remove/edit any settings field.
		 *
		 * @since     2.0.0
		 * @param     array $settings_fields Default settings fields.
		 * @return    array $settings_fields Modified settings fields.
		 */
		return apply_filters( 'wpmlpu_settings_fields', $settings_fields );
	}
}
