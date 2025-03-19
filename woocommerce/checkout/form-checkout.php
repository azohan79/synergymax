<?php
/**
 * Checkout Form
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_checkout_form', $checkout);

// If checkout registration is disabled and not logged in, redirect.
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
    echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
    return;
}
?>

<div class="basket__container">
    <div class="basket__delivery delivery">
        <h2 class="delivery__title">Dirección de entrega</h2>

        <form id="checkout" name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

            <?php if ($checkout->get_checkout_fields()) : ?>

                <?php do_action('woocommerce_checkout_before_customer_details'); ?>

                <div class="col2-set" id="customer_details">
                    <div class="col-1 billing">
                        <?php do_action('woocommerce_checkout_billing'); ?>
                    </div>

                    <div class="col-2 shipping">
                        <?php do_action('woocommerce_checkout_shipping'); ?>
                    </div>
                </div>

                <?php do_action('woocommerce_checkout_after_customer_details'); ?>

            <?php endif; ?>

            <div class="delivery__payMethod">
                <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>
                <h3 class="delivery__payMethod-title">Método de pago</h3>

                <?php do_action('woocommerce_checkout_before_order_review'); ?>

                <div id="order_review" class="woocommerce-checkout-review-order">
                    <?php do_action('woocommerce_checkout_order_review'); ?>
                </div>

                <?php do_action('woocommerce_checkout_after_order_review'); ?>
            </div>

        </form>
    </div>
</div>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>
