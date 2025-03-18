<?php

/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 */
defined('ABSPATH') || exit;
get_header('shop'); ?>
<main class="content">
    <!-- Категории -->
    <article class="categories">
        <h1 class="categories__title">Categories</h1>
        <div class="categories__wrapper">
            <?php
            // Получаем все категории товаров
            $args = array(
                'taxonomy'   => 'product_cat',
                'hide_empty' => true,
            );
            $categories = get_terms($args);

            if (!empty($categories) && !is_wp_error($categories)) {
                foreach ($categories as $category) {
                    $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                    $image = wp_get_attachment_url($thumbnail_id);
            ?>
                    <a href="<?php echo get_term_link($category); ?>" class="categories__item">
                        <div class="categories__item-img">
                            <?php if ($image) : ?>
                                <img src="<?php echo $image; ?>" alt="<?php echo $category->name; ?>">
                            <?php endif; ?>
                        </div>
                        <div class="categories__item-name">
                            <?php echo $category->name; ?>
                        </div>
                    </a>
            <?php
                }
            }
            ?>
        </div>
    </article>
    <!-- Все товары -->
    <article class="allProduct">
        <h2 class="allProduct__title">All products by Synergy Max</h2>
        <div class="allProduct__wrapper">
            <?php
            // Получаем все товары
            $args = array(
                'post_type'      => 'product',
                'posts_per_page' => -1, // Выводим все товары
            );
            $products = new WP_Query($args);

            if ($products->have_posts()) {
                while ($products->have_posts()) {
                    $products->the_post();
                    global $product;
                    // Получаем категории товара
                    $terms = get_the_terms($product->get_id(), 'product_cat');
                    $category_names = [];

                    if ($terms && !is_wp_error($terms)) {
                        foreach ($terms as $term) {
                            $category_names[] = $term->name; // Собираем названия категорий
                        }
                    }

                    $categories_string = implode(', ', $category_names);
            ?>
                    <div class="product__item allProduct__item">
                        <a href="<?php the_permalink(); ?>">
                            <div class="product__item-img allProduct__item-img">
                                <?php echo $product->get_image(); ?>
                            </div>
                            <?php if ($product->is_on_sale()) { ?>
                                <div class="product__item-percentages allProduct__item-percentages">
                                    %
                                </div>
                            <?php } ?>
                            <h3 class="product__item-title allProduct__item-title"><?php echo $categories_string; ?></h3>
                            <h3 class="product__item-subtitle allProduct__item-subtitle"><?php echo $product->get_name(); ?></h3>
                            <div class="product__item-demonstration product__demonstration allProduct__demonstraion">
                                <?php
                                $color = get_field('pa_color');
                                if ($color && !empty($color['name']) && !empty($color['img'])) {
                                ?>

                                    <h4 class="product__demonstration-name"><?php echo esc_html($color['name']); ?></h4>
                                    <img src="<?php echo esc_url($color['img']) ?>" alt="color" class="product__demonstration-img">
                                <?php } ?>
                            </div>


                        </a>
                        <div class="product__item_foot">
                            <div class="product__item-prices product__prices">
                                <div class="product__prices-quantity product__quantity">
                                    <?php
                                    // Получаем значения атрибута pa_volume
                                    $volume_terms = wc_get_product_terms($product->get_id(), 'pa_volume', array('fields' => 'all'));

                                    if (!empty($volume_terms) && !is_wp_error($volume_terms)) {
                                        foreach ($volume_terms as $index => $term) {
                                            // Добавляем класс active первому элементу
                                            $class = ($index === 0) ? 'product__quantity-item active' : 'product__quantity-item';
                                            echo '<span class="' . esc_attr($class) . '">' . esc_html($term->name) . '</span>';
                                        }
                                    }
                                    ?>
                                </div>
                                <div>
                                    <?php if ($product->is_on_sale()) : ?>
                                        <div class="product__prices-old"><?php echo $product->get_regular_price(); ?>.00 €</div>
                                        <div class="product__prices-price"><?php echo $product->get_sale_price(); ?>.00 €</div>
                                    <?php else : ?>
                                        <div class="product__prices-price"><?php echo $product->get_regular_price(); ?>.00 €</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="product__item-footer">
                                <div class="product__item-counter product__counter">
                                    <div class="product__counter-minus"></div>
                                    <input type="number" class="product__counter-coll" value="1" min="1">
                                    <div class="product__counter-plus"></div>
                                </div>
                                <form action="<?php echo esc_url($product->add_to_cart_url()); ?>" method="post">
                                    <input type="hidden" name="quantity" class="product-quantity" value="1">
                                    <button type="submit" class="product__item-btn">
                                        <?php echo esc_html($product->add_to_cart_text()); ?>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
            <?php
                }
                wp_reset_postdata();
            }
            ?>
        </div>
    </article>


    <!-- Блок оптовых продаж -->
    <article class="report wholesale">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/bg/wholesale.jpeg" alt="wholesale" class="report__bg wholesale__bg">
        <h2 class="report__title wholesale__title">Are you interested in wholesale purchase?</h2>
        <p class="report__descr wholesale__descr">
            Submit a request for a quote and we will give you an interesting offer
        </p>
        <button class="report__btn wholesale__btn">
            <span>Submit</span>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/arrows/Chevron-Right.svg" alt="arrow-right">
        </button>
    </article>

    <!-- Форма обратной связи -->
    <article class="feedback">
        <div class="feedback__window">
            <h2 class="feedback__title">Let us know if you have any questions</h2>
            <form action="#" class="feedback__form">
                <label class="feedback__label">
                    <input type="text" id="name" name="name" class="feedback__input" required placeholder="Your name*">
                </label>
                <label class="feedback__label">
                    <input type="tel" id="phone" name="phone" class="feedback__input" required placeholder="Your phone number*">
                </label>
                <div class="feedback__wrapper">
                    <span class="feedback__information">
                        All fields with an asterisk (*) are required. By sending this letter, you agree to the processing of <a href="#">personal data</a>
                    </span>
                    <button class="feedback__btn">Send</button>
                </div>
            </form>
        </div>
    </article>
</main>

<?php get_footer('shop');
