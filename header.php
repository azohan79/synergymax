<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>
    <?php if (!is_front_page()) : ?>
    <div class="body__container">
    <div class="menuBack">
        <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="menuBack__back">
            <div class="menuBack__back-arrow">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/arrows/Chevron-Right.svg" alt="chevron">
            </div>
            <div class="menuBack__back-name">Atrás</div>
        </a>
        <div class="menuBack__navigation">
            <a href="<?php echo home_url(); ?>" class="menuBack__navigation-home">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/catalog/Home.svg" alt="home">
            </a>
            <div class="menuBack__navigation-chevron">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/arrows/Chevron-Right.svg" alt="Chevron-Right">
            </div>

            <?php if (is_singular('product')) : ?>
                
                <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="menuBack__navigation-name">Catalogar</a>
                <div class="menuBack__navigation-chevron">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/arrows/Chevron-Right.svg" alt="Chevron-Right">
                </div>
                <?php
                $terms = get_the_terms(get_the_ID(), 'product_cat');
                if (!empty($terms)) :
                    $main_cat = array_shift($terms); ?>
                    <a href="<?php echo get_term_link($main_cat); ?>" class="menuBack__navigation-name"><?php echo esc_html($main_cat->name); ?></a>
                    <div class="menuBack__navigation-chevron">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/arrows/Chevron-opacity-Right.svg" alt="Chevron-opacity-Right">
                    </div>
                <?php endif; ?>
                <a href="<?php the_permalink(); ?>" class="menuBack__navigation-name"><?php the_title(); ?></a>

            <?php elseif (is_tax('product_cat')) : ?>
                
                <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="menuBack__navigation-name">Catalogar</a>
                <div class="menuBack__navigation-chevron">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/arrows/Chevron-Right.svg" alt="Chevron-Right">
                </div>
                <a href="<?php echo get_term_link(get_queried_object()); ?>" class="menuBack__navigation-name"><?php single_term_title(); ?></a>
            <?php elseif (is_shop()) : ?>
                
                <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="menuBack__navigation-name">Catalogar</a>
            <?php elseif (is_page() && !is_shop()) : ?>
                
                <a href="<?php the_permalink(); ?>" class="menuBack__navigation-name"><?php the_title(); ?></a>

            <?php elseif (is_single() && !is_singular('product')) : ?>
                
                <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="menuBack__navigation-name">Blog</a>
                <div class="menuBack__navigation-chevron">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/arrows/Chevron-opacity-Right.svg" alt="Chevron-opacity-Right">
                </div>
                <a href="<?php the_permalink(); ?>" class="menuBack__navigation-name"><?php the_title(); ?></a>

            <?php elseif (is_category()) : ?>
                
                <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="menuBack__navigation-name">Blog</a>
                <div class="menuBack__navigation-chevron">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/arrows/Chevron-opacity-Right.svg" alt="Chevron-opacity-Right">
                </div>
                <a href="<?php echo get_term_link(get_queried_object()); ?>" class="menuBack__navigation-name"><?php single_cat_title(); ?></a>

            <?php endif; ?>
        </div>
    </div>
    </div>
<?php endif; ?>
<div class="body__container">
    <header class="header">
        <div class="container">
            <div class="header__wrapper">

                
                <ul class="header__left">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'container'      => false, 
                        'items_wrap'     => '%3$s',
                        'walker'         => new Synergymax_Walker_Nav()
                    ));
                    ?>
                </ul>

                
                <a href="<?php echo home_url(); ?>" class="header__logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/logo/logo.png" alt="logo" class="header__logo-img">
                </a>

                
                <ul class="header__right">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'secondary',
                        'container'      => false,
                        'items_wrap'     => '%3$s',
                        'walker'         => new Synergymax_Walker_Nav()
                    ));
                    ?>
                </ul>

                
                <div class="header__final">
                    <div class="header__user header__final-item">
						<a href="/my-account/">
							<img src="<?php echo get_template_directory_uri(); ?>/assets/icons/header/User.png" alt="user" class="header__user-img"></a>
                    </div>
							<?php 
							
							if ( function_exists( 'WC' ) ) {
								
								$count = WC()->cart->get_cart_contents_count();
							} else {
								$count = 0;
							}
							?>

							<a href="<?php echo wc_get_cart_url(); ?>" class="header__shoping header__final-item">
								<img 
									src="<?php echo get_template_directory_uri(); ?>/assets/icons/header/Shopping-Cart.png" 
									alt="shopping" 
									class="header__shoping-img"
								>
								<?php if ( $count > 0 ) : ?>
									
									<span class="cart-count"><?php echo $count; ?></span>
								<?php endif; ?>
							</a>

                    <div class="header__menu header__final-item">
                        <span class="header__menu-item"></span>
                        <span class="header__menu-item"></span>
                        <span class="header__menu-item"></span>
                    </div>
                </div>

            </div>
        </div>

    </header>