<?php
defined('ABSPATH') || exit;

/**
 * Шаблон: Personal (переопределён)
 */


$current_user = wp_get_current_user();
$first_name   = $current_user->user_firstname;
$last_name    = $current_user->user_lastname;
$email        = $current_user->user_email;
$phone        = get_user_meta($current_user->ID, 'billing_phone', true);

// Адрес
$country   = get_user_meta($current_user->ID, 'billing_country', true);
$state     = get_user_meta($current_user->ID, 'billing_state', true);
$city      = get_user_meta($current_user->ID, 'billing_city', true);
$address   = get_user_meta($current_user->ID, 'billing_address_1', true);
$postcode  = get_user_meta($current_user->ID, 'billing_postcode', true);

// Список заказов (WooCommerce 3.0+)
$customer_orders = wc_get_orders(array(
    'customer' => $current_user->ID,
    'limit'    => -1,
    'orderby'  => 'date',
    'order'    => 'DESC',
));
?>

<main class="content">
    <article class="private">
        <div class="private__container">
            <h2 class="private__title">Hello, <?php echo esc_html($first_name); ?>!</h2>
            <div class="private__wrapper">
                <div class="private__information">
                    <h3 class="private__information-title">Información personal</h3>
                    <div class="private__information-box">
                        <div class="private__information-item">
                            <h4 class="private__information-titling">Nombre</h4>
                            <span class="private__information-value"><?php echo esc_html($first_name); ?></span>
                        </div>
                        <div class="private__information-item">
                            <h4 class="private__information-titling">Apellido</h4>
                            <span class="private__information-value"><?php echo esc_html($last_name); ?></span>
                        </div>
                        <div class="private__information-item private__information-item--email">
                            <h4 class="private__information-titling">Correo electrónico</h4>
                            <span class="private__information-value"><?php echo esc_html($email); ?></span>
                        </div>
                        <div class="private__information-item">
                            <h4 class="private__information-titling">Número de teléfono</h4>
                            <span class="private__information-value"><?php echo esc_html($phone); ?></span>
                        </div>
                        <button class="private__information-btn">Cambiar información</button>
                    </div>
                    <div class="private__information-address">
                        <h3 class="private__information-title">Dirección de entrega</h3>
                        <div class="private__information-box">
                            <div class="private__information-item">
                                <h4 class="private__information-titling">País</h4>
                                <span class="private__information-value"><?php echo esc_html($country); ?></span>
                            </div>
                            <div class="private__information-item">
                                <h4 class="private__information-titling">Provincia</h4>
                                <span class="private__information-value"><?php echo esc_html($state); ?></span>
                            </div>
                            <div class="private__information-item">
                                <h4 class="private__information-titling">Ciudad</h4>
                                <span class="private__information-value"><?php echo esc_html($city); ?></span>
                            </div>
                            <div class="private__information-item">
                                <h4 class="private__information-titling">DIRECCIÓN</h4>
                                <span class="private__information-value"><?php echo esc_html($address); ?></span>
                            </div>
                            <div class="private__information-item private__information-item--addres">
                                <h4 class="private__information-titling">Index</h4>
                                <span class="private__information-value"><?php echo esc_html($postcode); ?></span>
                            </div>
                            <button class="private__information-btn">Cambiar información</button>
                        </div>
                    </div>
                </div>
                <div class="private__orders">
                    <h2 class="private__orders-title">Pedidos</h2>

                    <?php if (!empty($customer_orders)) : ?>
                        <?php 
                        foreach ($customer_orders as $order_post) :
                            $order = wc_get_order($order_post->get_id()); 
                            $order_id = $order->get_id();
                            $order_date = $order->get_date_created()->date_i18n('d.m.y');
                            $order_status = $order->get_status(); // completed, processing...
                            $order_total = $order->get_formatted_order_total();
                            // Придумать, как отобразить "delivery date" или "In Delivery"
                        ?>
                            <div class="private__orders-item">                                
                                <div class="private__orders-item--box">
                                    <div class="private__orders-id">#<?php echo $order_id; ?></div>
                                    <div class="private__orders-date"><?php echo $order_date; ?></div>
                                    <div class="private__orders-status <?php echo esc_attr($order_status); ?>">
                                        <?php echo esc_html($order_status); ?>
                                    </div>
                                    <div class="private__orders-datum <?php echo esc_attr($order_status); ?>">
                                        
                                        <?php // echo '22.01.25'; ?>
                                    </div>
                                    <div class="private__orders-price"><?php echo $order_total; ?></div>
                                    <div class="private__orders-chevron">
                                        <a href="<?php echo $order->get_view_order_url(); ?>">
                                            <img src="<?php echo get_template_directory_uri(); ?>/icons/arrows/Chevron-Right.svg" alt="Chevron">
                                        </a>
                                    </div>
                                </div>

                                
                                <ul class="private__orders-list private__list">
                                    <?php 
                                    foreach ($order->get_items() as $item_id => $item) :
                                        $product_name = $item->get_name();
                                        $product_qty  = $item->get_quantity();
                                        $product_total = wc_price($item->get_total());
                                        // Картинка
                                        $product = $item->get_product();
                                        if ( $product && $product->get_image_id() ) {
                                            $image_html = wp_get_attachment_image($product->get_image_id(), 'thumbnail');
                                        } else {
                                            $image_html = '<img src="' . get_template_directory_uri() . '/img/product/default.png" alt="product">';
                                        }
                                    ?>
                                        <li class="private__list-item">
                                            <div class="private__list-img">
                                                <?php echo $image_html; ?>
                                            </div>
                                            <div class="private__list-name"><?php echo esc_html($product_name); ?></div>
                                            <div class="private__list-quantity"><?php echo esc_html($product_qty); ?></div>
                                            <div class="private__list-price"><?php echo $product_total; ?></div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p>Aún no tienes pedidos</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </article>
</main>
