<?php

/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

get_header('shop'); ?>

<main class="content">
    <?php while (have_posts()) : the_post();
        global $product; ?>

        <article class="coverbase">
            <div class="coverbase__wrapper">
                <div class="coverbase__left">
                    <h2 class="coverbase__subtitle"><?php echo strip_tags(wc_get_product_category_list($product->get_id())); ?></h2>
                    <h1 class="coverbase__title"><?php the_title(); ?></h1>
                    <div class="coverbase__container">
                        <?php
                        $color = get_field('pa_color');
                        if ($color && !empty($color['name']) && !empty($color['img'])) {
                        ?>

                            <div class="coverbase__name"><?php echo esc_html($color['name']); ?></div>
                            <div class="coverbase__color"><img src="<?php echo esc_url($color['img']); ?>" alt="color"></div>
                        <?php } ?>

                    </div>
                    <div class="coverbase__info">
                        <?php echo $product->get_short_description(); ?>
                    </div>
                </div>
                <div class="coverbase__center">
                    <div class="coverbase__center-box">
                        <!-- Основное изображение -->
                        <div class="coverbase__center-img">
                            <?php if (has_post_thumbnail()) {
                                $thumbnail_url = get_the_post_thumbnail_url($product->get_id(), 'full');
                                echo '<img src="' . esc_url($thumbnail_url) . '" id="main-product-image" class="product-image" data-image-url="' . esc_url($thumbnail_url) . '"></img>';
                            } ?>
                        </div>

                        <!-- Стрелки и миниатюры -->
                        <div class="coverbase__center-arrows coverbase__menu">
                            <div class="coverbase__arrows-top coverbase__arrows" id="arrow-top">
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
                            <div class="coverbase__arrows-bottom coverbase__arrows" id="arrow-bottom">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/arrows/Chevron-Right.svg" alt="arrow-bottom">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="coverbase__right">
                    <h3 class="coverbase__right-title">Volumen del producto</h3>
                    <div class="coverbase__right-volume">
                        <?php
                        $volume_terms = wc_get_product_terms($product->get_id(), 'pa_volume', array('fields' => 'all'));

                        if (!empty($volume_terms) && !is_wp_error($volume_terms)) {
                            foreach ($volume_terms as $index => $term) {
                                // Добавляем класс active первому элементу
                                $class = ($index === 0) ? 'coverbase__right-volume--item active' : 'coverbase__right-volume--item';
                                echo '<span class="' . esc_attr($class) . '">' . esc_html($term->name) . '</span>';
                            }
                        } ?>
                    </div>
                    <div class="coverbase__right-quantity">
                        <span class="coverbase__right-quantity--minus"></span>
                        <input type="number" class="coverbase__right-quantity--coll" value="1" min="1">
                        <span class="coverbase__right-quantity--plus"></span>
                    </div>
                    <div class="coverbase__right-price">
                        <div>
                            <h4 class="coverbase__right-price--title">Precio</h4>
							
                            <?php if ($product->is_on_sale()) : ?>
                                <div class="coverbase__right-price--old"><?php echo $product->get_regular_price(); ?> €</div>
                                <div class="coverbase__right-price--new"><?php echo $product->get_sale_price(); ?> €</div>
                            <?php else : ?>
                                <div class="coverbase__right-price--new"><?php echo $product->get_regular_price(); ?> €</div>
                            <?php endif; ?>
                        </div>
                        <form action="<?php echo esc_url($product->add_to_cart_url()); ?>" method="post">
                            <input type="hidden" name="quantity" class="product-quantity" value="1">
                            <button type="submit" class="product__item-btn">
                                <?php echo esc_html($product->add_to_cart_text()); ?>
                            </button>
                        </form>
                    </div>
                    <div class="coverbase__right-information">
                        <p class="coverbase__right-information--info">¿Eres una empresa? Si deseas comprar productos a precio mayorista, completa la solicitud y nos pondremos en contacto contigo.</p>
                        <button class="coverbase__right-information--btn">Solicitar precios al por mayor</button>
                    </div>
                </div>
        </article>
        <article class="information">
            <div class="information__block">
                <div class="information__item">
                    <h2 class="information__item-name">Descripción del Producto</h2>
                    <div class="information__item-icon">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/arrows/Chevron-Right.svg" alt="shewron">
                    </div>
                </div>
                <div class="information__description">
                    <?php echo $product->get_description(); ?>
                </div>
            </div>
            <?php
            if (have_rows('information')) :
                while (have_rows('information')) : the_row();
            ?>
                    <div class="information__block">
                        <div class="information__item">
                            <h2 class="information__item-name"><?php the_sub_field('name') ?></h2>
                            <div class="information__item-icon">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/arrows/Chevron-Right.svg" alt="shewron">
                            </div>
                        </div>
                        <div class="information__description">
                            <?php the_sub_field('text') ?>
                        </div>
                    </div>
            <?php
                endwhile;
            else :
            endif;
            ?>

        </article>
    <?php endwhile;
    $categories = wp_get_post_terms($product->get_id(), 'product_cat', array('fields' => 'ids'));
    $similar_products_args = array(
        'post_type' => 'product',
        'posts_per_page' => 10,
        'post__not_in' => array($product->get_id()),
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'id',
                'terms' => $categories,
            ),
        ),
    );
    $similar_products = new WP_Query($similar_products_args);

    if ($similar_products->have_posts()) : ?>
        <article class="product">
            <h2 class="product__title">Recomendamos comprar con este producto.</h2>
            <div class="splide" role="group" aria-label="Splide Basic HTML Example">
                <div class="splide__track">
                    <ul class="splide__list">
                        <?php while ($similar_products->have_posts()) : $similar_products->the_post();
                            // Получаем категории товара
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
    <?php
    // Получаем самые популярные товары
    $popular_products_args = array(
        'post_type' => 'product',
        'posts_per_page' => 10, // Количество популярных товаров
        'post__not_in' => array($product->get_id()),
        'meta_key' => 'total_sales', // Сортируем по количеству продаж
        'orderby' => 'meta_value_num', // Сортировка по числовому значению
        'order' => 'DESC', // По убыванию
    );

    $popular_products = new WP_Query($popular_products_args);

    if ($popular_products->have_posts()) : ?>
        <article class="product">
            <h2 class="product__title">Otros están comprando con este producto</h2>
            <div class="splide" id="slider2" role="group" aria-label="Splide Basic HTML Example">
                <div class="splide__track">
                    <ul class="splide__list">
                        <?php while ($popular_products->have_posts()) : $popular_products->the_post();
                            // Получаем категории товара
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
     <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Получаем элементы
            const mainImage = document.getElementById('main-product-image'); // Основное изображение
            const arrowTop = document.getElementById('arrow-top'); // Стрелка вверх
            const arrowBottom = document.getElementById('arrow-bottom'); // Стрелка вниз

            // Проверяем, что элементы найдены
            if (!mainImage || !arrowTop || !arrowBottom) {
                console.error('Один или несколько элементов не найдены!');
                return;
            }

            // Собираем все URL изображений в массив
            const imageUrls = [
                <?php
                $attachment_ids = $product->get_gallery_image_ids();
                if ($attachment_ids) {
                    foreach ($attachment_ids as $attachment_id) {
                        echo "'" . wp_get_attachment_url($attachment_id) . "',";
                    }
                }
                ?>
            ];

            // Проверяем, что массив imageUrls не пуст
            if (imageUrls.length === 0) {
                console.error('Массив imageUrls пуст!');
                return;
            }

            let currentIndex = 1; // Текущий индекс изображения

            // Функция для обновления изображения
            function updateImage() {
                if (mainImage && imageUrls[currentIndex]) {
                    mainImage.src = imageUrls[currentIndex]; // Устанавливаем src для img
                    console.log('Текущее изображение:', imageUrls[currentIndex]);
                } else {
                    console.error('Ошибка при обновлении изображения!');
                }
            }

            // Обработчик для стрелки вверх
            arrowTop.addEventListener('click', function() {
                console.log('Стрелка вверх нажата');
                currentIndex = (currentIndex - 1 + imageUrls.length) % imageUrls.length; // Переключаем на предыдущее изображение
                updateImage();
            });

            // Обработчик для стрелки вниз
            arrowBottom.addEventListener('click', function() {
                console.log('Стрелка вниз нажата');
                currentIndex = (currentIndex + 1) % imageUrls.length; // Переключаем на следующее изображение
                updateImage();
            });
            const counter1 = document.querySelector(".coverbase__right-quantity");
            const params = document.querySelectorAll(".coverbase__right-volume--item"); // Исправлено: добавлена точка перед классом

            // Обработка кликов на элементы с классом product__quantity-item
            params.forEach(param => {
                param.addEventListener("click", function() {
                    // Убираем класс active у всех элементов
                    params.forEach(p => p.classList.remove("active"));
                    // Добавляем класс active текущему элементу
                    this.classList.add("active");
                });
            });
            const minus1 = counter1.querySelector(".coverbase__right-quantity--minus");
            const plus1 = counter1.querySelector(".coverbase__right-quantity--plus");
            const input1 = counter1.querySelector(".coverbase__right-quantity--coll");
            const form1 = counter1.closest(".coverbase__right").querySelector("form");
            const hiddenQuantity1 = form1.querySelector("input[name='quantity']");

            if (minus1 && plus1 && input1 && form1 && hiddenQuantity1) {
                minus1.addEventListener("click", function() {
                    let value = parseInt(input1.value);
                    if (value > 1) {
                        input1.value = value - 1;
                        hiddenQuantity1.value = input1.value; // Обновляем скрытое поле
                    }
                });

                plus1.addEventListener("click", function() {
                    let value = parseInt(input1.value);
                    input1.value = value + 1;
                    hiddenQuantity1.value = input1.value; // Обновляем скрытое поле
                });

                input1.addEventListener("change", function() {
                    if (input1.value < 1 || isNaN(input1.value)) {
                        input1.value = 1;
                    }
                    hiddenQuantity1.value = input1.value; // Обновляем скрытое поле
                });

                // При отправке формы передаем актуальное количество
                form1.addEventListener("submit", function(e) {
                    hiddenQuantity1.value = input1.value;
                });
            }
            // Инициализация (вывод первого изображения)
            updateImage();
        });
    </script>

</main>
<?php get_footer('shop'); ?>