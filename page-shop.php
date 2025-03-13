<?php
/* Template Name: Catalog Page */
get_header();
?>

<main class="content">
    <!-- Категории -->
    <article class="categories">
        <h1 class="categories__title">Categories</h1>
        <div class="categories__wrapper">
            <?php
            $categories = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => true]);
            foreach ($categories as $category) :
                $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                $image_url = wp_get_attachment_url($thumbnail_id);
            ?>
                <a href="<?php echo get_term_link($category); ?>" class="categories__item">
                    <div class="categories__item-img">
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($category->name); ?>">
                    </div>
                    <div class="categories__item-name">
                        <?php echo esc_html($category->name); ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </article>

    <!-- Товары -->
    <article class="allProduct">
    <h2 class="allProduct__title">All products by Synergy Max</h2>
    <div class="allProduct__wrapper">
        <?php
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => 12,
            'orderby'        => 'date',
            'order'          => 'DESC',
        );
        $query = new WP_Query($args);

        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();
                global $product;

                // Проверяем, есть ли миниатюра у товара
                $image = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                if (!$image) {
                    $image = get_template_directory_uri() . '/assets/img/product/default.png';
                }

                // Получаем цену и проверяем, если пусто - ставим 0
                $regular_price = $product->get_regular_price() ? $product->get_regular_price() : 0;
                $sale_price = $product->get_sale_price() ? $product->get_sale_price() : 0;
                $current_price = $product->get_price() ? $product->get_price() : 0;

                // Категории товара (если нет - "No category")
                $categories = wc_get_product_category_list($product->get_id(), ', ');
                if (!$categories) {
                    $categories = 'No category';
                }

                // Атрибуты товара (цвет, объем) - если нет, то "N/A"
                $colors = $product->get_attribute('pa_color');
                if (!$colors) {
                    $colors = 'N/A';
                }

                $volumes = $product->get_attribute('pa_volume');
                if (!$volumes) {
                    $volumes = ['N/A'];
                } else {
                    $volumes = explode(',', $volumes);
                }
        ?>
<div class="product__item allProduct__item <?php echo $sale_price ? 'product__item-discount' : ''; ?>">
                
    <?php if ($sale_price) : ?>
        <div class="product__item-percentages">%</div>
    <?php endif; ?>

    <div class="product__item-img allProduct__item-img">
        <a href="<?php the_permalink(); ?>">
            <img src="<?php echo esc_url($image); ?>" alt="<?php the_title(); ?>">
        </a>
    </div>

    <div class="product__item-heart allProduct__item-heart">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/product/heart.png" alt="heart">
    </div>

    <?php 
    $categories = strip_tags(wc_get_product_category_list($product->get_id(), ', ')); 
    ?>
    <h3 class="product__item-title allProduct__item-title"><?php echo esc_html($categories); ?></h3>
    <h3 class="product__item-subtitle allProduct__item-subtitle"><?php echo esc_html(get_the_title()); ?></h3>

    <?php
    global $product;
    $attributes = $product->get_attributes();
    error_log(print_r($attributes, true));
    ?>


    <!-- Цвет -->
        <?php 
            $color = $product->get_attribute('color'); // Получаем цвет
            if (!empty($color)) :
            $color_slug = sanitize_title($color); // Делаем slug для изображения
        ?>
        <div class="product__item-demonstration product__demonstration allProduct__demonstration">
            <h4 class="product__demonstration-name"><?php echo esc_html($color); ?></h4>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/<?php echo esc_attr($color_slug); ?>.png" 
                alt="<?php echo esc_attr($color); ?>" 
                class="product__demonstration-img">
        </div>
    <?php endif; ?>

    <!-- Объем -->
        <?php 
            $volume = $product->get_attribute('volume'); // Получаем объем
            if (!empty($volume)) :
        ?>
        <div class="product__prices product__prices">
            <div class="product__prices-quantity product__quantity">
                <span class="product__quantity-item"><?php echo esc_html($volume); ?></span>
            </div>
        </div>
    <?php endif; ?>


    <div class="product__item-footer">
                            <div class="product__item-counter product__counter">
                                <button class="product__counter-minus"></button>
                                <input type="number" class="product__counter-coll" value="1" min="1">
                                <button class="product__counter-plus"></button>
                            </div>

                            <form action="<?php echo esc_url($product->add_to_cart_url()); ?>" method="post">
                                <input type="hidden" name="quantity" class="product-quantity" value="1">
                                <button type="submit" class="product__item-btn">
                                    <?php echo esc_html($product->add_to_cart_text()); ?>
                                </button>
                            </form>
                        </div>  
</div>

        <?php 
            endwhile;
        endif; 

        // Обязательно сбрасываем WP Query
        wp_reset_postdata(); 
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

<?php get_footer(); ?>
