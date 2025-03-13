<?php
/*
Template Name: News Archive
*/
get_header();
?>

<main class="news-page">
    <div class="container">
        <h1>News & Updates</h1>
        <div class="news-list">
            <?php
            $news_query = new WP_Query(array(
                'post_type'      => 'post', // Используется стандартный пост
                'posts_per_page' => 10,     // Количество новостей на странице
            ));

            if ($news_query->have_posts()) :
                while ($news_query->have_posts()) : $news_query->the_post(); ?>
                    <article class="news-item">
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <p class="news-date"><?php echo get_the_date(); ?></p>
                        <div class="news-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                    </article>
                <?php endwhile;
                wp_reset_postdata();
            else :
                echo '<p>No news available.</p>';
            endif;
            ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
