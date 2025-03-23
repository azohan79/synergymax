<?php
/**
 * Product variable add to cart
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.5
 */

if (!defined('ABSPATH')) {
    exit;
}

global $product;

$attribute_keys = array_keys($attributes);

do_action('woocommerce_before_add_to_cart_form');
?>

<form class="variations_form cart coverbase__form" method="post" enctype='multipart/form-data'
      data-product_id="<?php echo absint($product->get_id()); ?>"
      data-product_variations="<?php echo htmlspecialchars(json_encode($available_variations)) ?>">

    <div class="coverbase__right">
        <?php if (empty($available_variations) && false !== $available_variations) : ?>
            <p class="stock out-of-stock"><?php esc_html_e('This product is currently out of stock and unavailable.', 'woocommerce'); ?></p>
        <?php else : ?>
            <h3 class="coverbase__right-title">Volumen del producto</h3>

            <div class="coverbase__right-volume">
                <?php foreach ($attributes as $attribute_name => $options) : ?>
                    <div class="coverbase__right-volume--item">
                        <?php
                        wc_dropdown_variation_attribute_options(array(
                            'options'   => $options,
                            'attribute' => $attribute_name,
                            'product'   => $product,
                        ));
                        ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="coverbase__right-quantity">
                <span class="coverbase__right-quantity--minus">-</span>
                <input type="number" class="coverbase__right-quantity--coll" name="quantity" value="1" min="1">
                <span class="coverbase__right-quantity--plus">+</span>
            </div>

            <div class="coverbase__right-price single_variation_wrap">
                <?php
                /**
                 * Hook: woocommerce_single_variation. Contains the selected variation data.
                 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
                 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
                 */
                do_action('woocommerce_single_variation');
                ?>
            </div>

            <div class="coverbase__right-information">
                <p class="coverbase__right-information--info">
                    ¿Eres una empresa? Si deseas comprar productos a precio mayorista, completa la solicitud y nos pondremos en contacto contigo.
                </p>
            </div>

        <?php endif; ?>
    </div>
</form>

<?php do_action('woocommerce_after_add_to_cart_form'); ?>
