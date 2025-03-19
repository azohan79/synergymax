<?php get_header(); ?>

<main class="content">

    <?php 

    while ( have_posts() ) : the_post(); 
    ?>
        

        <article class="newsPageMain">

            <h1 class="newsPageMain__title"><?php the_title(); ?></h1>


            <h2 class="newsPageMain__subtitle">
                <?php the_field('main_subtitle'); ?>
            </h2>


            <p class="newsPageMain__date"><?php echo get_the_date('F j, Y'); ?></p>

            <div class="newsPageMain__image">
                <?php 
                if ( has_post_thumbnail() ) {
                    the_post_thumbnail('large', [
                        'alt' => esc_attr( get_the_title() ),
                    ]);
                } else {
                    echo '<img src="' . get_template_directory_uri() . '/assets/img/news/news-page.png" alt="fallback">';
                }
                ?>
            </div>
        </article>


        <article class="newsPageDescr">

            <h2 class="newsPageDescr__title"><?php the_field('main_subtitle_h2'); ?></h2>
            
            <div class="newsPageDescr__descr">
                <?php the_content(); ?>
            </div>
            
            <h3 class="newsPageDescr__subtitle"><?php the_field('descr_subtitle_h3'); ?></h3>
            <p class="newsPageDescr__descr"><?php the_field('descr_text'); ?></p>
            <ul class="newsPageDescr__list">
                <li class="newsPageDescr__item"><?php the_field('descr_list_point'); ?></li>
                <li class="newsPageDescr__item"><?php the_field('descr_list_point1'); ?></li>
                <li class="newsPageDescr__item"><?php the_field('descr_list_point2'); ?></li>
                <li class="newsPageDescr__item"><?php the_field('descr_list_point3'); ?></li>
            </ul>
            <p class="newsPageDescr__descr newsPageDescr__descr-last">
                <?php the_field('descr_text2'); ?>
            </p>
            <div class="newsPageDescr__image">
				<?php 
				$dop_img = get_field('dop_img');
				if ( $dop_img ) :
					echo '<img src="'.esc_url($dop_img['url']).'" alt="'.esc_attr($dop_img['alt']).'">';
				endif; 
				?>

            </div>
            <div class="newsPageDescr__alt"><?php the_field('photo_comment'); ?></div>
            <p class="newsPageDescr__descr"><?php the_field('stat_text'); ?></p>
            <p class="newsPageDescr__descr newsPageDescr__descr-last"><?php the_field('stat_text1'); ?></p>
			<div class="newsPageDescr__mores">
				<?php 
				$link1 = get_field('link1');
				if ( $link1 ) : ?>
					<a href="<?php echo esc_url($link1); ?>" class="newsPageDescr__more">
						<span>Ejemplo de estilo de enlace para aprender más</span>
						<img src="<?php echo get_template_directory_uri(); ?>/assets/icons/arrows/Chevron-Right-blue.svg" alt="chewron-blue">
					</a>
				<?php endif; ?>

				<?php 
				$video_link = get_field('video_link');
				if ( $video_link ) : ?>
					<a href="<?php echo esc_url($video_link); ?>" class="newsPageDescr__more newsPageDescr__video">
						<span>Ver vídeo</span>
						<img src="<?php echo get_template_directory_uri(); ?>/assets/icons/news/Play-Circle.svg" alt="Play-Circle">
					</a>
				<?php endif; ?>
			</div>

        </article>

    <?php 

    endwhile; 
    ?>

 
    <article class="news">    
        <div class="news__container">
            <div class="news__header">
                <h2 class="news__title">Últimas noticias y publicaciones</h2>
                <a href="/news/" class="news__link">Ver todo</a>
            </div>

            <?php
            $args = array(
                'post_type'      => 'post',
                'posts_per_page' => 5,
                'orderby'        => 'date',
                'order'          => 'DESC',
                'ignore_sticky_posts' => true,
                'post__not_in' => array( get_the_ID() ), 
            );

            $slider_query = new WP_Query($args);

            if ( $slider_query->have_posts() ) : 
            ?>
                <div class="splide" id="slider1" role="group" aria-label="Splide">
                    <div class="splide__track">
                        <ul class="splide__list">
                            <?php
                            while ( $slider_query->have_posts() ) : $slider_query->the_post();
                            ?>
                                <li class="splide__slide">
                                    <a href="<?php the_permalink(); ?>" class="news__item">
                                        <div class="news__item-img">
                                            <?php 
                                            if ( has_post_thumbnail() ) {
                                                the_post_thumbnail('thumbnail');
                                            } else {
                                                ?>
                                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/news/image.png" alt="no image">
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="news__item-box">
                                            <h3 class="news__item-title"><?php the_title(); ?></h3>
                                            <div class="news__item-descr">
                                                <?php the_excerpt(); ?>
                                            </div>
                                            <div class="news__item-date">
                                                <span><?php echo get_the_date('F j, Y'); ?></span>
                                                <div class="news__item-push">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/news/Union.svg" alt="union">
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            <?php
                            endwhile;
                            ?>
                        </ul>
                    </div>
                </div>
                <?php
                wp_reset_postdata();
                ?>

            <?php else : ?>
                <p>No se encontraron noticias relacionadas.</p>
            <?php endif; ?>
        </div>
    </article>

</main>

<script>
	document.addEventListener('DOMContentLoaded', function() {
  var splide = new Splide('#slider1', {
    type: 'loop',
    perPage: 5,
    gap: '1rem',
  });
  splide.mount();
});

</script>


<?php get_footer(); ?>
