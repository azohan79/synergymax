<?php get_header(); ?>

<main class="content">
    
    <!-- Главный раздел -->
    <article class="mainSection">
        <div class="container">
            <div class="mainSection__wrapper">
                <div class="mainSection__information">
                    <h1 class="mainSection__title">
                        <span>Synergy</span> 
                        de conocimientos profesionales y tecnologías modernas
                    </h1>
                    <h2 class="mainSection__description">Producción y venta de productos para el cuidado de las uñas.</h2>
                    <a href="<?php echo home_url('/shop/'); ?>" class="mainSection__link">Ir al catálogo</a>
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
                        <h2 class="initalCatalog__title">Sistema de gel</h2>
                        <div class="initalCatalog__item-img">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/initalCatalog/gelSystem.png" alt="Gel System">
                        </div>                            
                    </div>
                </div>

                <div class="column column-2">
                    <div class="initalCatalog__item initalCatalog__item-2">
                        <h2 class="initalCatalog__title">Remojo <br> Systema</h2>
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
                        <h2 class="initalCatalog__title">Acrilic Systema</h2>
                        <div class="initalCatalog__item-img">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/initalCatalog/AcrylicSystem.png" alt="Acrylic System">
                        </div>                                
                    </div>    
                    <div class="initalCatalog__item initalCatalog__item-5">
                        <h2 class="initalCatalog__title initalCatalog__title-white">Accesorios</h2>
                        <div class="initalCatalog__item-img">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/initalCatalog/Accessories.png" alt="Accessories">
                        </div>                            
                    </div>
                </div>

            </div>
            <a href="<?php echo home_url('/shop/'); ?>" class="initalCatalog__allcatalog">Ver todas las categorías</a>
        </div>
    </div>
</article>


<article class="report">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/bg/bg-3yare.jpeg.jpeg" alt="bg" class="report__bg">
    
    <h2 class="report__title"><?php echo get_theme_mod('report_title', 'Pronto estaremos en una exposición en Italia.'); ?></h2>
    
    <p class="report__descr">
        <?php echo get_theme_mod('report_description', 'Vea el reportaje fotográfico y en vídeo sobre cómo Synergy Max participó en la exposición.'); ?>
    </p>
    
    <button class="report__btn">
        <span><?php echo get_theme_mod('report_button_text', 'Mirar'); ?></span>
        <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/arrows/Chevron-Right.svg" alt="arrow-right">
    </button>
    
    <div class="report__pagination">
        <span class="report__pagination-item active"></span>
        <span class="report__pagination-item"></span>
        <span class="report__pagination-item"></span>
        <span class="report__pagination-item"></span>
    </div>
</article>

	<?php
// Получаем самые популярные товары
$args = array(
    'post_type' => 'product',
    'posts_per_page' => 10, // Количество популярных товаров
    'meta_key' => 'total_sales', // Сортируем по количеству продаж
    'orderby' => 'meta_value_num', // Сортировка по числовому значению
    'order' => 'DESC', // По убыванию
);

$popular_products = new WP_Query($args);

