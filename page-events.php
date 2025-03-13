<?php
/*
Template Name: Events
*/
get_header();
?>

<main class="events-page">
    <div class="container">
        <h1><?php the_title(); ?></h1>
        <div class="events-content">
            <?php while (have_posts()) : the_post(); ?>
                <?php the_content(); ?>
            <?php endwhile; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
