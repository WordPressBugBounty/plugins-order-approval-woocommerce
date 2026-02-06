<?php
if (! defined('ABSPATH')) {
    exit;
}
$doc_url = 'https://sevengits.com/docs/sg-order-approval-woocommerce-pro/';
$free_support = 'https://wordpress.org/support/plugin/order-approval-woocommerce/';
$request_customize = 'https://sevengits.com/contact/';
$premium_url = 'https://sevengits.com/plugin/order-approval-woocommerce-pro/';
$utm_link = '?utm_source=dashboard&utm_medium=settings-sidebar&utm_campaign=order-approval-woocommerce';
?>
<div id="sg-promo-sidebar">
    <div id="promo-helpfull-links">
        <h4>Helpfull Links</h4>
        <ul>
            <li><span class="dashicons dashicons-media-default sg-icon"></span><a href="<?php echo esc_url($doc_url . $utm_link); ?>" target="_blank">Documentation</a></li>
            <li><span class="dashicons dashicons-groups sg-icon"></span><a href="<?php echo esc_url($free_support); ?>" target="_blank">Free Support</a></li>
            <li><span class="dashicons dashicons-sos sg-icon"></span><a href="<?php echo esc_url($request_customize . $utm_link); ?>" target="_blank">Request Customization</a></li>
            <li><span class="dashicons dashicons-awards sg-icon"></span><a href="<?php echo esc_url($premium_url . $utm_link); ?>" target="_blank">Get Premium </a></li>
        </ul>
    </div>
    <div class="cards-section">
        <div class="card">
            <div class="card-content">
                <?php
                echo sprintf('<h3 class="title">%1$s</h3>', esc_html('Go Pro & Simplify Approvals', 'order-approval-woocommerce'));
                echo sprintf('<p>%1$s —<br/><b>%2$s!</b></p>', esc_html('Unlock full order control with the Pro version', 'order-approval-woocommerce'), esc_html('only $29/site with per-product support', 'order-approval-woocommerce'));
                ?>
                <div class="action"><a href="<?php echo esc_url($premium_url . $utm_link); ?>" class="button round" target="_blank"><img src="<?php echo esc_url(plugins_url( 'css/img/ticket-sale.svg', dirname(__FILE__) )); ?>" alt=""><?php echo esc_html('Buy Premium @ $29', 'order-approval-woocommerce'); ?></a></div>
            </div>
        </div>
    </div>
</div>

<?php
if (!wp_is_mobile()) {
?>
    <style>
        .woocommerce form>.form-table, #sg_tab_main-description {
            max-width: calc(100% - 375px);

        }

        .woocommerce form>.form-table td * {
            max-width: 100%;
        }
    </style>
<?php
}
?>