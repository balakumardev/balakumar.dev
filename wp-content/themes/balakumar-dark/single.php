<?php
/**
 * Single Post Template
 */
get_header();
?>

<article class="single-post">
    <?php while (have_posts()) : the_post(); ?>

    <header class="post-header">
        <div class="container">
            <div class="meta">
                <?php echo get_the_date(); ?>
                <?php if (get_the_category()) : ?>
                    &bull; <?php the_category(', '); ?>
                <?php endif; ?>
            </div>
            <h1><?php the_title(); ?></h1>
        </div>
    </header>

    <div class="post-content">
        <?php if (has_post_thumbnail()) : ?>
        <figure class="post-thumbnail">
            <?php the_post_thumbnail('large'); ?>
        </figure>
        <?php endif; ?>

        <?php the_content(); ?>

        <?php if (get_the_tags()) : ?>
        <div class="post-tags" style="margin-top: 3rem;">
            <strong>Tags:</strong>
            <?php the_tags('', ', '); ?>
        </div>
        <?php endif; ?>
    </div>

    <nav class="post-navigation" style="max-width: 800px; margin: 0 auto; padding: 2rem; display: flex; justify-content: space-between; border-top: 1px solid var(--border-color);">
        <div class="nav-previous">
            <?php previous_post_link('%link', '&larr; %title'); ?>
        </div>
        <div class="nav-next">
            <?php next_post_link('%link', '%title &rarr;'); ?>
        </div>
    </nav>

    <?php if (comments_open() || get_comments_number()) : ?>
    <div class="comments-area">
        <?php comments_template(); ?>
    </div>
    <?php endif; ?>

    <?php endwhile; ?>
</article>

<?php get_footer(); ?>
