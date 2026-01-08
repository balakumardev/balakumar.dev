<?php
/**
 * Search Results Template
 *
 * @package Developer_Portfolio
 */

get_header();
?>

<main id="primary" class="site-main search-main">
    <div class="search-container">
        
        <!-- Search Header -->
        <header class="search-header animate-on-scroll">
            <span class="search-tag">// Search Results</span>
            <h1 class="search-title">
                <span class="title-bracket">{</span>
                <?php printf(esc_html__('Results for: %s', 'developer-portfolio'), '<span class="search-query">' . get_search_query() . '</span>'); ?>
                <span class="title-bracket">}</span>
            </h1>
            <?php
            global $wp_query;
            $results_count = $wp_query->found_posts;
            ?>
            <p class="search-count">
                <?php printf(_n('%s result found', '%s results found', $results_count, 'developer-portfolio'), $results_count); ?>
            </p>
            
            <div class="search-again">
                <?php get_search_form(); ?>
            </div>
        </header>

        <?php if (have_posts()) : ?>
            <!-- Posts Grid -->
            <div class="posts-grid search-posts-grid">
                <?php
                $post_index = 0;
                while (have_posts()) : the_post();
                    $categories = get_the_category();
                    $primary_cat = !empty($categories) ? $categories[0] : null;
                    $gradient_class = $primary_cat ? developer_portfolio_get_category_gradient($primary_cat->slug) : 'gradient-default';
                    $reading_time = developer_portfolio_reading_time();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('post-card animate-on-scroll ' . $gradient_class); ?> style="--delay: <?php echo $post_index * 0.1; ?>s;">
                    <div class="post-card-inner">
                        <div class="post-card-header">
                            <?php if ($primary_cat) : ?>
                                <a href="<?php echo esc_url(get_category_link($primary_cat->term_id)); ?>" class="post-category">
                                    <span class="category-icon">&#x25B6;</span>
                                    <?php echo esc_html($primary_cat->name); ?>
                                </a>
                            <?php endif; ?>
                            <span class="post-reading-time"><?php echo $reading_time; ?> min read</span>
                            <?php developer_portfolio_edit_button(get_the_ID(), 'edit-button-card'); ?>
                        </div>
                        
                        <h2 class="post-card-title">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h2>
                        
                        <p class="post-card-excerpt">
                            <?php echo wp_trim_words(get_the_excerpt(), 25, '...'); ?>
                        </p>
                        
                        <footer class="post-card-footer">
                            <time class="post-date" datetime="<?php echo get_the_date('c'); ?>">
                                <?php echo get_the_date('M j, Y'); ?>
                            </time>
                            <a href="<?php the_permalink(); ?>" class="read-more-link">
                                Read more <span class="arrow">&#x2192;</span>
                            </a>
                        </footer>
                    </div>
                    <div class="post-card-border"></div>
                </article>
                <?php
                    $post_index++;
                endwhile;
                ?>
            </div>

            <!-- Pagination -->
            <nav class="pagination-nav animate-on-scroll">
                <?php
                $pagination = paginate_links(array(
                    'prev_text' => '<span class="nav-arrow">&#x2190;</span> Previous',
                    'next_text' => 'Next <span class="nav-arrow">&#x2192;</span>',
                    'type'      => 'array',
                ));
                
                if ($pagination) :
                ?>
                    <div class="pagination">
                        <?php foreach ($pagination as $page_link) : ?>
                            <span class="pagination-item"><?php echo $page_link; ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </nav>
            
        <?php else : ?>
            <div class="no-posts-message animate-on-scroll">
                <div class="no-posts-icon">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="M21 21l-4.35-4.35"></path>
                    </svg>
                </div>
                <h2><?php esc_html_e('No Results Found', 'developer-portfolio'); ?></h2>
                <p><?php esc_html_e('Sorry, nothing matched your search. Try different keywords or browse the categories.', 'developer-portfolio'); ?></p>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="back-home-link">
                    <span class="arrow">&#x2190;</span> Back to Home
                </a>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php
get_footer();
