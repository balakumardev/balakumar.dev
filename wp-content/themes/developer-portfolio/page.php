<?php
/**
 * Page Template
 *
 * @package Developer_Portfolio
 */

get_header();
?>

<main id="primary" class="site-main page-main">
    <?php while (have_posts()) : the_post(); ?>
    
    <article id="page-<?php the_ID(); ?>" <?php post_class("single-page"); ?>>
        
        <!-- Page Header -->
        <header class="page-header animate-on-scroll">
            <div class="page-header-container">
                <h1 class="page-title">
                    <span class="title-bracket">{</span>
                    <?php the_title(); ?>
                    <span class="title-bracket">}</span>
                </h1>
            </div>
        </header>

        <!-- Page Content -->
        <div class="page-content-wrapper">
            <div class="page-container">
                <div class="page-content animate-on-scroll" style="--delay: 0.1s;">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>

    </article>
    
    <?php endwhile; ?>
</main>

<?php
get_footer();
