<?php
/*
Template Name: About Us/PartnerShip
*/
get_header();
?>
<main class="content">
    <article class="aboutMain">
        <div class="aboutMain__container">
            <!-- ACF-поле: main_title -->
            <h1 class="aboutMain__title"><?php the_field('main_title'); ?></h1>

            <!-- ACF-поле: main_subtitle -->
            <h2 class="aboutMain__subtitle"><?php the_field('main_subtitle'); ?></h2>

            <div class="aboutMain__img">
                <!-- ACF-поле: main_image (тип: Image) -->
                <?php 
                $main_image = get_field('main_image');
                if ($main_image) :
                    // $main_image — это массив с url, title и прочими данными
                    echo '<img src="'.esc_url($main_image['url']).'" alt="'.esc_attr($main_image['alt']).'">';
                endif; 
                ?>
            </div>
        </div>
    </article>

    <article class="aboutSectionOne">
        <div class="aboutSectionOne__container">
            
            <h2 class="aboutSectionOne__title"><?php the_field('section_one_title'); ?></h2>

            
            <p class="aboutSectionOne__descr"><?php the_field('section_one_paragraph1'); ?></p>
            <p class="aboutSectionOne__descr"><?php the_field('section_one_paragraph2'); ?></p>

            <div class="aboutSectionOne__wrapper">
                
                <div class="aboutSectionOne__item">
                    <span class="aboutSectionOne__item-title"><?php the_field('stat_1_value'); ?></span>
                    <span class="aboutSectionOne__item-subtitle"><?php the_field('stat_1_label'); ?></span>
                </div>
                <div class="aboutSectionOne__item">
                    <span class="aboutSectionOne__item-title"><?php the_field('stat_2_value'); ?></span>
                    <span class="aboutSectionOne__item-subtitle"><?php the_field('stat_2_label'); ?></span>
                </div>
                <div class="aboutSectionOne__item">
                    <span class="aboutSectionOne__item-title"><?php the_field('stat_3_value'); ?></span>
                    <span class="aboutSectionOne__item-subtitle"><?php the_field('stat_3_label'); ?></span>
                </div>
			    <div class="aboutSectionOne__item">
                    <span class="aboutSectionOne__item-title"><?php the_field('stat_4_value'); ?></span>
                    <span class="aboutSectionOne__item-subtitle"><?php the_field('stat_4_label'); ?></span>
                </div>
            </div>
        </div>
    </article>
                <article class="aboutSectionThree">
                <div class="aboutSectionOne__container">
                    <h2 class="aboutSectionThree__title aboutSectionOne__title"><?php the_field('section_two_title'); ?></h2>
                    <p class="aboutSectionThree__descr aboutSectionOne__descr"><?php the_field('section_two_paragraph1'); ?></p>
                    <ul class="aboutSectionThree__list">
                        <li class="aboutSectionThree__item"><?php the_field('section_two_list_point_1'); ?></li>
                        <li class="aboutSectionThree__item"><?php the_field('section_two_list_point_2'); ?></li>
                        <li class="aboutSectionThree__item"><?php the_field('section_two_list_point_3'); ?></li>
                        <li class="aboutSectionThree__item"><?php the_field('section_two_list_point_4'); ?></li>
                    </ul>
                    <p class="aboutSectionThree__descr aboutSectionOne__descr"><?php the_field('section_two_paragraph2'); ?></p>
                </div>
            </article>
	            <article class="aboutSectionImg">
                <div class="aboutSectionOne__container">
                    <div class="aboutSectionImg__wrapper">
                        <div class="aboutSectionImg__item">
                            <div class="aboutSectionImg__img">
                <?php 
				$block_image_text_img = get_field('block_image_text_img');
				if ($block_image_text_img) :
					echo '<img src="'.esc_url($block_image_text_img['url']).'" alt="'.esc_attr($block_image_text_img['alt']).'">';
				endif;

                ?>
                            </div>
                            <div class="aboutSectionImg__descr"><?php the_field('block_image_text'); ?></div>
                        </div>
                       <div class="aboutSectionImg__item">
                            <div class="aboutSectionImg__descr"><?php the_field('block_text_image_txt'); ?></div>
                            <div class="aboutSectionImg__img">
                <?php 
				$block_text_image = get_field('block_text_image');
				if ($block_text_image) :
					echo '<img src="'.esc_url($block_text_image['url']).'" alt="'.esc_attr($block_text_image['alt']).'">';
				endif;

                ?>
                            </div>                            
                       </div>                       
                    </div>
                    <p class="aboutSectionThree__descr aboutSectionOne__descr"><?php the_field('section_last_paragraph1'); ?></p>
                    <p class="aboutSectionThree__descr aboutSectionOne__descr"><?php the_field('section_last_paragraph2'); ?></p>
                </div>
            </article>
    
    
            <article class="aboutForm">
                <div class="aboutForm__container">
                    <form action="#" class="aboutForm__form">
                        <h3 class="aboutForm__form-title">Contacta con nosotras</h3>
                        <label class="aboutForm__form-label">
                            <input type="name" name="name" class="aboutForm__form-input" required placeholder="Su nombre*"> 
                        </label>
                        <label class="aboutForm__form-label">
                            <input type="email" name="email" class="aboutForm__form-input" required placeholder="Su dirección de correo electrónico*"> 
                        </label>
                        <div class="aboutForm__form-bottom">
                            <p class="aboutForm__form-info">Todos los campos marcados con un asterisco (*) son obligatorios. Al enviar esta carta, usted acepta el procesamiento de<a href="#">datos personales</a></p>
                            <button class="aboutForm__form-btn" type="submit">Enviar</button>
                        </div>                       
                    </form>
                </div>
                
            </article>
    
    <div class="custom-wp-content">
        <?php
        while ( have_posts() ) : the_post(); 
            the_content();
        endwhile;
        ?>
    </div>
</main>
<?php get_footer(); ?>