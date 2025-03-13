<?php
/*
Template Name: Partnership
*/
get_header();
?>

<main class="partnership-page">
    <div class="container">
        <h1><?php the_title(); ?></h1>
        <div class="partnership-content">
            <?php while (have_posts()) : the_post(); ?>
                <?php the_content(); ?>
            <?php endwhile; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
