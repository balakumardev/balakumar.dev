<?php
/**
 * Single Project Template
 *
 * Displays individual project details.
 *
 * @package Developer_Portfolio
 */

get_header();
?>

<main id="primary" class="site-main single-project-main">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
            // Get project meta
            $github_url = get_post_meta(get_the_ID(), "_project_github_url", true);
            $project_links_raw = get_post_meta(get_the_ID(), "_project_links", true);
            $technologies = get_post_meta(get_the_ID(), "_project_technologies", true);

            // Parse project links (one URL per line)
            $project_links = array();
            if (!empty($project_links_raw)) {
                $lines = array_filter(array_map('trim', explode("\n", $project_links_raw)));
                foreach ($lines as $url) {
                    if (filter_var($url, FILTER_VALIDATE_URL)) {
                        $project_links[] = $url;
                    }
                }
            }
            $icon = get_post_meta(get_the_ID(), "_project_icon", true);
            $is_featured = get_post_meta(get_the_ID(), "_project_featured", true) === "1";
            $screenshots = get_post_meta(get_the_ID(), "_project_screenshots", true);

            // Parse screenshots into array
            $screenshot_ids = array();
            if (!empty($screenshots)) {
                $screenshot_ids = array_filter(array_map("trim", explode(",", $screenshots)));
            }

            // Parse technologies into array
            $tech_array = array();
            if (!empty($technologies)) {
                $tech_array = array_map("trim", explode(",", $technologies));
            }

            // Get project types
            $types = get_the_terms(get_the_ID(), "project_type");
            $primary_type = (!empty($types) && !is_wp_error($types)) ? $types[0] : null;

            // Get post date
            $post_date = get_the_date("c") ?: date("c");
            $post_date_display = get_the_date("F j, Y") ?: date("F j, Y");
    ?>

    <article id="project-<?php the_ID(); ?>" <?php post_class("single-project"); ?>>

        <!-- Project Header -->
        <header class="single-project-header">
            <div class="single-project-header-container">

                <!-- Breadcrumb -->
                <nav class="project-breadcrumb animate-on-scroll" aria-label="Breadcrumb">
                    <a href="<?php echo esc_url(home_url("/")); ?>">Home</a>
                    <span class="breadcrumb-separator">/</span>
                    <a href="<?php echo esc_url(get_post_type_archive_link("project")); ?>">Projects</a>
                    <?php if ($primary_type) : ?>
                        <span class="breadcrumb-separator">/</span>
                        <a href="<?php echo esc_url(get_term_link($primary_type)); ?>"><?php echo esc_html($primary_type->name); ?></a>
                    <?php endif; ?>
                </nav>

                <!-- Project Icon and Meta -->
                <div class="project-header-top animate-on-scroll" style="--delay: 0.1s;">
                    <div class="project-icon-large">
                        <?php echo developer_portfolio_get_project_icon_svg($icon ?: "code"); ?>
                    </div>
                    <?php if ($is_featured) : ?>
                        <span class="project-featured-badge-large">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                            </svg>
                            Featured Project
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Project Title -->
                <h1 class="single-project-title animate-on-scroll" style="--delay: 0.2s;">
                    <?php the_title(); ?>
                </h1>

                <!-- Project Excerpt -->
                <?php if (has_excerpt()) : ?>
                    <p class="single-project-excerpt animate-on-scroll" style="--delay: 0.3s;">
                        <?php echo esc_html(get_the_excerpt()); ?>
                    </p>
                <?php endif; ?>

                <!-- Project Meta -->
                <div class="single-project-meta animate-on-scroll" style="--delay: 0.4s;">
                    <?php if ($primary_type) : ?>
                        <a href="<?php echo esc_url(get_term_link($primary_type)); ?>" class="project-type-link">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                            </svg>
                            <?php echo esc_html($primary_type->name); ?>
                        </a>
                    <?php endif; ?>
                    <span class="meta-divider">//</span>
                    <time class="project-date" datetime="<?php echo esc_attr($post_date); ?>">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        <?php echo esc_html($post_date_display); ?>
                    </time>
                </div>

                <!-- Project Action Links -->
                <div class="project-action-links animate-on-scroll" style="--delay: 0.5s;">
                    <?php if (!empty($github_url)) : ?>
                        <a href="<?php echo esc_url($github_url); ?>"
                           class="project-action-btn project-action-github"
                           target="_blank"
                           rel="noopener noreferrer">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                            </svg>
                            <span>View on GitHub</span>
                        </a>
                    <?php endif; ?>

                    <?php
                    // Display auto-detected project links
                    foreach ($project_links as $link_url) :
                        $link_info = developer_portfolio_get_link_info($link_url);
                    ?>
                        <a href="<?php echo esc_url($link_url); ?>"
                           class="project-action-btn project-action-<?php echo esc_attr($link_info['style']); ?>"
                           target="_blank"
                           rel="noopener noreferrer">
                            <?php echo $link_info['icon']; ?>
                            <span><?php echo esc_html($link_info['label']); ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>

            </div>
        </header>

        <!-- Project Content -->
        <div class="single-project-content-wrapper">
            <div class="single-project-container">

                <!-- Screenshots Gallery -->
                <?php if (!empty($screenshot_ids)) : ?>
                    <section class="project-screenshots animate-on-scroll">
                        <h3 class="screenshots-title">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <polyline points="21 15 16 10 5 21"/>
                            </svg>
                            Screenshots
                        </h3>
                        <div class="screenshots-grid">
                            <?php foreach ($screenshot_ids as $index => $image_id) :
                                $full_url = wp_get_attachment_image_url($image_id, 'large');
                                $thumb_url = wp_get_attachment_image_url($image_id, 'medium');
                                $alt = get_post_meta($image_id, '_wp_attachment_image_alt', true) ?: get_the_title();
                                if ($full_url) :
                            ?>
                                <a href="<?php echo esc_url($full_url); ?>" class="screenshot-item" data-lightbox="project-gallery" target="_blank">
                                    <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr($alt); ?> - Screenshot <?php echo $index + 1; ?>">
                                    <div class="screenshot-overlay">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="11" cy="11" r="8"/>
                                            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                                            <line x1="11" y1="8" x2="11" y2="14"/>
                                            <line x1="8" y1="11" x2="14" y2="11"/>
                                        </svg>
                                    </div>
                                </a>
                            <?php endif; endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>

                <!-- Technologies Sidebar -->
                <?php if (!empty($tech_array)) : ?>
                    <aside class="project-tech-sidebar animate-on-scroll">
                        <h3 class="tech-sidebar-title">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="16 18 22 12 16 6"/>
                                <polyline points="8 6 2 12 8 18"/>
                            </svg>
                            Technologies
                        </h3>
                        <div class="tech-sidebar-list">
                            <?php foreach ($tech_array as $tech) : ?>
                                <span class="tech-sidebar-item"><?php echo esc_html($tech); ?></span>
                            <?php endforeach; ?>
                        </div>
                    </aside>
                <?php endif; ?>

                <!-- Main Content -->
                <div class="single-project-content animate-on-scroll" style="--delay: 0.2s;">
                    <?php
                    // Render content with error handling
                    ob_start();
                    $content_rendered = false;
                    $show_placeholder = false;

                    try {
                        the_content();
                        $output = ob_get_clean();
                        $output_text = trim(strip_tags($output));
                        $excerpt_text = trim(get_the_excerpt());

                        // Check if content is meaningful (not same as excerpt and has enough content)
                        $is_same_as_excerpt = similar_text($output_text, $excerpt_text) > (strlen($excerpt_text) * 0.8);
                        $is_too_short = strlen($output_text) < 200;

                        if (!empty($output_text) && !$is_same_as_excerpt && !$is_too_short) {
                            echo $output;
                            $content_rendered = true;
                        } else {
                            $show_placeholder = true;
                        }
                    } catch (Exception $e) {
                        ob_end_clean();
                        error_log("Single project content error: " . $e->getMessage() . " in project ID: " . get_the_ID());
                        $show_placeholder = true;
                    } catch (Error $e) {
                        ob_end_clean();
                        error_log("Single project content error: " . $e->getMessage() . " in project ID: " . get_the_ID());
                        $show_placeholder = true;
                    }

                    if ($show_placeholder || !$content_rendered) :
                    ?>
                        <div class="project-content-placeholder">
                            <p>This project does not have detailed documentation yet. Check out the GitHub repository for more information.</p>
                            <?php if (!empty($github_url)) : ?>
                                <a href="<?php echo esc_url($github_url); ?>" class="placeholder-link" target="_blank" rel="noopener noreferrer">
                                    View README on GitHub
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                                        <polyline points="15 3 21 3 21 9"/>
                                        <line x1="10" y1="14" x2="21" y2="3"/>
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>

        <!-- Project Footer -->
        <footer class="single-project-footer">
            <div class="single-project-footer-container">

                <!-- Share Links -->
                <div class="project-share animate-on-scroll">
                    <span class="share-label">Share this project:</span>
                    <div class="share-links">
                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>"
                           class="share-link share-twitter"
                           target="_blank"
                           rel="noopener noreferrer"
                           aria-label="Share on Twitter">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(get_permalink()); ?>&title=<?php echo urlencode(get_the_title()); ?>"
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

                <!-- Project Navigation -->
                <nav class="project-navigation animate-on-scroll" aria-label="Project navigation">
                    <?php
                    // Get adjacent projects
                    $prev_project = get_adjacent_post(false, "", true, "project_type");
                    $next_project = get_adjacent_post(false, "", false, "project_type");

                    // Fallback to any project if not found in same type
                    if (!$prev_project) {
                        $prev_project = get_adjacent_post(false, "", true);
                    }
                    if (!$next_project) {
                        $next_project = get_adjacent_post(false, "", false);
                    }
                    ?>

                    <?php if ($prev_project) : ?>
                        <a href="<?php echo esc_url(get_permalink($prev_project)); ?>" class="nav-link nav-prev">
                            <span class="nav-label">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="19" y1="12" x2="5" y2="12"/>
                                    <polyline points="12 19 5 12 12 5"/>
                                </svg>
                                Previous Project
                            </span>
                            <span class="nav-title"><?php echo esc_html($prev_project->post_title); ?></span>
                        </a>
                    <?php else : ?>
                        <div class="nav-link nav-placeholder"></div>
                    <?php endif; ?>

                    <a href="<?php echo esc_url(get_post_type_archive_link("project")); ?>" class="nav-link nav-all">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="7" height="7"/>
                            <rect x="14" y="3" width="7" height="7"/>
                            <rect x="14" y="14" width="7" height="7"/>
                            <rect x="3" y="14" width="7" height="7"/>
                        </svg>
                        All Projects
                    </a>

                    <?php if ($next_project) : ?>
                        <a href="<?php echo esc_url(get_permalink($next_project)); ?>" class="nav-link nav-next">
                            <span class="nav-label">
                                Next Project
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="5" y1="12" x2="19" y2="12"/>
                                    <polyline points="12 5 19 12 12 19"/>
                                </svg>
                            </span>
                            <span class="nav-title"><?php echo esc_html($next_project->post_title); ?></span>
                        </a>
                    <?php else : ?>
                        <div class="nav-link nav-placeholder"></div>
                    <?php endif; ?>
                </nav>

            </div>
        </footer>

        <!-- Related Projects -->
        <?php
        // Get related projects from same type
        $related_args = array(
            "post_type"      => "project",
            "post_status"    => "publish",
            "posts_per_page" => 3,
            "post__not_in"   => array(get_the_ID()),
            "orderby"        => "rand",
        );

        if ($primary_type) {
            $related_args["tax_query"] = array(
                array(
                    "taxonomy" => "project_type",
                    "field"    => "term_id",
                    "terms"    => $primary_type->term_id,
                ),
            );
        }

        $related_projects = new WP_Query($related_args);

        if ($related_projects->have_posts()) :
        ?>
            <section class="related-projects">
                <div class="related-projects-container">
                    <h2 class="related-projects-title animate-on-scroll">
                        <span class="title-bracket">{</span>
                        Related Projects
                        <span class="title-bracket">}</span>
                    </h2>

                    <div class="related-projects-grid">
                        <?php
                        $related_index = 0;
                        while ($related_projects->have_posts()) : $related_projects->the_post();
                            $rel_icon = get_post_meta(get_the_ID(), "_project_icon", true);
                            $rel_technologies = get_post_meta(get_the_ID(), "_project_technologies", true);
                            $rel_tech_array = !empty($rel_technologies) ? array_slice(array_map("trim", explode(",", $rel_technologies)), 0, 3) : array();
                        ?>
                            <article class="related-project-card animate-on-scroll" style="--delay: <?php echo $related_index * 0.1; ?>s;">
                                <div class="related-project-card-inner">
                                    <div class="related-project-icon">
                                        <?php echo developer_portfolio_get_project_icon_svg($rel_icon ?: "code"); ?>
                                    </div>
                                    <h3 class="related-project-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    <?php if (!empty($rel_tech_array)) : ?>
                                        <div class="related-project-tech">
                                            <?php foreach ($rel_tech_array as $tech) : ?>
                                                <span class="tech-tag-small"><?php echo esc_html($tech); ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
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
        <?php endif; ?>

    </article>

    <?php
        endwhile;
    else :
        // No project found
    ?>
        <div class="no-project-found">
            <div class="content-error">
                <div class="content-error-icon">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                        <line x1="12" y1="11" x2="12" y2="17"/>
                        <line x1="12" y1="11" x2="12.01" y2="11"/>
                    </svg>
                </div>
                <h3>Project Not Found</h3>
                <p>The project you are looking for does not exist or may have been removed.</p>
                <div class="content-error-actions">
                    <a href="<?php echo esc_url(get_post_type_archive_link("project")); ?>" class="error-retry-btn">
                        Browse All Projects
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</main>

<?php
get_footer();
