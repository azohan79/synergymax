<?php

/**
 * The Template for displaying products in a product category. Simply includes the archive template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/taxonomy-product-cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     4.7.0
 */

defined('ABSPATH') || exit;
get_header('shop'); ?>
<main class="content">
	<article class="category">
		<div class="category__container">
			<div class="category__box">
				<h1 class="category__box-title"><?php single_term_title(); ?></h1> <!-- Название категории -->
				<div class="category__box-img">
					<?php
					// Получаем кастомное изображение категории через ACF
					$initialImage = get_field('img', 'term_' . get_queried_object_id());

					// Если кастомное изображение есть, выводим его
					if ($initialImage) {
						echo '<img src="' . esc_url($initialImage) . '" alt="' . esc_attr(single_term_title('', false)) . '">';
					} else {
						// Если кастомного изображения нет, получаем стандартное изображение категории WooCommerce
						$thumbnail_id = get_term_meta(get_queried_object_id(), 'thumbnail_id', true);
						if ($thumbnail_id) {
							$image = wp_get_attachment_image_url($thumbnail_id, 'full');
							echo '<img src="' . esc_url($image) . '" alt="' . esc_attr(single_term_title('', false)) . '">';
						} else {
							// Если стандартного изображения тоже нет, выводим заглушку
							echo '<img src="' . get_template_directory_uri() . '/assets/img/default-category-image.png" alt="' . esc_attr(single_term_title('', false)) . '">';
						}
					}
					?>
				</div>
			</div>

			<div class="category__wrapper">
				<?php
				if (have_posts()) {
					while (have_posts()) {
						the_post();
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
				<?php
					}
				} else {
					// Если товаров нет
					echo '<p>No se encontraron productos en esta categoría.</p>';
				}
				?>
			</div>
		</div>
	</article>
	<!-- Блок оптовых продаж -->
	<article class="report wholesale">
		<img src="<?php echo get_template_directory_uri(); ?>/assets/img/bg/wholesale.jpeg" alt="wholesale" class="report__bg wholesale__bg">
		<h2 class="report__title wholesale__title">¿Estas interesado en comprar al por mayor?</h2>
		<p class="report__descr wholesale__descr">
			Envíenos una solicitud de cotización y le haremos una oferta interesante.
		</p>
		<button class="report__btn wholesale__btn">
			<span>Entregar</span>
			<img src="<?php echo get_template_directory_uri(); ?>/assets/icons/arrows/Chevron-Right.svg" alt="arrow-right">
		</button>
	</article>

	<!-- Форма обратной связи -->
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
					<span class="feedback__information">
						Todos los campos marcados con un asterisco (*) son obligatorios. Al enviar esta carta, usted acepta el procesamiento de <a href="#">datos personales</a>
					</span>
					<button class="feedback__btn">Enviar</button>
				</div>
			</form>
		</div>
	</article>
</main>

<?php get_footer('shop'); ?>