<?php
/*
Template Name: Text
*/
get_header();
?>

<main class="content">
    <article class="text">
        <div class="text__container">

            <!-- Заголовок H1 (ACF: text_title_h1) -->
            <h1 class="text__title"><?php the_field('text_title_h1'); ?></h1>

            <!-- Подзаголовок H2 (ACF: text_subtitle_h2) -->
            <h2 class="text__subtitle"><?php the_field('text_subtitle_h2'); ?></h2>

            <!-- Первые два абзаца -->
            <p class="text__descr"><?php the_field('text_descr1'); ?></p>
            <p class="text__descr"><?php the_field('text_descr2'); ?></p>

            <!-- Заголовок H3 -->
            <h3 class="text__name"><?php the_field('text_name_h3'); ?></h3>
            <p class="text__descr"><?php the_field('text_descr3'); ?></p>

            <!-- Список (пример через ACF Repeater) -->
            <?php if ( have_rows('text_list') ): ?>
                <ul class="text__list">
                    <?php while ( have_rows('text_list') ) : the_row(); 
                        $item_text = get_sub_field('list_item_text'); // подполье
                    ?>
                        <li class="text__item"><?php echo esc_html($item_text); ?></li>
                    <?php endwhile; ?>
                </ul>
            <?php endif; ?>

            <!-- Ещё несколько абзацев -->
            <p class="text__descr"><?php the_field('text_descr4'); ?></p>
            <p class="text__descr"><?php the_field('text_descr5'); ?></p>
            <p class="text__descr"><?php the_field('text_descr6'); ?></p>

            <!-- Две ссылки в конце (с иконками) -->
            <div class="list__links">
                <a href="<?php the_field('link_1_url'); ?>" class="list__links-link">
                    <span class="list__links-text"><?php the_field('link_1_text'); ?></span>
                    <div class="list__links-icon">
                        <?php 
                        // Если хотите загружать иконку через ACF поле (Image):
                        $link_1_icon = get_field('link_1_icon');
                        if ( $link_1_icon ) {
                            echo '<img src="' . esc_url($link_1_icon['url']) . '" alt="' . esc_attr($link_1_icon['alt']) . '">';
                        } else {
                            // fallback: используем вашу статич. иконку
                            echo '<img src="' . get_template_directory_uri() . '/assets/icons/arrows/Chevron-Right-blue.svg" alt="Arrow">';
                        }
                        ?>
                    </div>
                </a>
                <a href="<?php the_field('link_2_url'); ?>" class="list__links-link">
                    <span class="list__links-text"><?php the_field('link_2_text'); ?></span>
                    <div class="list__links-icon">
                        <?php
                        $link_2_icon = get_field('link_2_icon');
                        if ( $link_2_icon ) {
                            echo '<img src="' . esc_url($link_2_icon['url']) . '" alt="' . esc_attr($link_2_icon['alt']) . '">';
                        } else {
                            // fallback: иконка play
                            echo '<img src="' . get_template_directory_uri() . '/assets/icons/play/Play-Circle.svg" alt="Play">';
                        }
                        ?>
                    </div>
                </a>
            </div><!-- /.list__links -->

        </div><!-- /.text__container -->
    </article>

   
    <?php
    while ( have_posts() ) : the_post();
        the_content();
    endwhile;
    ?>
</main>

<?php get_footer(); ?>

