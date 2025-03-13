<?php
/*
Template Name: Contacts
*/
get_header();
?>

<main class="contacts-page">
    <div class="container">
        <h1><?php the_title(); ?></h1>
        <div class="contacts-content">
            <?php while (have_posts()) : the_post(); ?>
                <?php the_content(); ?>
            <?php endwhile; ?>

            <!-- Форма обратной связи -->
            <form action="#" method="POST" class="contact-form">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Your Email</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Your Message</label>
                <textarea id="message" name="message" required></textarea>

                <button type="submit">Send Message</button>
            </form>
        </div>
    </div>
</main>

<?php get_footer(); ?>
