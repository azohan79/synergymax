<?php get_header(); ?>

<main class="content">
    
    <!-- Главный раздел -->
    <article class="mainSection">
        <div class="container">
            <div class="mainSection__wrapper">
                <div class="mainSection__information">
                    <h1 class="mainSection__title">
                        <span>Synergy</span> 
                        of professional knowledge and modern technologies
                    </h1>
                    <h2 class="mainSection__description">Production and sale of nail care product</h2>
                    <a href="<?php echo home_url('/shop/'); ?>" class="mainSection__link">Go to catalog</a>
                </div>
                <div class="mainSection__image">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/bg/bg-main.jpeg" alt="bg-mainSection" class="mainSection__image-img">
                </div>
            </div>                  
        </div>
    </article>

    <!-- Каталог -->
    <article class="initalCatalog">
    <div class="container">
        <div class="initalCatalog__box">
            <div class="initalCatalog__wrapper">

                <div class="column column-1">
                    <div class="initalCatalog__item initalCatalog__item-1">
                        <h2 class="initalCatalog__title">Gel System</h2>
                        <div class="initalCatalog__item-img">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/initalCatalog/gelSystem.png" alt="Gel System">
                        </div>                            
                    </div>
                </div>

                <div class="column column-2">
                    <div class="initalCatalog__item initalCatalog__item-2">
                        <h2 class="initalCatalog__title">Soak Off <br> System</h2>
                        <div class="initalCatalog__item-img">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/initalCatalog/SoakOffSystem.png" alt="Soak Off System">
                        </div>                            
                    </div>
                    <div class="initalCatalog__item initalCatalog__item-3">
                        <h2 class="initalCatalog__title">Poligel</h2>
                        <div class="initalCatalog__item-img">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/initalCatalog/Poligel.png" alt="Poligel">
                        </div>                            
                    </div>   
                </div>

                <div class="column column-3">
                    <div class="initalCatalog__item initalCatalog__item-4">
                        <h2 class="initalCatalog__title">Acrili System</h2>
                        <div class="initalCatalog__item-img">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/initalCatalog/AcrylicSystem.png" alt="Acrylic System">
                        </div>                                
                    </div>    
                    <div class="initalCatalog__item initalCatalog__item-5">
                        <h2 class="initalCatalog__title initalCatalog__title-white">Accessories</h2>
                        <div class="initalCatalog__item-img">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/initalCatalog/Accessories.png" alt="Accessories">
                        </div>                            
                    </div>
                </div>

            </div>
            <a href="<?php echo home_url('/shop/'); ?>" class="initalCatalog__allcatalog">See all categories</a>
        </div>
    </div>
</article>


<article class="report">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/bg/bg-3yare.jpeg.jpeg" alt="bg" class="report__bg">
    
    <h2 class="report__title"><?php echo get_theme_mod('report_title', 'В августе нам исполнилось 3 года!'); ?></h2>
    
    <p class="report__descr">
        <?php echo get_theme_mod('report_description', 'Посмотрите фото и видео-отчет о том, как компания Synergy Max отпраздновала своё трехлетие. Катания на яхте и многое другое.'); ?>
    </p>
    
    <button class="report__btn">
        <span><?php echo get_theme_mod('report_button_text', 'Смотреть'); ?></span>
        <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/arrows/Chevron-Right.svg" alt="arrow-right">
    </button>
    
    <div class="report__pagination">
        <span class="report__pagination-item active"></span>
        <span class="report__pagination-item"></span>
        <span class="report__pagination-item"></span>
        <span class="report__pagination-item"></span>
    </div>
</article>

<article class="product">
    <div class="container">
        <h2 class="product__title">Most popular</h2>
        <div class="product__arrow-prev">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/arrows/Chevron-Right.svg" alt="right arrow" class="product__arrow-img">
        </div>
        <div class="product__arrow-next">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/arrows/Chevron-Right.svg" alt="left arrow" class="product__arrow-img">
        </div>
