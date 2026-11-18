<?php
if (!defined('ABSPATH')) exit;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    owfm
 * @subpackage owfm/admin
 * @author     Sevengits <sevengits@gmail.com>
 */
class owfm_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in owfm_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The owfm_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/order-approval-for-wcfm-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in owfm_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The owfm_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/order-approval-for-wcfm-admin.js', array('jquery'), $this->version, false);
	}

	/**
	 * approve / reject buttons in order details page for vendor dashboard
	 *
	 * @param [type] $order_id
	 * @return void
	 * @version 1.0.0
	 */
	function owfm_order_quick_actions($order_id)
	{
		$user_roles = get_userdata(get_current_user_id())->roles;
		if (!is_page("store-manager") || !in_array('wcfm_vendor', $user_roles)) {
			return;
		}
		$approve_data = sanitize_text_field('status=pending&order_id=' . $order_id);
		$reject_data = sanitize_text_field('status=cancelled&order_id=' . $order_id);
		if (wc_get_order($order_id)->get_status() === 'waiting') {
?>
			<a class="wcfm-action-icon sgits-oawcfm approve" onclick="order_submit(event)" data-action="owfm_get_order_update" data-ajax-url="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce('owfm-verify-nonce')); ?>" data-update="<?php echo esc_attr($approve_data); ?>">
				<span class="wcfmfa fa-check-double text_tip" data-tip="<?php esc_html_e('Approve order', 'order-approval-woocommerce'); ?>"></span>
			</a>
		<?php
		}
		if (wc_get_order($order_id)->get_status() !== 'cancelled') {
		?>
			<a class="wcfm-action-icon sgits-oawcfm reject" onclick="order_submit(event)" data-action="owfm_get_order_update" data-ajax-url="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" data-nonce="<?php echo esc_attr(wp_create_nonce('owfm-verify-nonce')); ?>" data-update="<?php echo esc_attr($reject_data); ?>">
				<span class="wcfmfa fa-times-circle text_tip" data-tip="<?php esc_html_e('Reject order', 'order-approval-woocommerce'); ?>"></span>
			</a>
<?php
		}
	}


	/**
	 * approve / reject buttons in orders page for vendor dashboard
	 *
	 * @param [type] $order_id
	 * @return void
	 * @version 1.0.0
	 */
	function owfm_order_actions($actions, $order_id, $the_order)
	{
		$order_id = wc_sanitize_order_id($order_id);
		$user_roles = get_userdata(get_current_user_id())->roles;
		if (!in_array('wcfm_vendor', $user_roles)) {
			return $actions;
		}
		$approve_data   =	'status=pending&order_id=' . $order_id;
		$reject_data	=	'status=cancelled&order_id=' . $order_id;
		if (wc_get_order($order_id)->get_status() === 'waiting') {
			$label   =	esc_html__('Approve order', 'order-approval-woocommerce');
			$link = sprintf('<a class="wcfm-action-icon" onclick="order_submit(event)" data-action="owfm_get_order_update" data-ajax-url="' . esc_url(admin_url('admin-ajax.php')) . '" data-nonce="' . esc_attr(wp_create_nonce('owfm-verify-nonce')) . '" data-update="' . esc_attr($approve_data) . '"><span class="wcfmfa fa-check-double text_tip" data-tip="%s"></span></a>', $label);
			$actions .= $link;
		}
		if (wc_get_order($order_id)->get_status() !== 'cancelled') {
			$label   =	esc_html__('Reject order', 'order-approval-woocommerce');
			$link = sprintf('<a class="wcfm-action-icon" onclick="order_submit(event)" data-action="owfm_get_order_update" data-ajax-url="' . esc_url(admin_url('admin-ajax.php')) . '" data-nonce="' . esc_attr(wp_create_nonce('owfm-verify-nonce')) . '" data-update="' . esc_attr($reject_data) . '"><span class="wcfmfa fa-times-circle text_tip" data-tip="%s"></span></a>', $label);
			$actions .= $link;
		}
		return $actions;
	}

	function owfm_update_order_status()
	{
		if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'owfm-verify-nonce')) {
			wp_send_json_error(array(
				'message' => __('Security check failed', 'order-approval-woocommerce'),
			), 401);
		}
		if (!current_user_can('manage_options')) {
			wp_send_json_error(array(
				'message' => __('Unauthorized access', 'order-approval-woocommerce'),
			), 403);
		}
		if (isset($_POST)) {
			$order_id = sanitize_text_field($_POST['post_data']['order_id']);
			$new_status = sanitize_text_field($_POST['post_data']['status']);
			$order = wc_get_order($order_id);
			$order->update_status($new_status);
			wp_send_json_success(__('Order status updated successfully', 'order-approval-woocommerce'), 200);
		} else {
			wp_send_json_error(__('Something went wrong', 'order-approval-woocommerce'), 403);
		}
	}

	function owfm_order_submit()
	{
		if (!is_user_logged_in()) {
			return;
		}
		$user_roles = get_userdata(get_current_user_id())->roles;
		if (!is_page('store-manager') || !in_array('wcfm_vendor', $user_roles)) {
			return;
		}
	}
}
