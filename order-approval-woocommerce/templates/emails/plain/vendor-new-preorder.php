<?php
/**
 * New Vendor Pre Order Email ( plain text )
 *
 * An email sent to the vendor when a new order is created by customer.

 * @since 1.0.3
 *
 */

if (! defined('ABSPATH')) {
    exit;
}
echo "= " . esc_html($email_heading) . " =\n\n";
echo sprintf('%1$s %2$s.', esc_html__('You have received an order from', 'order-approval-woocommerce'), esc_html($order->get_formatted_billing_full_name())) . "\n\n";
echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";
/**
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action('woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email);
echo "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";
echo wp_kses_post(apply_filters('woocommerce_email_footer_text', get_option('woocommerce_email_footer_text')));
