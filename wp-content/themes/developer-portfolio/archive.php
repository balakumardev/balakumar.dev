<?php
/**
 * Archive Template (Category, Tag, Date archives)
 *
 * This template displays archives with AJAX filtering and pagination.
 *
 * @package Developer_Portfolio
 */

get_header();

$paged = (get_query_var("paged")) ? get_query_var("paged") : 1;
$current_category_slug = "";
$current_category_name = "";

if (is_category()) {
    $current_category = get_queried_object();
    $current_category_slug = $current_category->slug;
    $current_category_name = $current_category->name;
}
?>

<main id="primary" class="site-main blog-main">
    <div class="blog-container">
        
        <!-- Blog Header -->
        <header class="blog-header animate-on-scroll">
            <span class="blog-tag">// <?php echo is_category() ? "Category" : "Archive"; ?></span>
            <h1 class="blog-title">
                <span class="title-bracket">{</span>
                <?php 
                if (is_category()) {
                    single_cat_title();
                } elseif (is_tag()) {
                    single_tag_title("#");
                } elseif (is_date()) {
                    echo get_the_date("F Y");
                } else {
                    echo "Archive";
                }
                ?>
                <span class="title-bracket">}</span>
            </h1>
            <?php if (is_category() && category_description()) : ?>
                <p class="blog-description"><?php echo category_description(); ?></p>
            <?php else : ?>
                <p class="blog-description">
                    Thoughts on distributed systems, AI, software engineering, and building things that scale.
                </p>
            <?php endif; ?>
            
            <!-- Blog Stats -->
            <div class="blog-stats">
                <?php
                global $wp_query;
                $post_count = $wp_query->found_posts;
                $all_posts_count = wp_count_posts()->publish;
                ?>
                <div class="blog-stat">
                    <span class="stat-number" id="post-count"><?php echo $post_count; ?></span>
                    <span class="stat-text">Articles</span>
                </div>
                <span class="stat-separator">//</span>
                <div class="blog-stat">
                    <span class="stat-number"><?php echo $all_posts_count; ?></span>
                    <span class="stat-text">Total</span>
                </div>
            </div>
        </header>

        <!-- Category Filter - AJAX Enabled -->
        <nav class="category-filter animate-on-scroll" id="category-filter">
            <button type="button" 
                    class="filter-pill <?php echo empty($current_category_slug) ? "active" : ""; ?>" 
                    data-category="all"
                    aria-pressed="<?php echo empty($current_category_slug) ? "true" : "false"; ?>">
                <span class="filter-pill-text">All</span>
                <span class="filter-pill-count"><?php echo $all_posts_count; ?></span>
            </button>
            <?php
            $categories = get_categories(array(
                "orderby"    => "count",
                "order"      => "DESC",
                "hide_empty" => true,
                "number"     => 8,
                "exclude"    => get_cat_ID("Uncategorized"),
            ));
            
            foreach ($categories as $category) :
                $gradient_class = developer_portfolio_get_category_gradient($category->slug);
                $is_active = ($category->slug === $current_category_slug);
            ?>
                <button type="button" 
                        class="filter-pill <?php echo $gradient_class; ?> <?php echo $is_active ? "active" : ""; ?>" 
                        data-category="<?php echo esc_attr($category->slug); ?>"
                        aria-pressed="<?php echo $is_active ? "true" : "false"; ?>">
                    <span class="filter-pill-text"><?php echo esc_html($category->name); ?></span>
                    <span class="filter-pill-count"><?php echo $category->count; ?></span>
                </button>
            <?php endforeach; ?>
        </nav>

        <!-- Loading Indicator -->
        <div class="posts-loading" id="posts-loading" aria-hidden="true">
            <div class="loading-spinner">
                <div class="spinner-ring"></div>
                <div class="spinner-ring"></div>
                <div class="spinner-ring"></div>
            </div>
            <span class="loading-text">Loading posts...</span>
        </div>

        <!-- Posts Grid -->
        <div class="posts-grid blog-posts-grid" id="posts-container" 
             data-page="<?php echo $paged; ?>" 
             data-max-pages="<?php echo $wp_query->max_num_pages; ?>"
             data-category="<?php echo esc_attr($current_category_slug ?: "all"); ?>">
            <?php
            if (have_posts()) :
                $post_index = 0;
                while (have_posts()) : the_post();
                    $categories = get_the_category();
                    $primary_cat = !empty($categories) ? $categories[0] : null;
                    $gradient_class = $primary_cat ? developer_portfolio_get_category_gradient($primary_cat->slug) : "gradient-default";
                    $reading_time = developer_portfolio_reading_time();
            ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class("post-card animate-on-scroll " . $gradient_class); ?> style="--delay: <?php echo $post_index * 0.1; ?>s;">
                    <div class="post-card-inner">
                        <div class="post-card-header">
                            <?php if ($primary_cat) : ?>
                                <a href="<?php echo esc_url(get_category_link($primary_cat->term_id)); ?>" class="post-category">
                                    <span class="category-icon">&#x25B6;</span>
                                    <?php echo esc_html($primary_cat->name); ?>
                                </a>
                            <?php endif; ?>
                            <span class="post-reading-time">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                                <?php echo $reading_time; ?> min read
                            </span>
                        </div>
                        
                        <h2 class="post-card-title">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h2>
                        
                        <p class="post-card-excerpt">
                            <?php echo wp_trim_words(get_the_excerpt(), 25, "..."); ?>
                        </p>
                        
                        <footer class="post-card-footer">
                            <time class="post-date" datetime="<?php echo get_the_date("c"); ?>">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                    <line x1="16" y1="2" x2="16" y2="6"/>
                                    <line x1="8" y1="2" x2="8" y2="6"/>
                                    <line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                                <?php echo get_the_date("M j, Y"); ?>
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
            else :
            ?>
                <div class="no-posts-message animate-on-scroll">
                    <div class="no-posts-icon">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/>
                            <line x1="16" y1="17" x2="8" y2="17"/>
                            <polyline points="10 9 9 9 8 9"/>
                        </svg>
                    </div>
                    <h2>No Posts Found</h2>
                    <p>There are no articles in this category yet.</p>
                    <a href="<?php echo esc_url(home_url("/")); ?>" class="back-home-link">
                        <span class="arrow">&#x2190;</span> Back to Home
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Load More Button -->
        <?php if (have_posts() && $wp_query->max_num_pages > 1) : ?>
            <div class="load-more-container animate-on-scroll" id="load-more-container">
                <button type="button" class="load-more-btn" id="load-more-btn">
                    <span class="btn-text">Load More Articles</span>
                    <span class="btn-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="7 13 12 18 17 13"/>
                            <polyline points="7 6 12 11 17 6"/>
                        </svg>
                    </span>
                    <span class="btn-loading">
                        <svg class="spinner" width="20" height="20" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none" stroke-dasharray="60" stroke-dashoffset="20"/>
                        </svg>
                    </span>
                </button>
                
                <!-- Posts count info -->
                <div class="pagination-info">
                    <?php
                    $posts_per_page = get_query_var("posts_per_page");
                    $showing = min($posts_per_page, $wp_query->found_posts);
                    ?>
                    <span class="pagination-showing" id="pagination-info">
                        Showing <span id="showing-count"><?php echo $showing; ?></span> of <span id="total-count"><?php echo $wp_query->found_posts; ?></span> articles
                    </span>
                </div>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php
get_footer();
