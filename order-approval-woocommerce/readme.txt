=== Order Approval for Woocommerce  ===
Contributors: Sarankumar,Sevengits,Amberpath
Donate link: https://sevengits.com/donate
Tags: order approval,woocommerce approval,approve orders,block payment,manual approval
Requires at least: 4.0
Tested up to: 7.1
Stable tag: 2.2.2
Requires PHP: 5.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Approve or reject WooCommerce orders before payment with manual order approval, blocked checkout, email notifications, and secure payment links.

== Description ==

**Order Approval for WooCommerce** lets store owners review, approve, or reject WooCommerce orders before payment is processed. Customers can place an order without paying upfront. After the order is reviewed, the customer receives an email with the next steps.

Use WooCommerce order approval for Cash on Delivery (COD) orders, high-value purchases, custom orders, and stores that need manual order verification before payment.

**Multivendor Support: Dokan and WCFM**

Since version 2.2.0, Dokan and WCFM multivendor support is built into the main Order Approval for WooCommerce plugin. Enable one integration in **Order Approval → Settings → Multivendor Support**, then install the required marketplace plugin. Do not enable Dokan and WCFM together.

* [Dokan](https://wordpress.org/plugins/dokan-lite/)
* [WCFM Frontend Manager](https://wordpress.org/plugins/wc-frontend-manager/) and [WCFM Marketplace](https://wordpress.org/plugins/wc-multivendor-marketplace/)
* [Read about the integrated multivendor support](https://sevengits.com/order-approval-for-woocommerce-add-ons-are-now-merged/?utm_source=readme&utm_medium=order-approval-readme&utm_campaign=oreadme)

**Free Order Approval Plugin**

* Approve or reject WooCommerce orders manually before payment.
* Automatically email customers when an order is approved or rejected.
* Include a secure WooCommerce payment link in the approval email.
* Support enabled WooCommerce payment gateways without additional gateway configuration.
* Block checkout payment until the order is approved.
* Edit order details directly before approval with a lightweight setup.

**Order Approval Pro**

* Includes all free order approval features.
* Set order approval rules for specific products, product categories, and tags, including category-and-tag combinations.
* Add Approve and Reject buttons to admin emails.
* Support multilingual stores with translation-ready strings.

Get [Order Approval Pro](https://sevengits.com/plugin/order-approval-woocommerce-pro/?utm_source=wp&utm_medium=readme&utm_campaign=order-approval-free "WooCommerce Order Approval Pro") | Read the [documentation](https://sevengits.com/docs/sg-order-approval-woocommerce-pro/?utm_source=wp&utm_medium=readme&utm_campaign=order-approval-free "Order Approval for WooCommerce documentation") | View the [demo](https://demo.sevengits.com/order-approval-woocommerce/?utm_source=wp&utm_medium=readme&utm_campaign=order-approval-free "WooCommerce order approval demo") | Contact [support](https://sevengits.com/contact/?utm_source=wp&utm_medium=readme&utm_campaign=order-approval-free "Order Approval support")

**How It Works**

1. A customer places a WooCommerce order without completing payment.
2. The order waits for manual review by the store owner or admin.
3. The admin reviews the order in the WooCommerce Orders dashboard and approves or rejects it.
4. If approved, the customer receives an email with a secure payment link. If rejected, the customer receives a cancellation email.

https://youtu.be/g0RJMNQz0bA?si=WTjy4kVExu5JNWhJ

== More WooCommerce Plugins by Sevengits ==

Sevengits develops WooCommerce plugins for store management, checkout, location selection, WhatsApp messaging, and automation.

* **Notiqoo – WhatsApp for WooCommerce:** [Free](https://wordpress.org/plugins/wc-messaging?utm_source=wp&utm_medium=readme&utm_campaign=order-approval "WhatsApp integration with WooCommerce") | [Premium version](https://notiqoo.com?utm_source=wp&utm_medium=readme&utm_campaign=order-approval "WhatsApp automation for WooCommerce") | [Demo](https://notiqoo.com/launch-demo/?utm_source=wp&utm_medium=readme&utm_campaign=order-approval "WooCommerce WhatsApp API demo"). Automate WooCommerce WhatsApp messaging and customer notifications.
* **Checkout Location Picker for WooCommerce:** [Free](https://wordpress.org/plugins/sg-checkout-location-picker/?utm_source=wp&utm_medium=readme&utm_campaign=order-approval) | [Premium version](https://sevengits.com/plugin/sg-checkout-location-picker-pro/?utm_source=wp&utm_medium=readme&utm_campaign=order-approval) | [Demo](https://demo.sevengits.com/sg-checkout-location-picker/?utm_source=wp&utm_medium=readme&utm_campaign=order-approval). Let customers select a delivery location at checkout.
* **Map to Address:** [Free](https://wordpress.org/plugins/map-to-address/?utm_source=wp&utm_medium=readme&utm_campaign=order-approval) | [Premium version](https://sevengits.com/plugin/map-to-address-pro/?utm_source=wp&utm_medium=readme&utm_campaign=order-approval) | [Demo](https://demo.sevengits.com/map-to-address-pro/?utm_source=wp&utm_medium=readme&utm_campaign=order-approval). Convert map locations into address fields.

== Installation ==

1. Install and activate Order Approval for WooCommerce.
2. In your WordPress admin, open the WooCommerce settings and select the **Payment Gateways** tab.
3. Open the **WooCommerce Order Approval** gateway settings.
4. Configure the order approval options and save your changes.

== Frequently Asked Questions ==

= Does it work with payment gateways such as PayPal and Stripe? =

The plugin is designed to work with enabled WooCommerce payment gateways. If a gateway does not behave as expected, contact support.

= Can customers pay before their order is approved? =

No. Customers place the order without paying upfront. Payment becomes available after the order is approved, using the payment link in the approval email.

= Does the plugin collect card details when an order is placed? =

No. The plugin does not collect payment card details when the customer places the order. Payment is completed later through the configured WooCommerce payment gateway.

= What happens to an order after it is placed? =

The order waits for review. When approved, it moves to the pending-payment stage and the customer receives a payment link. When rejected, it is cancelled.

= Why does the payment link expire? =

The link may expire when the WooCommerce hold-stock period ends. Review the **Hold stock (minutes)** option under **WooCommerce → Settings → Products → Inventory**.

== Screenshots ==

1. Admin order screen for approval.
2. WooCommerce payment gateway settings.
3. Product-level order approval settings in Pro.
4. Available customer email notifications.
5. Blocked checkout during order placement.
6. Classic checkout order placement.
7. Free version order approval settings.

== Changelog ==

Love using this plugin?

Please leaving a [Review](https://wordpress.org/support/plugin/order-approval-woocommerce/reviews/#new-post). Your support helps us keep the plugin free and continue providing updates and maintenance.

Thank you for supporting open-source ❤️

**2.2.2 - 18 NOV 2026**

1. **Improvement:** Improved compatibility with WordPress 7.1.
1. **Improvement:** Improved compatibility with WooCommerce 11.3.
1. **Fix:** Fixed an authorization issue in WCFM order status updates to prevent unauthorized order modifications.Credit to kta1kri.

**2.2.1 - 07 July 2026**

* Improved compatibility with WordPress 7.0.
* Improved compatibility with WooCommerce 10.9.

[Release Note](https://sevengits.com/blog/?utm_source=wp&utm_medium=readme&utm_campaign=oap-plugin) | [Complete Changelog](https://plugins.svn.wordpress.org/order-approval-woocommerce/trunk/changelog.txt)

== Upgrade Notice ==

= 2.2.2 =

Improves compatibility with WordPress 7.1 and WooCommerce 11.3