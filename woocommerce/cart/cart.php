<?php

/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.9.0
 */

defined('ABSPATH') || exit;
?>
<main class="content">
    <article class="basket">
        <div class="basket__container">
            <h1 class="basket__title">My cart</h1>
            <div class="basket__wrapper">
                <ul class="basket__products">
                    <h2 class="basket__products-title">In my cart</h2>
                    <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                        $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                        $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                        if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                            $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                    ?>
                            <li class="basket___products-item basket__item cart_item" data-cart-item-key="<?php echo esc_attr($cart_item_key); ?>">
                                <div class="basket__item-img">
                                    <?php
                                    $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);

                                    if (! $product_permalink) {
                                        echo $thumbnail;
                                    } else {
                                        printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail);
                                    }
                                    ?>
                                </div>
                                <h2 class="basket__item-title">
                                    <?php
                                    if (! $product_permalink) {
                                        echo apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;';
                                    } else {
                                        echo apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key);
                                    }
                                    $color = get_field('pa_color', $_product->get_id());
                                    if ($color && !empty($color['name'])) {
                                        echo '<span class="custom-field"> color ' . esc_html($color['name']) . '</span>';
                                    }
                                    ?>
                                </h2>
                                <div class="basket__item-counter">
                                    <div class="basket__item-minus"></div>
                                    <div class="basket__item-count">
                                        <?php echo $cart_item['quantity']; ?>
                                    </div>
                                    <div class="basket__item-plus"></div>
                                </div>
                                <div class="basket__item-price basket__price" data-unit-price="<?php echo esc_attr($_product->get_price()); ?>">
                                    <?php
                                    $unit_price = $_product->get_price();
                                    $quantity = $cart_item['quantity'];
                                    $total_price = $unit_price * $quantity;
                                    echo wc_price($total_price);
                                    ?>
                                </div>
                                <div class="basket__item-remove">
                                    <?php
                                    echo apply_filters(
                                        'woocommerce_cart_item_remove_link',
                                        sprintf(
                                            '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                                            esc_url(wc_get_cart_remove_url($cart_item_key)),
                                            esc_html__('Remove this item', 'woocommerce'),
                                            esc_attr($product_id),
                                            esc_attr($_product->get_sku())
                                        ),
                                        $cart_item_key
                                    );
                                    ?>
                                </div>
                            </li>
                    <?php
                        }
                    } ?>

                </ul>
                <div class="basket__pay pay">
                    <h2 class="pay__title">To pay</h2>
                    <div class="pay__top">
                        <div class="pay__top-name">Total</div>
                        <div class="pay__top-name"><?php echo WC()->cart->get_cart_total(); ?></div>
                    </div>
                    
                    <button type="submit" form="checkout" class="button alt pay__btn" id="checkoutButton" disabled>Pay</button>
                    <label class="pay__label">
                        <input type="checkbox" class="pay__label-checkbox" id="agreeCheckbox">
                        <span class="pay__label-cyrcle"></span>
                        <p class="pay__label-info">I agree with the <a href="/privacy-policy/">rules</a> for using the trading platform and return</p>
                    </label>
                    <div class="pay__information">Please note that all payments are made on the banks' side, we do not have access to your payment data.</div>
                </div>

            </div>
        </div>
    </article>
</main>