if ($popular_products->have_posts()) : ?>
    <article class="product">
        <h2 class="product__title">Otros están comprando con este producto</h2>
        <div class="splide" id="slider2">
            <div class="splide__track">
                <ul class="splide__list">
                    <?php while ($popular_products->have_posts()) : $popular_products->the_post(); 
                        global $product; // Вот правильное место для получения глобального объекта
                        
                        // Далее ваш код без изменений
                        $terms = get_the_terms($product->get_id(), 'product_cat');
                        $category_names = [];

                        if ($terms && !is_wp_error($terms)) {
                            foreach ($terms as $term) {
                                $category_names[] = $term->name; // Собираем названия категорий
                            }
                        }

                        $categories_string = implode(', ', $category_names); ?>
                        <li class="splide__slide">
                            <div class="product__item">
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
										if ($product->is_type('variable')) {
											$variations = $product->get_available_variations();

											foreach ($variations as $index => $variation) {
												$class = ($index === 0) ? 'product__quantity-item active' : 'product__quantity-item';
												$variation_id = $variation['variation_id'];
												$variation_obj = wc_get_product($variation_id);

												// Получаем цены
												$regular_price = $variation_obj->get_regular_price();
												$sale_price = $variation_obj->get_sale_price();

												// Сохраняем данные о ценах в атрибутах
												echo '<span class="' . esc_attr($class) . '" data-variation-id="' . esc_attr($variation_id) . '" data-regular-price="' . esc_attr($regular_price) . '" data-sale-price="' . esc_attr($sale_price) . '">';
												echo esc_html(implode(', ', $variation['attributes']));
												echo '</span>';
											}
										}
										?>
									</div>
									<div class="product__prices-price">
										<?php
										if ($product->is_type('variable')) {
											// Получаем данные первой вариации
											$first_variation = $variations[0];
											$first_variation_obj = wc_get_product($first_variation['variation_id']);
											$first_regular_price = $first_variation_obj->get_regular_price();
											$first_sale_price = $first_variation_obj->get_sale_price();

											// Выводим цену для первой вариации
											if ($first_sale_price) {
												echo '<div class="product__prices-old">' . wc_price($first_regular_price) . '</div>';
												echo '<div class="product__prices-price">' . wc_price($first_sale_price) . '</div>';
											} else {
												echo '<div class="product__prices-price">' . wc_price($first_regular_price) . '</div>';
											}
										} else {
											// Для простых товаров
											if ($product->is_on_sale()) {
												echo '<div class="product__prices-old">' . wc_price($product->get_regular_price()) . '</div>';
												echo '<div class="product__prices-price">' . wc_price($product->get_sale_price()) . '</div>';
											} else {
												echo '<div class="product__prices-price">' . wc_price($product->get_regular_price()) . '</div>';
											}
										}
										?>
									</div>
								</div>
								<div class="product__item-footer">
									<div class="product__item-counter product__counter">
										<div class="product__counter-minus"></div>
										<input type="number" class="product__counter-coll" value="1" min="1">
										<div class="product__counter-plus"></div>
									</div>
									<?php

									if ($product->is_type('variable')) {
										$first_variation = $variations[0];
										$first_variation_obj = wc_get_product($first_variation['variation_id']); ?>
										<form action="?add-to-cart=<?php echo esc_attr($first_variation['variation_id']); ?>" method="post">
											<input type="hidden" name="quantity" class="product-quantity" value="1">
											<button type="submit" class="product__item-btn">
												<?php echo esc_html($first_variation_obj->add_to_cart_text()); ?>
											</button>
										</form>
									<?php } else { ?>
										<form action="<?php echo esc_url($product->add_to_cart_url()); ?>" method="post">
											<input type="hidden" name="quantity" class="product-quantity" value="1">
											<button type="submit" class="product__item-btn">
												<?php echo esc_html($product->add_to_cart_text()); ?>
											</button>
										</form>
									<?php } ?>
								</div>
							</div>
                                </div>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        </article>
        <?php wp_reset_postdata(); ?>
    <?php endif; ?>


    
 <article class="news">
    <div class="container">
        <div class="news__header">
            <h2 class="news__title">Últimas noticias y publicaciones</h2>
            <a href="/news/" class="news__link">Ver todo</a>
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
        <?php echo get_theme_mod('wholesale_title', '¿Estas interesado en comprar al por mayor?'); ?>
    </h2>
    
    <p class="report__descr wholesale__descr">
        <?php echo get_theme_mod('wholesale_description', 'Envíenos una solicitud de presupuesto y le haremos una oferta interesante.'); ?>
    </p>
    
	    <button class="report__btn">
        <span><?php echo get_theme_mod('report_button_text', 'Entregar'); ?></span>
        <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/arrows/Chevron-Right.svg" alt="arrow-right">
        </button>
	
    
    <div class="report__pagination wholesale__pagination">
        <span class="report__pagination-item wholesale__pagination-item active"></span>
        <span class="report__pagination-item wholesale__pagination-item"></span>
        <span class="report__pagination-item wholesale__pagination-item"></span>
        <span class="report__pagination-item wholesale__pagination-item"></span>
    </div>
</article>



    
    <article class="feedback">
        <div class="feedback__window">
            <h2 class="feedback__title">Déjanos saber si tienes alguna pregunta.</h2>
            <form action="#" class="feedback__form">
                <label class="feedback__label">
                    <input type="text" id="name" name="name" class="feedback__input" required placeholder="Su nombre*">
                </label>
                <label class="feedback__label">
                    <input type="tel" id="phone" name="phone" class="feedback__input" required placeholder="Tu número de teléfono*">
                </label>
                <div class="feedback__wrapper">
                    <span class="feedback__information">Todos los campos marcados con un asterisco (*) son obligatorios. Al enviar esta carta, usted acepta el procesamiento de <a href="#">datos personales</a></span>
                    <button class="feedback__btn">Enviar</button>
                </div>
            </form>
        </div>
    </article>

</main>

<script>
	document.addEventListener('DOMContentLoaded', function() {
  
  var splideElement = document.getElementById('slider-popular-home');
  if (splideElement) {
    var splide = new Splide('#slider-popular-home', {
      type: 'loop',
      perPage: 5,
      gap: '1rem',
      
    });
    splide.mount();
  }

 
});
</script>

<?php get_footer(); ?>