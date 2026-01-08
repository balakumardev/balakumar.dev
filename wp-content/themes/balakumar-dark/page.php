<?php
/**
 * Generic Page Template
 */
get_header();
?>

<article class="single-post">
    <?php while (have_posts()) : the_post(); ?>

    <header class="post-header">
        <div class="container">
            <h1><?php the_title(); ?></h1>
        </div>
    </header>

    <div class="post-content">
        <?php the_content(); ?>
    </div>

    <?php endwhile; ?>
</article>

<?php get_footer(); ?>
