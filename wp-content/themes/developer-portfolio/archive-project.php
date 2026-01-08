<?php
/**
 * Projects Archive Template
 *
 * Displays all projects in a grid layout with filtering by project type.
 * Accessible at /projects/
 *
 * @package Developer_Portfolio
 */

get_header();

// Get current project type filter
$current_type_slug = "";
$current_type_name = "";

if (is_tax("project_type")) {
    $current_type = get_queried_object();
    $current_type_slug = $current_type->slug;
    $current_type_name = $current_type->name;
}

// Query projects
$paged = (get_query_var("paged")) ? get_query_var("paged") : 1;

$args = array(
    "post_type"      => "project",
    "post_status"    => "publish",
    "posts_per_page" => 12,
    "paged"          => $paged,
    "orderby"        => "meta_value_num",
    "meta_key"       => "_project_sort_order",
    "order"          => "ASC",
    "meta_query"     => array(
        "relation" => "OR",
        array(
            "key"     => "_project_sort_order",
            "compare" => "EXISTS",
        ),
        array(
            "key"     => "_project_sort_order",
            "compare" => "NOT EXISTS",
        ),
    ),
);

// Add taxonomy filter if viewing a specific type
if (!empty($current_type_slug)) {
    $args["tax_query"] = array(
        array(
            "taxonomy" => "project_type",
            "field"    => "slug",
            "terms"    => $current_type_slug,
        ),
    );
}

$projects_query = new WP_Query($args);
$total_projects = wp_count_posts("project")->publish;
?>