<div class="product__container">
    <div class="product__wrapper">
        <div class="product__inner">
            <?php
            $args = array(
                'post_type'      => 'product',
                'posts_per_page' => 8,
                'meta_key'       => 'total_sales',
                'orderby'        => 'meta_value_num'
            );
            $loop = new WP_Query($args);

            if ($loop->have_posts()) :
                while ($loop->have_posts()) : $loop->the_post();
                    global $product;
                    ?>
                    <div class="product__item <?php echo $product->is_on_sale() ? 'product__item-discount' : ''; ?>">
                        
                        <?php if ($product->is_on_sale()) : ?>
                            <div class="product__item-percentages">%</div>
                        <?php endif; ?>

                        <div class="product__item-img">
                            <a href="<?php the_permalink(); ?>">
                                <?php if (has_post_thumbnail()) {
                                    the_post_thumbnail('medium');
                                } else { ?>
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/default.png" alt="<?php the_title(); ?>">
                                <?php } ?>
                            </a>
                        </div>

                        <div class="product__item-heart" data-product-id="<?php echo get_the_ID(); ?>">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/product/heart.png" alt="heart">
                        </div>

                        <h3 class="product__item-title"><?php the_title(); ?></h3>
                        <h3 class="product__item-subtitle"><?php echo wc_get_product_category_list($product->get_id()); ?></h3>

                        <!-- Вывод цвета (с изображением) -->
                        <?php 
                        $color = $product->get_attribute('color'); // Получаем цвет
                        if (!empty($color)) :
                            $color_slug = sanitize_title($color); // Делаем slug для изображения
                        ?>
                            <div class="product__item-demonstration product__demonstration">
                                <h4 class="product__demonstration-name"><?php echo esc_html($color); ?></h4>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/<?php echo esc_attr($color_slug); ?>.png" 
                                    alt="<?php echo esc_attr($color); ?>" 
                                    class="product__demonstration-img">
                            </div>
                        <?php endif; ?>
                        <?php 
                        $volume = $product->get_attribute('volume'); // Получаем объем
                        if (!empty($volume)) :
                        ?>
                                <div class="product__item-prices product__prices">
                                    <div class="product__prices-quantity product__quantity">
                                            <span class="product__quantity-item"><?php echo esc_html($volume); ?></span>
                                    </div>
                                    <?php endif; ?>
                                    <div>
                                        <?php if ($product->is_on_sale()) : ?>
                                        <div class="product__prices-old"><?php echo wc_price($product->get_regular_price()); ?></div>
                                        <div class="product__prices-price"><?php echo wc_price($product->get_sale_price()); ?></div>
                                        <?php else : ?>
                                    <div class="product__prices-price"><?php echo wc_price($product->get_regular_price()); ?></div>
                                        <?php endif; ?>
                                    </div>                                   
                                </div>

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
                <?php endwhile;
                wp_reset_postdata();
            else :
                echo '<p>No popular products found.</p>';
            endif;
            ?>
        </div>
    </div>
</div>


    </div>
</article>


<article class="product">
    <div class="container">
        <h2 class="product__title">Most popular</h2>
        <div class="product__arrow-prev">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/arrows/Chevron-Right.svg" alt="right arrow" class="product__arrow-img">
        </div>
        <div class="product__arrow-next">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/arrows/Chevron-Right.svg" alt="left arrow" class="product__arrow-img">
        </div>
        <div class="product__wrapper">
            <div class="product__inner">
                <?php
                // Запрос популярных товаров WooCommerce
                $args = array(
                    'post_type'      => 'product',
                    'posts_per_page' => 6,
                    'meta_key'       => 'total_sales',
                    'orderby'        => 'meta_value_num'
                );
                $loop = new WP_Query($args);

                if ($loop->have_posts()) :
                    while ($loop->have_posts()) : $loop->the_post();
                        global $product;
                        ?>
                        <div class="product__item">
                            <div class="product__item-img">
                                <a href="<?php the_permalink(); ?>">
                                    <?php if (has_post_thumbnail()) {
                                        the_post_thumbnail('medium');
                                    } else { ?>
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/default.png" alt="<?php the_title(); ?>">
                                    <?php } ?>
                                </a>
                            </div>
                            <div class="product__item-heart">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/product/heart.png" alt="heart">
                            </div>
                            <h3 class="product__item-title"><?php the_title(); ?></h3>
                            <h3 class="product__item-subtitle"><?php echo wc_get_product_category_list($product->get_id()); ?></h3>
                            <div class="product__item-demonstration product__demonstration">
                                <h4 class="product__demonstration-name"><?php echo $product->get_attribute('color'); ?></h4>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/smoky-rose.png" alt="color" class="product__demonstration-img">
                            </div>
                            <div class="product__item-prices product__prices">
                                <div class="product__prices-price"><?php echo $product->get_price_html(); ?></div>
                            </div>
                            <div class="product__item-footer">
                                <form class="cart" action="<?php echo esc_url($product->add_to_cart_url()); ?>" method="post" enctype="multipart/form-data">
                                    <button type="submit" class="product__item-btn">
                                        <?php echo esc_html($product->add_to_cart_text()); ?>
                                    </button>
                                </form>
                            </div>  
                        </div>
                    <?php endwhile;
                    wp_reset_postdata();
                else :
                    echo '<p>No popular products found.</p>';
                endif;
                ?>
            </div>
        </div>
    </div>
