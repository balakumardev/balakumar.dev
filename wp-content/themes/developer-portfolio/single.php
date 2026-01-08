<?php
/**
 * Single Post Template
 *
 * @package Developer_Portfolio
 */

get_header();

/**
 * Safe content renderer with error handling
 */
function developer_portfolio_safe_render_content() {
    try {
        the_content();
        return true;
    } catch (Exception $e) {
        error_log('Content rendering error: ' . $e->getMessage());
        return false;
    } catch (Error $e) {
        error_log('Content rendering error: ' . $e->getMessage());
        return false;
    }
}

/**
 * Safe function wrapper
 */
function developer_portfolio_safe_call($callback, $default = '') {
    try {
        ob_start();
        $result = call_user_func($callback);
        $output = ob_get_clean();
        return $output ?: $result;
    } catch (Exception $e) {
        ob_end_clean();
        error_log('Theme error: ' . $e->getMessage());
        return $default;
    } catch (Error $e) {
        ob_end_clean();
        error_log('Theme error: ' . $e->getMessage());
        return $default;
    }
}
?>

<main id="primary" class="site-main single-main">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
            // Safely get post data with null checks
            $categories = get_the_category();
            $primary_cat = (!empty($categories) && is_array($categories)) ? $categories[0] : null;
            $reading_time = function_exists('developer_portfolio_reading_time') ? developer_portfolio_reading_time() : 5;
            $content = get_the_content();
            $toc = function_exists('developer_portfolio_generate_toc') ? developer_portfolio_generate_toc($content) : '';
            $post_title = get_the_title() ?: 'Untitled Post';
            $post_date = get_the_date('c') ?: date('c');
            $post_date_display = get_the_date('F j, Y') ?: date('F j, Y');
    ?>
    
    <article id="post-<?php the_ID(); ?>" <?php post_class("single-post"); ?>>
        
        <!-- Post Header -->
        <header class="single-header">
            <div class="single-header-container">
                <div class="single-meta animate-on-scroll">
                    <?php if ($primary_cat && isset($primary_cat->term_id)) : ?>
                        <a href="<?php echo esc_url(get_category_link($primary_cat->term_id)); ?>" class="single-category">
                            <?php echo esc_html($primary_cat->name ?: 'Uncategorized'); ?>
                        </a>
                    <?php else : ?>
                        <span class="single-category">Blog</span>
                    <?php endif; ?>
                    <span class="meta-divider">//</span>
                    <time class="single-date" datetime="<?php echo esc_attr($post_date); ?>">
                        <?php echo esc_html($post_date_display); ?>
                    </time>
                    <span class="meta-divider">//</span>
                    <span class="single-reading-time"><?php echo intval($reading_time); ?> min read</span>
                </div>
                
                <h1 class="single-title animate-on-scroll" style="--delay: 0.1s;">
                    <?php echo esc_html($post_title); ?>
                </h1>
                
                <?php if (has_excerpt()) : ?>
                    <p class="single-excerpt animate-on-scroll" style="--delay: 0.2s;">
                        <?php echo esc_html(get_the_excerpt()); ?>
                    </p>
                <?php endif; ?>
                
                <div class="single-author animate-on-scroll" style="--delay: 0.3s;">
                    <div class="author-avatar">
                        <?php 
                        $author_id = get_the_author_meta("ID");
                        if ($author_id) {
                            echo get_avatar($author_id, 48);
                        }
                        ?>
                    </div>
                    <div class="author-info">
                        <span class="author-name"><?php echo esc_html(get_the_author() ?: 'Anonymous'); ?></span>
                        <span class="author-role">Senior Software Engineer</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Post Content -->
        <div class="single-content-wrapper">
            <div class="single-container">
                
                <!-- Table of Contents (if present) -->
                <?php if (!empty($toc)) : ?>
                    <aside class="toc-sidebar animate-on-scroll">
                        <?php echo $toc; ?>
                    </aside>
                <?php endif; ?>
                
                <!-- Main Content with Error Handling -->
                <div class="single-content" style="--delay: 0.2s;" id="post-content">
                    <?php
                    // Start output buffering for error catching
                    ob_start();
                    $content_rendered = false;
                    $error_occurred = false;
                    
                    try {
                        the_content();
                        $output = ob_get_clean();
                        
                        // Check if content is empty or just whitespace
                        if (!empty(trim($output))) {
                            echo $output;
                            $content_rendered = true;
                        }
                    } catch (Exception $e) {
                        ob_end_clean();
                        $error_occurred = true;
                        error_log('Single post content error: ' . $e->getMessage() . ' in post ID: ' . get_the_ID());
                    } catch (Error $e) {
                        ob_end_clean();
                        $error_occurred = true;
                        error_log('Single post content error: ' . $e->getMessage() . ' in post ID: ' . get_the_ID());
                    }
                    
                    // Show fallback content if needed
                    if (!$content_rendered || $error_occurred) :
                    ?>
                        <div class="content-error">
                            <div class="content-error-icon">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" y1="8" x2="12" y2="12"/>
                                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                            </div>
                            <h3>Unable to Display Content</h3>
                            <p>We're having trouble displaying this post's content. This might be a temporary issue.</p>
                            <div class="content-error-actions">
                                <button onclick="location.reload()" class="error-retry-btn">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M23 4v6h-6M1 20v-6h6"/>
                                        <path d="M3.51 9a9 9 0 0114.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0020.49 15"/>
                                    </svg>
                                    Try Again
                                </button>
                                <a href="<?php echo esc_url(home_url('/')); ?>" class="error-home-link">
                                    Return to Homepage
                                </a>
                                <a href="mailto:hello@balakumar.dev?subject=Issue%20with%20post:%20<?php echo urlencode($post_title); ?>&body=I%20encountered%20an%20issue%20viewing%20this%20post:%20<?php echo urlencode(get_permalink()); ?>" class="error-report-link">
                                    Report Issue
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                
            </div>
        </div>

        <!-- Post Footer -->
        <footer class="single-footer">
            <div class="single-footer-container">
                
                <!-- Tags -->
                <?php
                $tags = get_the_tags();
                if ($tags && is_array($tags) && !empty($tags)) :
                ?>
                    <div class="single-tags animate-on-scroll">
                        <span class="tags-label">Tagged:</span>
                        <div class="tags-list">
                            <?php foreach ($tags as $tag) : 
                                if (!isset($tag->term_id)) continue;
                            ?>
                                <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="tag-link">
                                    #<?php echo esc_html($tag->name ?: 'tag'); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Share Links -->
                <div class="single-share animate-on-scroll">
                    <span class="share-label">Share:</span>
                    <div class="share-links">
                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode($post_title); ?>" 
                           class="share-link share-twitter" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           aria-label="Share on Twitter">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(get_permalink()); ?>&title=<?php echo urlencode($post_title); ?>" 
                           class="share-link share-linkedin" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           aria-label="Share on LinkedIn">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                        <button class="share-link share-copy" 
                                data-url="<?php echo esc_url(get_permalink()); ?>"
                                aria-label="Copy link">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
                                <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Post Navigation -->
                <nav class="post-navigation animate-on-scroll">
                    <?php
                    $prev_post = get_previous_post();
                    $next_post = get_next_post();
                    ?>
                    
                    <?php if ($prev_post && isset($prev_post->ID)) : ?>
                        <a href="<?php echo esc_url(get_permalink($prev_post)); ?>" class="nav-link nav-prev">
                            <span class="nav-label">
                                <span class="nav-arrow">&#x2190;</span> Previous
                            </span>
                            <span class="nav-title"><?php echo esc_html($prev_post->post_title ?: 'Previous Post'); ?></span>
                        </a>
                    <?php else : ?>
                        <div class="nav-link nav-placeholder"></div>
                    <?php endif; ?>
                    
                    <?php if ($next_post && isset($next_post->ID)) : ?>
                        <a href="<?php echo esc_url(get_permalink($next_post)); ?>" class="nav-link nav-next">
                            <span class="nav-label">
                                Next <span class="nav-arrow">&#x2192;</span>
                            </span>
                            <span class="nav-title"><?php echo esc_html($next_post->post_title ?: 'Next Post'); ?></span>
                        </a>
                    <?php endif; ?>
                </nav>
                
            </div>
        </footer>

        <!-- Related Posts -->
        <?php
        try {
            $current_categories = wp_get_post_categories(get_the_ID());
            if (!empty($current_categories) && is_array($current_categories)) {
                $related_posts = new WP_Query(array(
                    "posts_per_page" => 3,
                    "post__not_in"   => array(get_the_ID()),
                    "category__in"   => $current_categories,
                    "post_status"    => "publish",
                ));
                
                if ($related_posts->have_posts()) :
        ?>
            <section class="related-posts">
                <div class="related-container">
                    <h2 class="related-title animate-on-scroll">
                        <span class="title-bracket">{</span>
                        Related Posts
                        <span class="title-bracket">}</span>
                    </h2>
                    
                    <div class="related-grid">
                        <?php
                        $related_index = 0;
                        while ($related_posts->have_posts()) : $related_posts->the_post();
                            $rel_categories = get_the_category();
                            $rel_primary_cat = (!empty($rel_categories) && is_array($rel_categories)) ? $rel_categories[0] : null;
                            $rel_gradient = ($rel_primary_cat && function_exists('developer_portfolio_get_category_gradient')) 
                                ? developer_portfolio_get_category_gradient($rel_primary_cat->slug ?? '') 
                                : "gradient-default";
                        ?>
                            <article class="related-card animate-on-scroll <?php echo esc_attr($rel_gradient); ?>" style="--delay: <?php echo $related_index * 0.1; ?>s;">
                                <div class="related-card-inner">
                                    <?php if ($rel_primary_cat && isset($rel_primary_cat->name)) : ?>
                                        <span class="related-category"><?php echo esc_html($rel_primary_cat->name); ?></span>
                                    <?php endif; ?>
                                    <h3 class="related-card-title">
                                        <a href="<?php the_permalink(); ?>"><?php echo esc_html(get_the_title() ?: 'Untitled'); ?></a>
                                    </h3>
                                    <time class="related-date" datetime="<?php echo esc_attr(get_the_date("c") ?: date('c')); ?>">
                                        <?php echo esc_html(get_the_date("M j, Y") ?: date('M j, Y')); ?>
                                    </time>
                                </div>
                            </article>
                        <?php
                            $related_index++;
                        endwhile;
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
            </section>
        <?php 
                endif;
            }
        } catch (Exception $e) {
            error_log('Related posts error: ' . $e->getMessage());
        } catch (Error $e) {
            error_log('Related posts error: ' . $e->getMessage());
        }
        ?>

    </article>
    
    <?php 
        endwhile;
    else :
        // No posts found - show error message
    ?>
        <div class="no-post-found">
            <div class="content-error">
                <div class="content-error-icon">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="12" y1="11" x2="12" y2="17"/>
                        <line x1="9" y1="14" x2="15" y2="14"/>
                    </svg>
                </div>
                <h3>Post Not Found</h3>
                <p>The post you're looking for doesn't exist or may have been removed.</p>
                <div class="content-error-actions">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="error-retry-btn">
                        Browse All Posts
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</main>

<?php
get_footer();