<main id="primary" class="site-main projects-main">
    <div class="projects-container">

        <!-- Projects Header -->
        <header class="section-header projects-header animate-on-scroll">
            <span class="section-tag">// Open Source & Side Projects</span>
            <h1 class="section-title">
                <span class="title-bracket">{</span>
                <?php
                if (!empty($current_type_name)) {
                    echo esc_html($current_type_name);
                } else {
                    echo "Projects";
                }
                ?>
                <span class="title-bracket">}</span>
            </h1>
            <p class="section-subtitle">
                Tools, libraries, and applications I have built for the developer community
            </p>

            <!-- Projects Stats -->
            <div class="projects-stats">
                <?php
                $project_types_count = wp_count_terms("project_type", array("hide_empty" => true));
                if (is_wp_error($project_types_count)) {
                    $project_types_count = 0;
                }
                ?>
                <div class="projects-stat">
                    <span class="stat-number"><?php echo intval($total_projects); ?></span>
                    <span class="stat-text">Projects</span>
                </div>
                <span class="stat-separator">//</span>
                <div class="projects-stat">
                    <span class="stat-number"><?php echo intval($project_types_count); ?></span>
                    <span class="stat-text">Categories</span>
                </div>
            </div>
        </header>

        <!-- Project Type Filter -->
        <?php
        $project_types = get_terms(array(
            "taxonomy"   => "project_type",
            "hide_empty" => true,
            "orderby"    => "count",
            "order"      => "DESC",
        ));

        if (!empty($project_types) && !is_wp_error($project_types)) :
        ?>
            <nav class="project-type-filter animate-on-scroll" id="project-type-filter">
                <a href="<?php echo esc_url(get_post_type_archive_link("project")); ?>"
                   class="filter-pill <?php echo empty($current_type_slug) ? "active" : ""; ?>">
                    <span class="filter-pill-text">All</span>
                    <span class="filter-pill-count"><?php echo intval($total_projects); ?></span>
                </a>
                <?php foreach ($project_types as $type) : ?>
                    <a href="<?php echo esc_url(get_term_link($type)); ?>"
                       class="filter-pill <?php echo ($type->slug === $current_type_slug) ? "active" : ""; ?>">
                        <span class="filter-pill-text"><?php echo esc_html($type->name); ?></span>
                        <span class="filter-pill-count"><?php echo intval($type->count); ?></span>
                    </a>
                <?php endforeach; ?>
            </nav>
        <?php endif; ?>

        <!-- Projects Grid -->
        <div class="projects-grid" id="projects-container">
            <?php
            if ($projects_query->have_posts()) :
                $project_index = 0;
                while ($projects_query->have_posts()) : $projects_query->the_post();
                    // Get project meta
                    $github_url = get_post_meta(get_the_ID(), "_project_github_url", true);
                    $homepage_url = get_post_meta(get_the_ID(), "_project_homepage_url", true);
                    $technologies = get_post_meta(get_the_ID(), "_project_technologies", true);
                    $icon = get_post_meta(get_the_ID(), "_project_icon", true);
                    $is_featured = get_post_meta(get_the_ID(), "_project_featured", true) === "1";

                    // Parse technologies into array
                    $tech_array = array();
                    if (!empty($technologies)) {
                        $tech_array = array_map("trim", explode(",", $technologies));
                    }

                    // Get project types
                    $types = get_the_terms(get_the_ID(), "project_type");
                    $primary_type = (!empty($types) && !is_wp_error($types)) ? $types[0] : null;
            ?>
                <article id="project-<?php the_ID(); ?>"
                         class="project-card animate-on-scroll <?php echo $is_featured ? "featured" : ""; ?>"
                         style="--delay: <?php echo $project_index * 0.1; ?>s;">
                    <div class="project-card-inner">

                        <!-- Project Header -->
                        <div class="project-card-header">
                            <div class="project-icon">
                                <?php echo developer_portfolio_get_project_icon_svg($icon ?: "code"); ?>
                            </div>
                            <?php if ($is_featured) : ?>
                                <span class="project-featured-badge" title="Featured Project">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                    </svg>
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Project Type Badge -->
                        <?php if ($primary_type) : ?>
                            <a href="<?php echo esc_url(get_term_link($primary_type)); ?>" class="project-type-badge">
                                <?php echo esc_html($primary_type->name); ?>
                            </a>
                        <?php endif; ?>

                        <!-- Project Title -->
                        <h2 class="project-card-title">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h2>

                        <!-- Project Description -->
                        <p class="project-card-description">
                            <?php echo wp_trim_words(get_the_excerpt(), 20, "..."); ?>
                        </p>

                        <!-- Technologies -->
                        <?php if (!empty($tech_array)) : ?>
                            <div class="project-tech-tags">
                                <?php foreach (array_slice($tech_array, 0, 4) as $tech) : ?>
                                    <span class="tech-tag"><?php echo esc_html($tech); ?></span>
                                <?php endforeach; ?>
                                <?php if (count($tech_array) > 4) : ?>
                                    <span class="tech-tag tech-tag-more">+<?php echo count($tech_array) - 4; ?></span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Project Links -->
                        <div class="project-card-links">
                            <?php if (!empty($github_url)) : ?>
                                <a href="<?php echo esc_url($github_url); ?>"
                                   class="project-link project-link-github"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   aria-label="View on GitHub">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                    </svg>
                                    <span>GitHub</span>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($homepage_url)) : ?>
                                <a href="<?php echo esc_url($homepage_url); ?>"
                                   class="project-link project-link-demo"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   aria-label="View Demo">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                                        <polyline points="15 3 21 3 21 9"/>
                                        <line x1="10" y1="14" x2="21" y2="3"/>
                                    </svg>
                                    <span>Demo</span>
                                </a>
                            <?php endif; ?>

                            <a href="<?php the_permalink(); ?>" class="project-link project-link-details">
                                <span>Details</span>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="5" y1="12" x2="19" y2="12"/>
                                    <polyline points="12 5 19 12 12 19"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="project-card-glow"></div>
                </article>
            <?php
                    $project_index++;
                endwhile;
                wp_reset_postdata();
            else :
            ?>
                <div class="no-projects-message animate-on-scroll">
                    <div class="no-projects-icon">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                            <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                            <line x1="12" y1="11" x2="12" y2="17"/>
                            <line x1="9" y1="14" x2="15" y2="14"/>
                        </svg>
                    </div>
                    <h2>No Projects Found</h2>
                    <p>
                        <?php if (!empty($current_type_name)) : ?>
                            There are no projects in the "<?php echo esc_html($current_type_name); ?>" category yet.
                        <?php else : ?>
                            There are no projects to display yet. Check back soon!
                        <?php endif; ?>
                    </p>
                    <?php if (!empty($current_type_slug)) : ?>
                        <a href="<?php echo esc_url(get_post_type_archive_link("project")); ?>" class="back-home-link">
                            <span class="arrow">&#x2190;</span> View All Projects
                        </a>
                    <?php else : ?>
                        <a href="<?php echo esc_url(home_url("/")); ?>" class="back-home-link">
                            <span class="arrow">&#x2190;</span> Back to Home
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php if ($projects_query->max_num_pages > 1) : ?>
            <nav class="projects-pagination animate-on-scroll" aria-label="Projects pagination">
                <?php
                echo paginate_links(array(
                    "total"     => $projects_query->max_num_pages,
                    "current"   => $paged,
                    "prev_text" => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg> <span>Previous</span>',
                    "next_text" => '<span>Next</span> <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>',
                    "type"      => "list",
                ));
                ?>
            </nav>
        <?php endif; ?>

        <!-- Call to Action -->
        <div class="projects-cta animate-on-scroll">
            <p class="projects-cta-text">Have a project idea or want to collaborate?</p>
            <a href="mailto:hello@balakumar.dev" class="cta-button primary">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                    <polyline points="22,6 12,13 2,6"/>
                </svg>
                <span>Get in Touch</span>
            </a>
        </div>

    </div>
</main>

<?php
get_footer();