</article>



    <!-- Блок с новостями -->
 <article class="news">
    <div class="container">
        <div class="news__header">
            <h2 class="news__title">Latest news and publications</h2>
            <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="news__link">View all</a>
        </div>                    
        <div class="news__wrapper">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/arrows/Chevron-Right.svg" alt="arrow-right" class="news__arrow news__arrow-next" id="next">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/arrows/Chevron-Right.svg" alt="arrow-right" class="news__arrow news__arrow-prev" id="prev">
            
            <div class="news__inner">
                <?php
                $args = array(
                    'post_type'      => 'post',
                    'posts_per_page' => 4,
                    'category_name'  => 'news',
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                );
                $news_query = new WP_Query($args);

                if ($news_query->have_posts()) :
                    while ($news_query->have_posts()) : $news_query->the_post();
                        ?>
                        <div class="news__item">
                            <div class="news__item-img">
                                <a href="<?php the_permalink(); ?>">
                                    <?php if (has_post_thumbnail()) {
                                        the_post_thumbnail('medium');
                                    } else { ?>
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/news/default.png" alt="<?php the_title(); ?>">
                                    <?php } ?>
                                </a>
                            </div>
                            <div class="news__item-box">
                                <h3 class="news__item-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                <div class="news__item-descr"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></div>
                                <div class="news__item-date">
                                    <span><?php echo get_the_date('F j, Y'); ?></span> 
                                    <div class="news__item-push">
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/news/Union.svg" alt="union">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile;
                    wp_reset_postdata();
                else :
                    echo '<p>No news found.</p>';
                endif;
                ?>
            </div>
        </div>
    </div>
</article>

<article class="report wholesale">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/bg/wholesale.jpeg" alt="wholesale" class="report__bg wholesale__bg">
    
    <h2 class="report__title wholesale__title">
        <?php echo get_theme_mod('wholesale_title', 'Are you interested in wholesale purchase?'); ?>
    </h2>
    
    <p class="report__descr wholesale__descr">
        <?php echo get_theme_mod('wholesale_description', 'Submit a request for a quote and we will give you an interesting offer.'); ?>
    </p>
    
    <a href="<?php echo esc_url(get_theme_mod('wholesale_button_link', '#')); ?>" class="report__btn wholesale__btn">
        <span><?php echo get_theme_mod('wholesale_button_text', 'Submit'); ?></span>
        <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/arrows/Chevron-Right.svg" alt="arrow-right">
    </a>
    
    <div class="report__pagination wholesale__pagination">
        <span class="report__pagination-item wholesale__pagination-item active"></span>
        <span class="report__pagination-item wholesale__pagination-item"></span>
        <span class="report__pagination-item wholesale__pagination-item"></span>
        <span class="report__pagination-item wholesale__pagination-item"></span>
    </div>
</article>



    <!-- Блок с формой обратной связи -->
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
                    <span class="feedback__information">All fields with an asterisk (*) are required. By sending this letter, you agree to the processing of <a href="#">personal data</a></span>
                    <button class="feedback__btn">Send</button>
                </div>
            </form>
        </div>
    </article>

</main>

<?php get_footer(); ?>
