<?php
/**
 * Single Product Page Template
 *
 * @package WooCommerce
 */

get_header(); ?>

<main class="content">
    <?php while (have_posts()) : the_post(); global $product; ?>
    
    <article class="coverbase">
        <div class="coverbase__wrapper">
            <!-- Левая часть: информация о продукте -->
            <div class="coverbase__left">
                <h2 class="coverbase__subtitle"><?php echo strip_tags(wc_get_product_category_list($product->get_id())); ?></h2>
                <h1 class="coverbase__title"><?php the_title(); ?></h1>
                
                <div class="coverbase__container">
                    <!-- Цвет -->
                    <?php 
                    $color = $product->get_attribute('pa_color');
                    $color_slug = $color ? sanitize_title($color) : 'default-color';
                    ?>
                    <div class="coverbase__name"><?php echo esc_html($color ?: 'N/A'); ?></div>
                    <div class="coverbase__color">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/<?php echo esc_attr($color_slug); ?>.png" alt="<?php echo esc_attr($color ?: 'No color'); ?>">
                    </div>

                    <!-- Иконка "Добавить в избранное" -->
                    <div class="coverbase__heart">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/product-card/Heart.svg" alt="heart">
                    </div>
                </div>

                <!-- Описание -->
                <div class="coverbase__info">
                    <p><?php echo apply_filters('the_content', get_the_content()); ?></p>
                </div>
            </div>

            <!-- Центральная часть: изображения товара -->
            <div class="coverbase__center">
                <div class="coverbase__center-box">
                    <div class="coverbase__center-img">
                        <?php if (has_post_thumbnail()) {
                            echo get_the_post_thumbnail($product->get_id(), 'full', ['alt' => get_the_title()]);
                        } ?>
                    </div>
                    
                    <div class="coverbase__center-arrows coverbase__menu">
                        <div class="coverbase__arrows-top coverbase__arrows">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/arrows/Chevron-Right.svg" alt="arrow-top">
                        </div>
                        <div class="coverbase__menu-box">
                            <?php
                            $attachment_ids = $product->get_gallery_image_ids();
                            if ($attachment_ids) {
                                foreach ($attachment_ids as $attachment_id) {
                                    $thumb_url = wp_get_attachment_url($attachment_id);
                                    echo '<div class="coverbase__menu-img"><img src="' . esc_url($thumb_url) . '" alt="thumbnail"></div>';
                                }
                            }
                            ?>
                        </div>
                        <div class="coverbase__arrows-bottom coverbase__arrows">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/arrows/Chevron-Right.svg" alt="arrow-bottom">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Правая часть: объем, цена, кнопка -->
            <div class="coverbase__right">
                <h3 class="coverbase__right-title">Product volume</h3>
                <div class="coverbase__right-volume">
                    <?php
                    $volumes = $product->get_attribute('pa_volume') ? explode(', ', $product->get_attribute('pa_volume')) : ['N/A'];
                    foreach ($volumes as $volume) {
                        echo '<span class="coverbase__right-volume--item">' . esc_html(trim($volume)) . '</span>';
                    }
                    ?>
                </div>

                <!-- Количество -->
                <div class="coverbase__right-quantity">
                    <span class="coverbase__right-quantity--minus"></span>
                    <input type="number" class="coverbase__right-quantity--coll" name="quantity" value="1" min="1">
                    <span class="coverbase__right-quantity--plus"></span>
                </div>

                <!-- Цена -->
                <div class="coverbase__right-price">
                    <div>
                        <h4 class="coverbase__right-price--title">Price</h4>
                        <?php if ($product->is_on_sale()) : ?>
                            <div class="coverbase__right-price--old"><?php echo wc_price($product->get_regular_price()); ?></div>
                            <span class="coverbase__right-price--new"><?php echo wc_price($product->get_sale_price()); ?></span>
                        <?php else : ?>
                            <span class="coverbase__right-price--new"><?php echo wc_price($product->get_regular_price()); ?></span>
                        <?php endif; ?>
                    </div>

                    <form action="<?php echo esc_url($product->add_to_cart_url()); ?>" method="post">
                        <input type="hidden" name="quantity" class="coverbase__hidden-quantity" value="1">
                        <button type="submit" class="coverbase__right-price--btn"><?php echo esc_html($product->add_to_cart_text()); ?></button>
                    </form>
                </div>

                <div class="coverbase__right-information">
                    <p class="coverbase__right-information--info">Are you a company? If you want to purchase products at wholesale prices, fill out the application and we will contact you</p>
                    <button class="coverbase__right-information--btn">Apply for wholesale pricing</button>
                </div>
            </div>
        </div>
    </article>

    <!-- Описание товара -->
    <article class="information">
        <div class="information__block">
            <div class="information__item">
                <h2 class="information__item-name">Product description</h2>
                <div class="information__item-icon">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/arrows/Chevron-Right.svg" alt="shewron">
                </div>
            </div>
            <div class="information__description">
                <p><?php echo apply_filters('the_content', get_the_content()); ?></p>
            </div>
        </div>
    </article>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
