<?php
/**
 * Blog Index Template
 */
get_header();
?>

<div class="archive-header">
    <div class="container">
        <h1>Blog</h1>
        <p>Thoughts, tutorials, and insights on software engineering</p>
    </div>
</div>

<section class="section">
    <div class="container">
        <?php if (have_posts()) : ?>
        <div class="blog-grid">
            <?php while (have_posts()) : the_post(); ?>
            <article class="blog-card">
                <div class="thumbnail">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium_large'); ?>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="card-content">
                    <div class="meta">
                        <?php echo get_the_date(); ?>
                        <?php if (get_the_category()) : ?>
                            &bull; <?php the_category(', '); ?>
                        <?php endif; ?>
                    </div>
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <p class="excerpt"><?php echo wp_trim_words(get_the_excerpt(), 25); ?></p>
                </div>
            </article>
            <?php endwhile; ?>
        </div>

        <div class="pagination">
            <?php
            the_posts_pagination(array(
                'mid_size'  => 2,
                'prev_text' => '&larr;',
                'next_text' => '&rarr;',
            ));
            ?>
        </div>

        <?php else : ?>
        <div class="no-posts" style="text-align: center; padding: 4rem;">
            <h2>No posts found</h2>
            <p>Check back soon for new content!</p>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary" style="margin-top: 1rem;">Go Home</a>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
