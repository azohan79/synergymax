<?php
/*
Template Name: News Archive
*/
get_header();
?>

<main class="content">
    <article class="publication">
        <div class="publication__container">


            <h1 class="publication__title"><?php the_title(); ?></h1>

            <?php

            $paged = get_query_var('paged') ? get_query_var('paged') : 1; 
            $args = array(
                'post_type'      => 'post',
                'posts_per_page' => 10,
                'paged'          => $paged,
            );
            $news_query = new WP_Query($args);

            if ($news_query->have_posts()) :

                $all_posts = $news_query->posts;
                $count = count($all_posts);


                if ($count > 0) :
                    $big_post = $all_posts[0];
                    setup_postdata($big_post); 
                    ?>
                    
                    <a href="<?php echo get_permalink($big_post); ?>" class="publication__block">
                        <div class="publication__block-img">
                            <?php 
                            if (has_post_thumbnail($big_post)) {
                                echo get_the_post_thumbnail($big_post, 'large');
                            } else {
                                echo '<img src="' . get_template_directory_uri() . '/assets/img/news/news-main.png" alt="placeholder">';
                            }
                            ?>
                        </div>
                        <div class="publication__block-right">
                            <div class="publication__block-rubric">
                                <?php
                                $cats = get_the_category($big_post->ID);
                                echo !empty($cats) ? esc_html($cats[0]->name) : 'EVENTS';
                                ?>
                            </div>
                            <h2 class="publication__block-title"><?php echo get_the_title($big_post); ?></h2>
                            <div class="publication__block-date">
                                <?php echo get_the_date('F j, Y', $big_post); ?>
                            </div>
                        </div>
                    </a>
                    <?php
                endif; 


                if ($count > 1) :
                    ?>
                    <div class="publication__items">
                        <?php
                        for ($i = 1; $i <= 4; $i++) {
                            if (!isset($all_posts[$i])) break; 
                            $post_item = $all_posts[$i];
                            setup_postdata($post_item);
                            ?>
                            <a href="<?php echo get_permalink($post_item); ?>" class="publication__items-item">
                                <div class="publication__items-item--img">
                                    <?php
                                    if (has_post_thumbnail($post_item)) {
                                        echo get_the_post_thumbnail($post_item, 'medium');
                                    } else {
                                        echo '<img src="' . get_template_directory_uri() . '/assets/img/news/Container.png" alt="placeholder">';
                                    }
                                    ?>
                                </div>
                                <div class="publication__items-item--container">
                                    <div class="publication__items-item--rubric">
                                        <?php
                                        $cats = get_the_category($post_item->ID);
                                        echo !empty($cats) ? esc_html($cats[0]->name) : 'EVENTS';
                                        ?>
                                    </div>
                                    <h3 class="publication__items-item--title"><?php echo get_the_title($post_item); ?></h3>
                                    <h3 class="publication__items-item--date">
                                        <?php echo get_the_date('F j, Y', $post_item); ?>
                                    </h3>
                                </div>
                            </a>
                            <?php
                        } 
                        ?>
                    </div>
                    <?php
                endif; 


                if ($count > 5) :
                    ?>
                    <div class="publication__elements">
                        <?php
                        for ($i = 5; $i <= 10; $i++) {
                            if (!isset($all_posts[$i])) break;
                            $post_item = $all_posts[$i];
                            setup_postdata($post_item);
                            ?>
                            <a href="<?php echo get_permalink($post_item); ?>" class="publication__elements-item">
                                <div class="publication__elements-item--img">
                                    <?php 
                                    if (has_post_thumbnail($post_item)) {
                                        echo get_the_post_thumbnail($post_item, 'thumbnail');
                                    } else {
                                        echo '<img src="' . get_template_directory_uri() . '/assets/img/news/Container-mini1.png" alt="placeholder">';
                                    }
                                    ?>
                                </div>
                                <div class="publication__elements-item--container">
                                    <div class="publication__elements-item--rubric">
                                        <?php
                                        $cats = get_the_category($post_item->ID);
                                        echo !empty($cats) ? esc_html($cats[0]->name) : 'EVENTS';
                                        ?>
                                    </div>
                                    <h3 class="publication__elements-item--title"><?php echo get_the_title($post_item); ?></h3>
                                    <h3 class="publication__elements-item--date">
                                        <?php echo get_the_date('F j, Y', $post_item); ?>
                                    </h3>
                                </div>
                            </a>
                            <?php
                        } // end for
                        ?>
                    </div>
                    <?php
                endif; 


                echo '<a href="#" class="publication__btn">Cargar más</a>';

                wp_reset_postdata();
            else :
                echo '<p>No hay noticias disponibles.</p>';
            endif; 
            ?>
        </div>
    </article>
</main>

<?php get_footer(); ?>
