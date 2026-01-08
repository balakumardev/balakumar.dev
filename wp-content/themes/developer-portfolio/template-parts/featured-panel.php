<?php
/**
 * Featured Panel Template
 *
 * Displays the floating panel with featured projects and posts.
 *
 * @package Developer_Portfolio
 * @since 1.1.0
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get panel instance from global
$panel = isset($GLOBALS['developer_portfolio_featured_panel'])
    ? $GLOBALS['developer_portfolio_featured_panel']
    : new Developer_Portfolio_Featured_Panel();

$options = $panel->get_options();
$projects = $panel->get_featured_projects();
$posts = $panel->get_featured_posts();

// Position class
$position_class = 'panel-position-' . esc_attr($options['position']);
$collapsed_class = $options['collapsed_default'] ? 'is-collapsed' : '';
$mobile_class = $options['hide_on_mobile'] ? 'hide-on-mobile' : '';
?>

<aside id="featured-panel"
       class="featured-panel <?php echo esc_attr($position_class); ?> <?php echo esc_attr($collapsed_class); ?> <?php echo esc_attr($mobile_class); ?>"
       data-collapsed-default="<?php echo $options['collapsed_default'] ? 'true' : 'false'; ?>"
       aria-label="<?php esc_attr_e('Featured Content', 'developer-portfolio'); ?>">

    <!-- Collapsed Tab -->
    <button class="featured-panel-tab" aria-expanded="<?php echo $options['collapsed_default'] ? 'false' : 'true'; ?>">
        <svg class="tab-icon" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
        </svg>
        <span class="tab-text"><?php _e('Featured', 'developer-portfolio'); ?></span>
    </button>

    <!-- Panel Content -->
    <div class="featured-panel-content">
        <header class="featured-panel-header">
            <h2 class="featured-panel-title">
                <span class="bracket">{</span>
                <?php _e('Featured', 'developer-portfolio'); ?>
                <span class="bracket">}</span>
            </h2>
            <button class="featured-panel-close" aria-label="<?php esc_attr_e('Close panel', 'developer-portfolio'); ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </header>

        <div class="featured-panel-body">
            <?php if ($projects->have_posts()) : ?>
            <!-- Projects Section -->
            <section class="featured-section featured-projects">
                <h3 class="featured-section-title">
                    <svg class="section-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                    </svg>
                    <?php echo esc_html($options['projects_heading']); ?>
                </h3>
                <ul class="featured-list">
                    <?php while ($projects->have_posts()) : $projects->the_post();
                        $icon = get_post_meta(get_the_ID(), '_project_icon', true);
                        $technologies = get_post_meta(get_the_ID(), '_project_technologies', true);
                    ?>
                    <li class="featured-item">
                        <a href="<?php the_permalink(); ?>" class="featured-link">
                            <span class="featured-icon">
                                <?php
                                if ($icon && function_exists('developer_portfolio_get_project_icon_svg')) {
                                    echo developer_portfolio_get_project_icon_svg($icon);
                                } else {
                                    echo '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>';
                                }
                                ?>
                            </span>
                            <span class="featured-text">
                                <span class="featured-name"><?php the_title(); ?></span>
                                <?php if ($technologies) : ?>
                                <span class="featured-meta"><?php echo esc_html(wp_trim_words($technologies, 3, '...')); ?></span>
                                <?php endif; ?>
                            </span>
                            <svg class="featured-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </li>
                    <?php endwhile; wp_reset_postdata(); ?>
                </ul>
            </section>
            <?php endif; ?>

            <?php if ($posts->have_posts()) : ?>
            <!-- Posts Section -->
            <section class="featured-section featured-posts">
                <h3 class="featured-section-title">
                    <svg class="section-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/>
                        <polyline points="14 2 14 8 20 8"/>
                    </svg>
                    <?php echo esc_html($options['posts_heading']); ?>
                </h3>
                <ul class="featured-list">
                    <?php while ($posts->have_posts()) : $posts->the_post();
                        $categories = get_the_category();
                        $category_name = !empty($categories) ? $categories[0]->name : '';
                    ?>
                    <li class="featured-item">
                        <a href="<?php the_permalink(); ?>" class="featured-link">
                            <span class="featured-icon featured-icon-post">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M12 20h9"/>
                                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                                </svg>
                            </span>
                            <span class="featured-text">
                                <span class="featured-name"><?php the_title(); ?></span>
                                <?php if ($category_name) : ?>
                                <span class="featured-meta"><?php echo esc_html($category_name); ?></span>
                                <?php endif; ?>
                            </span>
                            <svg class="featured-arrow" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </li>
                    <?php endwhile; wp_reset_postdata(); ?>
                </ul>
            </section>
            <?php endif; ?>
        </div>
    </div>
</aside>
