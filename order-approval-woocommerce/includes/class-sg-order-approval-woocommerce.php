<?php

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Sg_Order_Approval_Woocommerce
 * @subpackage Sg_Order_Approval_Woocommerce/includes
 * @author     Sevengits <sevengits@gmail.com>
 */
if (!defined('ABSPATH')) exit;

class Sg_Order_Approval_Woocommerce
{

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Sg_Order_Approval_Woocommerce_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct()
	{
		if (defined('SG_ORDER_APPROVAL_WOOCOMMERCE_VERSION')) {
			$this->version = SG_ORDER_APPROVAL_WOOCOMMERCE_VERSION;
		} else {
			$this->version = '1.0.0';
		}

		$this->plugin_name = 'order-approval-woocommerce';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Sg_Order_Approval_Woocommerce_Loader. Orchestrates the hooks of the plugin.
	 * - Sg_Order_Approval_Woocommerce_i18n. Defines internationalization functionality.
	 * - Sg_Order_Approval_Woocommerce_Admin. Defines all hooks for the admin area.
	 * - Sg_Order_Approval_Woocommerce_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies()
	{

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-sg-order-approval-woocommerce-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-sg-order-approval-woocommerce-i18n.php';

		/**
		 * The class responsible for defining email template
		 * of the plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-sg-order-approval-woocommerce-wc_email.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-sg-order-approval-woocommerce-admin.php';


		switch (get_option('sgoa_enable_multivendor_support', '')) {
			case 'wcfm':
				require_once plugin_dir_path(dirname(__FILE__)) . 'admin/packages/wcfm.php';
				require_once plugin_dir_path(dirname(__FILE__)) . 'public/packages/wcfm.php';
			break;	
			case 'dokan':
				require_once plugin_dir_path(dirname(__FILE__)) . 'admin/packages/dokan.php';
				require_once plugin_dir_path(dirname(__FILE__)) . 'public/packages/dokan.php';	
			break;
		//	case 'multivendorx':	
		//		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/packages/multivendorx.php';
		}

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-sg-order-approval-woocommerce-public.php';


		$this->loader = new Sg_Order_Approval_Woocommerce_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Sg_Order_Approval_Woocommerce_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale()
	{

		$plugin_i18n = new Sg_Order_Approval_Woocommerce_i18n();

		$this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks()
	{
		$plugin_admin = new Sg_Order_Approval_Woocommerce_Admin($this->get_plugin_name(), $this->get_version());

		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');


		// add custom status

		$this->loader->add_action('init', $plugin_admin, 'oawoo_register_my_new_order_statuse_wc_waiting');
		$this->loader->add_filter('wc_order_statuses', $plugin_admin, 'oawoo_wc_order_statuse_wc_waiting');
		$this->loader->add_filter('woocommerce_admin_order_actions', $plugin_admin, 'oawoo_add_custom_order_status_actions_button', 100, 2);
		// add css class and icons for approve nd reject button
		$this->loader->add_action('admin_head', $plugin_admin, 'oawoo_add_custom_order_status_actions_button_css');
		$this->loader->add_filter('woocommerce_payment_gateways', $plugin_admin, 'oawoo_wc_add_to_gateways');

		// woo payment gateway
		$this->loader->add_action('plugins_loaded', $plugin_admin, 'oawoo_wc_gateway_init', 11);
		$this->loader->add_action('woocommerce_order_status_waiting', $plugin_admin, 'email_waiting_new_order_notifications', 10, 2);
		$this->loader->add_action('woocommerce_order_status_waiting_to_pending', $plugin_admin, 'oawoo_approve_order', 100, 2);
		$this->loader->add_action('woocommerce_order_status_waiting_to_cancelled', $plugin_admin, 'oawoo_status_waiting_rejected_notification', 100, 2);

		// Setting page 
		$this->loader->add_filter('woocommerce_get_sections_advanced', $plugin_admin, 'sg_add_settings_tab');
		$this->loader->add_filter('woocommerce_get_settings_advanced', $plugin_admin, 'sg_get_settings', 10, 2);
		// add custom styles to links in admin
		$this->loader->add_action('woocommerce_order_item_add_action_buttons', $plugin_admin, 'wc_order_item_add_action_buttons_callback', 10, 1);

		# below the plugin title in plugins page. add custom links at the begin of list
		$this->loader->add_filter('plugin_action_links_' . SG_BASE_ORDER, $plugin_admin, 'oawoo_links_below_title_begin');

		# below the plugin title in plugins page. add custom links at the end of list
		$this->loader->add_filter('plugin_action_links_' . SG_BASE_ORDER, $plugin_admin, 'oawoo_links_below_title_end');

		# below the plugin description in plugins page. add custom links at the end of list
		$this->loader->add_filter('plugin_row_meta', $plugin_admin, 'oawoo_plugin_description_below_end', 10, 2);

		# sidebar in plugin settings page
		$this->loader->add_action('woocommerce_admin_field_sgoaPromoSidebar', $plugin_admin, 'oawoo_add_admin_settings_sidebar', 100);

		#  bulk order action option
		$this->loader->add_filter('bulk_actions-woocommerce_page_wc-orders', $plugin_admin, 'sgits_oa_woo_orders_bulk_actions_begin', 10, 1);

		#  bulk order action option handler
		$this->loader->add_action('handle_bulk_actions-woocommerce_page_wc-orders', $plugin_admin, 'sgits_oa_woo_bulk_orders_actions', 10, 3);
		#  Display admin notice 
		$this->loader->add_action('admin_notices', $plugin_admin, 'sgits_oa_woo_admin_notices');
		// editable orders
		#  make waiting status orders are editable
		if (get_option('sg_enable_order_edit') == 'yes') {
			$this->loader->add_filter('wc_order_is_editable', $plugin_admin, 'sgitsoa_wc_make_waiting_orders_editable', 10, 2);
		}
	// support dokan
		switch (get_option('sgoa_enable_multivendor_support', '')) {
		
		case "dokan":
		$plugin_dokan = new Sg_Dokan_Order_Approval_Admin($this->get_plugin_name(), $this->get_version());
		$this->loader->add_action('woocommerce_order_status_waiting', $plugin_dokan, 'email_waiting_new_order_vendor_notifications', 10, 2);
		$this->loader->add_action('dokan_order_detail_after_order_general_details', $plugin_dokan, 'sgda_approval_actions_display');
		# custom field type for inline fields in settings
		//$this->loader->add_action('woocommerce_admin_field_sgits_relative_select', $plugin_dokan, 'sgits_doa_grouped_fields', 100);
		# Show only for main order
		$this->loader->add_action('woocommerce_thankyou', $plugin_dokan, 'sgda_custom_update_order_meta', 20, 1);
		# cron job for cancel unhandled orders
		$this->loader->add_action('wp', $plugin_dokan, 'sgits_doa_cancel_unpaid_orders_action');
		$this->loader->add_action('sgits_doa_cancel_unpaid_orders_action_hook', $plugin_dokan, 'sgits_doa_cancel_unhandled_orders');

		break;
		case "wcfm":
				$plugin_wcfm = new owfm_Admin($this->get_plugin_name(), $this->get_version());
				$this->loader->add_action('wcfm_after_order_quick_actions', $plugin_wcfm, 'owfm_order_quick_actions', 50, 1);
				$this->loader->add_action('wcfm_orders_module_actions', $plugin_wcfm, 'owfm_order_actions', 50, 3);
				$this->loader->add_action('wp_ajax_nopriv_owfm_get_order_update', $plugin_wcfm, 'owfm_update_order_status');
				$this->loader->add_action('wp_ajax_owfm_get_order_update', $plugin_wcfm, 'owfm_update_order_status');
				$this->loader->add_action('wp_footer',$plugin_wcfm , 'owfm_order_submit',100);
		break;
		}

		# New Order Count in WooCommerce -> Orders 
		$this->loader->add_filter( 'woocommerce_menu_order_count', $plugin_admin,'oaw_filter_woocommerce_menu_order_count', 10, 1 );

		
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks()
	{
		$plugin_public = new Sg_Order_Approval_Woocommerce_Public($this->get_plugin_name(), $this->get_version());

		//$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		//$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_filter('woocommerce_available_payment_gateways', $plugin_public, 'oawoo_paymentgatways_disable_manager');
		$this->loader->add_filter('woocommerce_get_order_item_totals', $plugin_public, 'oawoo_email_remove_payment_method', 10, 3);
		// support to dokan
		switch (get_option('sgoa_enable_multivendor_support', '')) {
		case "dokan":
		$plugin_dokan_public = new Sg_Dokan_Order_Approval_Public($this->get_plugin_name(), $this->get_version());
			$this->loader->add_action('wp_head', $plugin_dokan_public, 'oawoo_add_custom_order_status_actions_button_css');
			$this->loader->add_filter('dokan_my_account_my_sub_orders_actions', $plugin_dokan_public, 'oawoo_add_custom_order_status_actions_button', 100, 2);
			$this->loader->add_action('dokan_get_order_status_class', $plugin_dokan_public, 'oawoo_get_order_status_class',10,2);
			$this->loader->add_action('dokan_get_order_status_translated', $plugin_dokan_public, 'oawoo_get_order_status_translated',10,2);
		break;
		case "wcfm":
		$plugin_wcfm_public = new owfm_Public($this->get_plugin_name(), $this->get_version());
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_wcfm_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_wcfm_public, 'enqueue_scripts' );
		
		
		break;	
		}
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run()
	{
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name()
	{
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Sg_Order_Approval_Woocommerce_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader()
	{
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version()
	{
		return $this->version;
	}
}
