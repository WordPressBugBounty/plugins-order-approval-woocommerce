<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link  https://sevengits.com/
 * @since 1.0.0
 *
 * @package    Sg_Order_Approval_Woocommerce_Pro
 * @subpackage Sg_Order_Approval_Woocommerce_Pro/public
 */
if (!defined('ABSPATH')) exit;


/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Sg_Order_Approval_Woocommerce_Pro
 * @subpackage Sg_Order_Approval_Woocommerce_Pro/public
 * @author     Sevengits <sevengits@gmail.com>
 */
class Sg_Dokan_Order_Approval_Public
{

    /**
     * The ID of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since 1.0.0
     * @param string $plugin_name The name of the plugin.
     * @param string $version     The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * @since 1.0.0  add action button in admin 
     * @return actions
     */
    function oawoo_add_custom_order_status_actions_button($actions, $order)
    {

        if (is_user_logged_in()) {

            $user = wp_get_current_user();

            $roles = (array) $user->roles;
            if ($order->has_status(array('waiting'))) {

                $actions['wc_approved'] = array(
                    'url'       => wp_nonce_url(admin_url('admin-ajax.php?action=woocommerce_mark_order_status&status=pending&order_id=' . $order->get_id()), 'woocommerce-mark-order-status'),
                    'name'      => __('Approve', 'order-approval-woocommerce'),
                    'action'    => 'wc_approved',
                    'icon'   => '<i class="far fa-check-circle">&nbsp;</i>'
                );
                // Set the action button
                $actions['wc_reject'] = array(
                    'url'       => wp_nonce_url(admin_url('admin-ajax.php?action=woocommerce_mark_order_status&status=cancelled&order_id=' . $order->get_id()), 'woocommerce-mark-order-status'),
                    'name'      => __('Reject', 'order-approval-woocommerce'),
                    'action'    => 'wc_reject',
                    'icon'   => '<i class="far fa-times-circle">&nbsp;</i>'
                );
            }
        }

        return $actions;
    }

    /**
     * 
     * @since 1.0.0  add action button in admin 
	 
     */


    function oawoo_add_custom_order_status_actions_button_css()
    {
        global $post;
        if (!$post) {
            return;
        }
        if (has_shortcode($post->post_content, 'dokan-dashboard')) {
            echo '<style>a[data-original-title="Approve"]::before { font-family: "Font Awesome 5 Free" !important; content: "\f058" !important; color:GREEN }</style>';
            echo '<style>a[data-original-title="Reject"]::before { font-family: "Font Awesome 5 Free" !important; content: "\f057" !important; color:RED}</style>';
        }
    }

    function oawoo_get_order_status_class($text, $status )
    {
        switch ( $status ) {
            case 'waiting':
            case 'wc-waiting':
                $text = 'info';
                break;       
        }       
        
        return $text;
    }

    function oawoo_get_order_status_translated($text, $status)
    {
        switch ( $status ) {
            case 'waiting':
            case 'wc-waiting':
                $text = __('Waiting', 'order-approval-woocommerce');
                break;       
        }    
        return $text;
    }
}
