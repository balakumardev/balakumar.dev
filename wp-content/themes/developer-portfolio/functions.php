<?php
/**
 * Developer Portfolio Theme Functions
 *
 * @package Developer_Portfolio
 * @since 1.0.0
 */

if (!defined("ABSPATH")) {
    exit;
}

/**
 * Theme Setup
 */
function developer_portfolio_setup() {
    // Add theme support
    add_theme_support("title-tag");
    add_theme_support("post-thumbnails");
    add_theme_support("automatic-feed-links");
    add_theme_support("html5", array(
        "search-form",
        "comment-form",
        "comment-list",
        "gallery",
        "caption",
        "style",
        "script"
    ));
    add_theme_support("customize-selective-refresh-widgets");
    add_theme_support("wp-block-styles");
    add_theme_support("responsive-embeds");
    add_theme_support("align-wide");
    
    // Custom logo support
    add_theme_support("custom-logo", array(
        "height"      => 60,
        "width"       => 200,
        "flex-height" => true,
        "flex-width"  => true,
    ));

    // Register navigation menus
    register_nav_menus(array(
        "primary" => esc_html__("Primary Menu", "developer-portfolio"),
        "footer"  => esc_html__("Footer Menu", "developer-portfolio"),
        "social"  => esc_html__("Social Links", "developer-portfolio"),
    ));

    // Set content width
    $GLOBALS["content_width"] = 1200;
}
add_action("after_setup_theme", "developer_portfolio_setup");

/**
 * Enqueue Scripts and Styles
 */
function developer_portfolio_scripts() {
    $theme_version = wp_get_theme()->get("Version");
    
    // Google Fonts - Inter and JetBrains Mono
    wp_enqueue_style(
        "developer-portfolio-fonts",
        "https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600;700&display=swap",
        array(),
        null
    );
    
    // Prism.js for code highlighting
    wp_enqueue_style(
        "prismjs-theme",
        "https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css",
        array(),
        "1.29.0"
    );
    
    // Main theme styles
    wp_enqueue_style(
        "developer-portfolio-main",
        get_template_directory_uri() . "/assets/css/main.css",
        array(),
        $theme_version
    );
    
    // Theme stylesheet
    wp_enqueue_style(
        "developer-portfolio-style",
        get_stylesheet_uri(),
        array("developer-portfolio-main"),
        $theme_version
    );
    
    // Prism.js core and languages
    wp_enqueue_script(
        "prismjs-core",
        "https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js",
        array(),
        "1.29.0",
        true
    );
    
    // Prism.js additional languages
    wp_enqueue_script(
        "prismjs-java",
        "https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-java.min.js",
        array("prismjs-core"),
        "1.29.0",
        true
    );
    wp_enqueue_script(
        "prismjs-python",
        "https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-python.min.js",
        array("prismjs-core"),
        "1.29.0",
        true
    );
    wp_enqueue_script(
        "prismjs-javascript",
        "https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-javascript.min.js",
        array("prismjs-core"),
        "1.29.0",
        true
    );
    wp_enqueue_script(
        "prismjs-bash",
        "https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-bash.min.js",
        array("prismjs-core"),
        "1.29.0",
        true
    );
    wp_enqueue_script(
        "prismjs-json",
        "https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-json.min.js",
        array("prismjs-core"),
        "1.29.0",
        true
    );
    wp_enqueue_script(
        "prismjs-yaml",
        "https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-yaml.min.js",
        array("prismjs-core"),
        "1.29.0",
        true
    );
    wp_enqueue_script(
        "prismjs-sql",
        "https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-sql.min.js",
        array("prismjs-core"),
        "1.29.0",
        true
    );
    wp_enqueue_script(
        "prismjs-go",
        "https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-go.min.js",
        array("prismjs-core"),
        "1.29.0",
        true
    );
    
    // Prism line numbers plugin
    wp_enqueue_style(
        "prismjs-line-numbers",
        "https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/line-numbers/prism-line-numbers.min.css",
        array("prismjs-theme"),
        "1.29.0"
    );
    wp_enqueue_script(
        "prismjs-line-numbers",
        "https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/line-numbers/prism-line-numbers.min.js",
        array("prismjs-core"),
        "1.29.0",
        true
    );
    
    // Main theme JavaScript
    wp_enqueue_script(
        "developer-portfolio-main",
        get_template_directory_uri() . "/assets/js/main.js",
        array(),
        $theme_version,
        true
    );

    // Comments reply script
    if (is_singular() && comments_open() && get_option("thread_comments")) {
        wp_enqueue_script("comment-reply");
    }
}
add_action("wp_enqueue_scripts", "developer_portfolio_scripts");

/**
 * Register Widget Areas
 */
function developer_portfolio_widgets_init() {
    register_sidebar(array(
        "name"          => esc_html__("Sidebar", "developer-portfolio"),
        "id"            => "sidebar-1",
        "description"   => esc_html__("Add widgets here.", "developer-portfolio"),
        "before_widget" => "<section id=\"%1\$s\" class=\"widget %2\$s\">",
        "after_widget"  => "</section>",
        "before_title"  => "<h3 class=\"widget-title\">",
        "after_title"   => "</h3>",
    ));
    
    register_sidebar(array(
        "name"          => esc_html__("Footer Widget Area", "developer-portfolio"),
        "id"            => "footer-1",
        "description"   => esc_html__("Add footer widgets here.", "developer-portfolio"),
        "before_widget" => "<div id=\"%1\$s\" class=\"footer-widget %2\$s\">",
        "after_widget"  => "</div>",
        "before_title"  => "<h4 class=\"footer-widget-title\">",
        "after_title"   => "</h4>",
    ));
}
add_action("widgets_init", "developer_portfolio_widgets_init");

/**
 * Custom Excerpt Length
 */
function developer_portfolio_excerpt_length($length) {
    return 25;
}
add_filter("excerpt_length", "developer_portfolio_excerpt_length");

/**
 * Custom Excerpt More
 */
function developer_portfolio_excerpt_more($more) {
    return "...";
}
add_filter("excerpt_more", "developer_portfolio_excerpt_more");

/**
 * Get category icon class
 */
function developer_portfolio_get_category_icon($category_slug) {
    $icons = array(
        "ai"                  => "brain",
        "artificial-intelligence" => "brain",
        "machine-learning"    => "brain",
        "distributed-systems" => "server",
        "backend"             => "server",
        "microservices"       => "sitemap",
        "crash-courses"       => "graduation-cap",
        "tutorials"           => "graduation-cap",
        "projects"            => "code",
        "programming"         => "code",
        "java"                => "coffee",
        "python"              => "snake",
        "devops"              => "cogs",
        "cloud"               => "cloud",
        "database"            => "database",
        "security"            => "shield-alt",
        "performance"         => "tachometer-alt",
        "architecture"        => "drafting-compass",
        "tools"               => "tools",
        "career"              => "briefcase",
        "productivity"        => "rocket",
        "uncategorized"       => "folder",
    );
    
    return isset($icons[$category_slug]) ? $icons[$category_slug] : "file-alt";
}

/**
 * Get gradient class based on category
 */
function developer_portfolio_get_category_gradient($category_slug) {
    $gradients = array(
        "ai"                  => "gradient-ai",
        "artificial-intelligence" => "gradient-ai",
        "machine-learning"    => "gradient-ai",
        "distributed-systems" => "gradient-systems",
        "backend"             => "gradient-systems",
        "microservices"       => "gradient-systems",
        "crash-courses"       => "gradient-courses",
        "tutorials"           => "gradient-courses",
        "projects"            => "gradient-projects",
        "programming"         => "gradient-projects",
        "java"                => "gradient-java",
        "python"              => "gradient-python",
        "devops"              => "gradient-devops",
        "cloud"               => "gradient-cloud",
    );
    
    return isset($gradients[$category_slug]) ? $gradients[$category_slug] : "gradient-default";
}

/**
 * Calculate reading time
 */
function developer_portfolio_reading_time($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $content = get_post_field("post_content", $post_id);
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200);
    
    return $reading_time < 1 ? 1 : $reading_time;
}

/**
 * Generate Table of Contents from post content
 */
function developer_portfolio_generate_toc($content) {
    preg_match_all("/<h([2-3])[^>]*>(.+?)<\/h[2-3]>/i", $content, $matches, PREG_SET_ORDER);
    
    if (empty($matches)) {
        return "";
    }
    
    $toc = "<nav class=\"toc\" aria-label=\"Table of Contents\">";
    $toc .= "<h3 class=\"toc-title\"><span class=\"toc-icon\">&#x2630;</span> Table of Contents</h3>";
    $toc .= "<ul class=\"toc-list\">";
    
    foreach ($matches as $match) {
        $level = $match[1];
        $title = strip_tags($match[2]);
        $slug = sanitize_title($title);
        $indent_class = $level == 3 ? " toc-indent" : "";
        $toc .= "<li class=\"toc-item{$indent_class}\"><a href=\"#{$slug}\" class=\"toc-link\">{$title}</a></li>";
    }
    
    $toc .= "</ul></nav>";
    
    return $toc;
}

/**
 * Add IDs to headings for TOC links
 */
function developer_portfolio_add_heading_ids($content) {
    $content = preg_replace_callback(
        "/<h([2-3])([^>]*)>(.+?)<\/h[2-3]>/i",
        function($matches) {
            $level = $matches[1];
            $attrs = $matches[2];
            $title = $matches[3];
            $slug = sanitize_title(strip_tags($title));
            
            if (strpos($attrs, "id=") === false) {
                return "<h{$level}{$attrs} id=\"{$slug}\">{$title}</h{$level}>";
            }
            return $matches[0];
        },
        $content
    );
    
    return $content;
}
add_filter("the_content", "developer_portfolio_add_heading_ids");

/**
 * Add line-numbers class to pre tags for Prism.js
 */
function developer_portfolio_add_code_classes($content) {
    $content = preg_replace("/<pre([^>]*)>/", "<pre$1 class=\"line-numbers\">", $content);
    return $content;
}
add_filter("the_content", "developer_portfolio_add_code_classes");

/**
 * Projects data for homepage
 */
function developer_portfolio_get_projects() {
    return array(
        array(
            "title"       => "ContextCraft",
            "description" => "AI-powered context management for LLM applications. Optimizes token usage and maintains conversation coherence.",
            "github"      => "https://github.com/balakumar/contextcraft",
            "tech"        => array("Python", "LangChain", "OpenAI", "Redis"),
            "icon"        => "brain",
        ),
        array(
            "title"       => "PromptForge",
            "description" => "A prompt engineering toolkit for building, testing, and optimizing AI prompts at scale.",
            "github"      => "https://github.com/balakumar/promptforge",
            "tech"        => array("TypeScript", "React", "Node.js", "PostgreSQL"),
            "icon"        => "hammer",
        ),
        array(
            "title"       => "Java Code Navigator",
            "description" => "VS Code extension for enhanced Java code navigation with intelligent symbol resolution.",
            "github"      => "https://github.com/balakumar/java-code-navigator",
            "tech"        => array("TypeScript", "Java", "VS Code API", "LSP"),
            "icon"        => "compass",
        ),
        array(
            "title"       => "Distributed Cache Manager",
            "description" => "High-performance distributed caching solution with automatic failover and consistency guarantees.",
            "github"      => "https://github.com/balakumar/dist-cache-manager",
            "tech"        => array("Java", "Redis", "Kafka", "Spring Boot"),
            "icon"        => "database",
        ),
        array(
            "title"       => "API Gateway Toolkit",
            "description" => "Lightweight API gateway with rate limiting, authentication, and request transformation.",
            "github"      => "https://github.com/balakumar/api-gateway-toolkit",
            "tech"        => array("Go", "gRPC", "Docker", "Kubernetes"),
            "icon"        => "network-wired",
        ),
        array(
            "title"       => "Log Analyzer Pro",
            "description" => "Real-time log analysis and visualization tool for distributed systems debugging.",
            "github"      => "https://github.com/balakumar/log-analyzer-pro",
            "tech"        => array("Python", "Elasticsearch", "Grafana", "Splunk"),
            "icon"        => "chart-line",
        ),
    );
}

/**
 * Social links configuration
 */
function developer_portfolio_get_social_links() {
    return array(
        array(
            "name" => "GitHub",
            "url"  => "https://github.com/balakumar",
            "icon" => "github",
        ),
        array(
            "name" => "LinkedIn",
            "url"  => "https://linkedin.com/in/balakumar",
            "icon" => "linkedin",
        ),
        array(
            "name" => "Twitter",
            "url"  => "https://twitter.com/balakumar",
            "icon" => "twitter",
        ),
        array(
            "name" => "Email",
            "url"  => "mailto:hello@balakumar.dev",
            "icon" => "envelope",
        ),
    );
}

/**
 * Add custom body classes
 */
function developer_portfolio_body_classes($classes) {
    if (is_singular()) {
        $classes[] = "singular";
    }
    if (is_front_page()) {
        $classes[] = "front-page";
    }
    return $classes;
}
add_filter("body_class", "developer_portfolio_body_classes");

/**
 * Remove WordPress version from head
 */
remove_action("wp_head", "wp_generator");

/**
 * Disable emojis
 */
function developer_portfolio_disable_emojis() {
    remove_action("wp_head", "print_emoji_detection_script", 7);
    remove_action("admin_print_scripts", "print_emoji_detection_script");
    remove_action("wp_print_styles", "print_emoji_styles");
    remove_action("admin_print_styles", "print_emoji_styles");
    remove_filter("the_content_feed", "wp_staticize_emoji");
    remove_filter("comment_text_rss", "wp_staticize_emoji");
    remove_filter("wp_mail", "wp_staticize_emoji_for_email");
}
add_action("init", "developer_portfolio_disable_emojis");

/**
 * Get the blog listing URL
 * Returns the URL to the blog page, or falls back to the first category
 */
function developer_portfolio_get_blog_url() {
    // Check if a page_for_posts is set
    $posts_page_id = get_option("page_for_posts");
    if ($posts_page_id && get_post_status($posts_page_id) === "publish") {
        return get_permalink($posts_page_id);
    }
    
    // Check if a page with slug "blog" exists
    $blog_page = get_page_by_path("blog");
    if ($blog_page && $blog_page->post_status === "publish") {
        return get_permalink($blog_page->ID);
    }
    
    // Fall back to the first category with posts
    $categories = get_categories(array(
        "orderby" => "count",
        "order" => "DESC",
        "hide_empty" => true,
        "number" => 1,
    ));
    
    if (!empty($categories)) {
        return get_category_link($categories[0]->term_id);
    }
    
    // Ultimate fallback
    return home_url("/");
}

/**
 * Get social icon SVG
 */
function developer_portfolio_get_social_icon($icon) {
    $icons = array(
        "github" => "<svg width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"currentColor\"><path d=\"M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z\"/></svg>",
        "linkedin" => "<svg width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"currentColor\"><path d=\"M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z\"/></svg>",
        "twitter" => "<svg width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"currentColor\"><path d=\"M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z\"/></svg>",
        "envelope" => "<svg width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\"><path d=\"M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z\"></path><polyline points=\"22,6 12,13 2,6\"></polyline></svg>",
    );
    
    return isset($icons[$icon]) ? $icons[$icon] : "";
}

/**
 * Footer menu fallback
 */
function developer_portfolio_footer_fallback() {
    echo "<ul class=\"footer-menu\">";
    echo "<li><a href=\"" . esc_url(home_url("/")) . "\">Home</a></li>";
    echo "<li><a href=\"" . esc_url(home_url("/blog")) . "\">Blog</a></li>";
    echo "<li><a href=\"" . esc_url(home_url("/about")) . "\">About</a></li>";
    echo "<li><a href=\"" . esc_url(home_url("/contact")) . "\">Contact</a></li>";
    echo "</ul>";
}

/**
 * AJAX Category Filter Handler
 */
function developer_portfolio_filter_posts() {
    // Verify nonce
    if (!isset($_POST["nonce"]) || !wp_verify_nonce($_POST["nonce"], "developer_portfolio_ajax")) {
        wp_send_json_error("Invalid nonce");
        return;
    }

    $category = isset($_POST["category"]) ? sanitize_text_field($_POST["category"]) : "";
    $page = isset($_POST["page"]) ? intval($_POST["page"]) : 1;
    
    $args = array(
        "post_type"      => "post",
        "post_status"    => "publish",
        "posts_per_page" => 6,
        "paged"          => $page,
    );
    
    if (!empty($category) && $category !== "all") {
        $args["category_name"] = $category;
    }
    
    $query = new WP_Query($args);
    
    ob_start();
    
    if ($query->have_posts()) :
        $post_index = 0;
        while ($query->have_posts()) : $query->the_post();
            $categories = get_the_category();
            $primary_cat = !empty($categories) ? $categories[0] : null;
            $gradient_class = $primary_cat ? developer_portfolio_get_category_gradient($primary_cat->slug) : "gradient-default";
            $reading_time = developer_portfolio_reading_time();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class("post-card animate-on-scroll " . $gradient_class); ?> style="--delay: <?php echo $post_index * 0.05; ?>s;">
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
        wp_reset_postdata();
    else :
        ?>
        <div class="no-posts-message animate-on-scroll">
            <div class="no-posts-icon">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
            </div>
            <h2>No Posts Found</h2>
            <p>There are no articles in this category yet.</p>
        </div>
        <?php
    endif;
    
    $html = ob_get_clean();
    
    wp_send_json_success(array(
        "html"        => $html,
        "found_posts" => $query->found_posts,
        "max_pages"   => $query->max_num_pages,
        "current_page"=> $page,
    ));
}
add_action("wp_ajax_filter_posts", "developer_portfolio_filter_posts");
add_action("wp_ajax_nopriv_filter_posts", "developer_portfolio_filter_posts");

/**
 * AJAX Load More Handler
 */
function developer_portfolio_load_more() {
    // Verify nonce
    if (!isset($_POST["nonce"]) || !wp_verify_nonce($_POST["nonce"], "developer_portfolio_ajax")) {
        wp_send_json_error("Invalid nonce");
        return;
    }

    $category = isset($_POST["category"]) ? sanitize_text_field($_POST["category"]) : "";
    $page = isset($_POST["page"]) ? intval($_POST["page"]) : 1;
    
    $args = array(
        "post_type"      => "post",
        "post_status"    => "publish",
        "posts_per_page" => 6,
        "paged"          => $page,
    );
    
    if (!empty($category) && $category !== "all") {
        $args["category_name"] = $category;
    }
    
    $query = new WP_Query($args);
    
    ob_start();
    
    if ($query->have_posts()) :
        $post_index = 0;
        while ($query->have_posts()) : $query->the_post();
            $categories = get_the_category();
            $primary_cat = !empty($categories) ? $categories[0] : null;
            $gradient_class = $primary_cat ? developer_portfolio_get_category_gradient($primary_cat->slug) : "gradient-default";
            $reading_time = developer_portfolio_reading_time();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class("post-card animate-on-scroll " . $gradient_class); ?> style="--delay: <?php echo $post_index * 0.05; ?>s;">
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
        wp_reset_postdata();
    endif;
    
    $html = ob_get_clean();
    
    wp_send_json_success(array(
        "html"        => $html,
        "found_posts" => $query->found_posts,
        "max_pages"   => $query->max_num_pages,
        "current_page"=> $page,
    ));
}
add_action("wp_ajax_load_more_posts", "developer_portfolio_load_more");
add_action("wp_ajax_nopriv_load_more_posts", "developer_portfolio_load_more");

/**
 * Enqueue AJAX Scripts with localized data
 */
function developer_portfolio_ajax_scripts() {
    if (is_home() || is_archive() || is_front_page() || is_page_template("page-blog.php") || is_page("blog")) {
        wp_localize_script("developer-portfolio-main", "devPortfolioAjax", array(
            "ajaxUrl" => admin_url("admin-ajax.php"),
            "nonce"   => wp_create_nonce("developer_portfolio_ajax"),
        ));
    }
}
add_action("wp_enqueue_scripts", "developer_portfolio_ajax_scripts", 20);

/**
 * ========================================
 * PROJECTS CUSTOM POST TYPE & TAXONOMY
 * ========================================
 */

/**
 * Register Projects Custom Post Type
 */
function developer_portfolio_register_projects_cpt() {
    $labels = array(
        'name'                  => _x('Projects', 'Post Type General Name', 'developer-portfolio'),
        'singular_name'         => _x('Project', 'Post Type Singular Name', 'developer-portfolio'),
        'menu_name'             => __('Projects', 'developer-portfolio'),
        'name_admin_bar'        => __('Project', 'developer-portfolio'),
        'add_new'               => __('Add New', 'developer-portfolio'),
        'add_new_item'          => __('Add New Project', 'developer-portfolio'),
        'edit_item'             => __('Edit Project', 'developer-portfolio'),
        'new_item'              => __('New Project', 'developer-portfolio'),
        'view_item'             => __('View Project', 'developer-portfolio'),
        'view_items'            => __('View Projects', 'developer-portfolio'),
        'search_items'          => __('Search Projects', 'developer-portfolio'),
        'not_found'             => __('No projects found.', 'developer-portfolio'),
        'not_found_in_trash'    => __('No projects found in Trash.', 'developer-portfolio'),
        'all_items'             => __('All Projects', 'developer-portfolio'),
        'archives'              => __('Project Archives', 'developer-portfolio'),
        'attributes'            => __('Project Attributes', 'developer-portfolio'),
    );

    $args = array(
        'label'                 => __('Project', 'developer-portfolio'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt'),
        'taxonomies'            => array('project_type'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-portfolio',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'show_in_rest'          => true,
        'has_archive'           => 'projects',
        'rewrite'               => array('slug' => 'project', 'with_front' => false),
        'capability_type'       => 'post',
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
    );

    register_post_type('project', $args);
}
add_action('init', 'developer_portfolio_register_projects_cpt', 0);

/**
 * Register Project Type Taxonomy
 */
function developer_portfolio_register_project_type_taxonomy() {
    $labels = array(
        'name'                       => _x('Project Types', 'taxonomy general name', 'developer-portfolio'),
        'singular_name'              => _x('Project Type', 'taxonomy singular name', 'developer-portfolio'),
        'search_items'               => __('Search Project Types', 'developer-portfolio'),
        'popular_items'              => __('Popular Project Types', 'developer-portfolio'),
        'all_items'                  => __('All Project Types', 'developer-portfolio'),
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => __('Edit Project Type', 'developer-portfolio'),
        'update_item'                => __('Update Project Type', 'developer-portfolio'),
        'add_new_item'               => __('Add New Project Type', 'developer-portfolio'),
        'new_item_name'              => __('New Project Type Name', 'developer-portfolio'),
        'separate_items_with_commas' => __('Separate project types with commas', 'developer-portfolio'),
        'add_or_remove_items'        => __('Add or remove project types', 'developer-portfolio'),
        'choose_from_most_used'      => __('Choose from the most used project types', 'developer-portfolio'),
        'not_found'                  => __('No project types found.', 'developer-portfolio'),
        'menu_name'                  => __('Project Types', 'developer-portfolio'),
    );

    $args = array(
        'hierarchical'          => true,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'show_in_rest'          => true,
        'query_var'             => true,
        'rewrite'               => array('slug' => 'project-type'),
    );

    register_taxonomy('project_type', array('project'), $args);
}
add_action('init', 'developer_portfolio_register_project_type_taxonomy', 0);

/**
 * Add default project type terms on theme activation
 */
function developer_portfolio_add_default_project_types() {
    $default_types = array(
        'macos-app'         => 'macOS App',
        'browser-extension' => 'Browser Extension',
        'ide-plugin'        => 'IDE Plugin',
        'mcp-server'        => 'MCP Server',
        'developer-tool'    => 'Developer Tool',
        'documentation'     => 'Documentation',
        'web-app'           => 'Web App',
        'cli-tool'          => 'CLI Tool',
    );

    foreach ($default_types as $slug => $name) {
        if (!term_exists($slug, 'project_type')) {
            wp_insert_term($name, 'project_type', array('slug' => $slug));
        }
    }
}
add_action('after_switch_theme', 'developer_portfolio_add_default_project_types');

/**
 * Also run on init (once) for development
 */
function developer_portfolio_ensure_project_types() {
    if (get_option('developer_portfolio_project_types_created') !== 'yes') {
        developer_portfolio_add_default_project_types();
        update_option('developer_portfolio_project_types_created', 'yes');
    }
}
add_action('init', 'developer_portfolio_ensure_project_types', 10);

/**
 * Add Project Meta Box
 */
function developer_portfolio_add_project_meta_boxes() {
    add_meta_box(
        'project_details',
        __('Project Details', 'developer-portfolio'),
        'developer_portfolio_project_details_callback',
        'project',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'developer_portfolio_add_project_meta_boxes');

/**
 * Project Details Meta Box Callback
 */
function developer_portfolio_project_details_callback($post) {
    wp_nonce_field('developer_portfolio_project_details', 'developer_portfolio_project_nonce');

    $github_url = get_post_meta($post->ID, '_project_github_url', true);
    $project_links = get_post_meta($post->ID, '_project_links', true);
    $technologies = get_post_meta($post->ID, '_project_technologies', true);
    $icon = get_post_meta($post->ID, '_project_icon', true);
    $featured = get_post_meta($post->ID, '_project_featured', true);
    $sort_order = get_post_meta($post->ID, '_project_sort_order', true);
    $screenshots = get_post_meta($post->ID, '_project_screenshots', true);

    $available_icons = array(
        'brain'         => 'Brain (AI/ML)',
        'apple'         => 'Apple (macOS)',
        'firefox'       => 'Firefox (Browser)',
        'code'          => 'Code',
        'terminal'      => 'Terminal',
        'puzzle'        => 'Puzzle (Plugin)',
        'server'        => 'Server',
        'database'      => 'Database',
        'book'          => 'Book (Docs)',
        'hammer'        => 'Hammer (Tool)',
        'compass'       => 'Compass',
        'chart-line'    => 'Chart',
        'network-wired' => 'Network',
        'cog'           => 'Settings/Cog',
        'rocket'        => 'Rocket',
    );
    ?>
    <style>
        .project-meta-row { margin-bottom: 15px; }
        .project-meta-row label { display: block; font-weight: 600; margin-bottom: 5px; }
        .project-meta-row input[type="text"],
        .project-meta-row input[type="url"],
        .project-meta-row input[type="number"],
        .project-meta-row select { width: 100%; max-width: 500px; padding: 8px; }
        .project-meta-row input[type="checkbox"] { margin-right: 8px; }
        .project-meta-description { color: #666; font-size: 12px; margin-top: 3px; }
    </style>

    <div class="project-meta-row">
        <label for="project_github_url"><?php _e('GitHub URL', 'developer-portfolio'); ?></label>
        <input type="url" id="project_github_url" name="project_github_url"
               value="<?php echo esc_attr($github_url); ?>" placeholder="https://github.com/username/repo">
        <p class="project-meta-description"><?php _e('The GitHub repository URL for this project.', 'developer-portfolio'); ?></p>
    </div>

    <div class="project-meta-row">
        <label for="project_links"><?php _e('Project Links', 'developer-portfolio'); ?></label>
        <textarea id="project_links" name="project_links" rows="4" placeholder="https://apps.apple.com/app/myapp&#10;https://play.google.com/store/apps/details?id=myapp&#10;https://chrome.google.com/webstore/detail/myext&#10;https://myproject.com"><?php echo esc_textarea($project_links); ?></textarea>
        <p class="project-meta-description"><?php _e('One URL per line. Supported: App Store, Play Store, Chrome Web Store, Firefox Add-ons, npm, PyPI, or any website. Icons are auto-detected.', 'developer-portfolio'); ?></p>
    </div>

    <div class="project-meta-row">
        <label for="project_technologies"><?php _e('Technologies', 'developer-portfolio'); ?></label>
        <input type="text" id="project_technologies" name="project_technologies"
               value="<?php echo esc_attr($technologies); ?>" placeholder="Swift, Python, TypeScript">
        <p class="project-meta-description"><?php _e('Comma-separated list of technologies used.', 'developer-portfolio'); ?></p>
    </div>

    <div class="project-meta-row">
        <label for="project_icon"><?php _e('Project Icon', 'developer-portfolio'); ?></label>
        <select id="project_icon" name="project_icon">
            <option value=""><?php _e('Select an icon...', 'developer-portfolio'); ?></option>
            <?php foreach ($available_icons as $value => $label) : ?>
                <option value="<?php echo esc_attr($value); ?>" <?php selected($icon, $value); ?>>
                    <?php echo esc_html($label); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <p class="project-meta-description"><?php _e('Icon to display for this project.', 'developer-portfolio'); ?></p>
    </div>

    <div class="project-meta-row">
        <label for="project_sort_order"><?php _e('Sort Order', 'developer-portfolio'); ?></label>
        <input type="number" id="project_sort_order" name="project_sort_order"
               value="<?php echo esc_attr($sort_order ?: '0'); ?>" min="0" step="1" style="width: 100px;">
        <p class="project-meta-description"><?php _e('Lower numbers appear first. Default is 0.', 'developer-portfolio'); ?></p>
    </div>

    <div class="project-meta-row">
        <label>
            <input type="checkbox" id="project_featured" name="project_featured" value="1" <?php checked($featured, '1'); ?>>
            <?php _e('Featured Project', 'developer-portfolio'); ?>
        </label>
        <p class="project-meta-description"><?php _e('Featured projects are highlighted on the homepage.', 'developer-portfolio'); ?></p>
    </div>

    <hr style="margin: 20px 0;">

    <div class="project-meta-row">
        <label><?php _e('Screenshots / Gallery', 'developer-portfolio'); ?></label>
        <p class="project-meta-description" style="margin-bottom: 10px;">
            <?php _e('Add screenshots of your project. These will be displayed on the project detail page.', 'developer-portfolio'); ?>
        </p>

        <div id="project-screenshots-container" style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 10px;">
            <?php
            if (!empty($screenshots)) {
                $image_ids = array_filter(array_map('trim', explode(',', $screenshots)));
                foreach ($image_ids as $image_id) {
                    $image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
                    if ($image_url) {
                        echo '<div class="screenshot-item" data-id="' . esc_attr($image_id) . '" style="position: relative;">';
                        echo '<img src="' . esc_url($image_url) . '" style="width: 120px; height: 80px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;">';
                        echo '<button type="button" class="remove-screenshot" style="position: absolute; top: -8px; right: -8px; background: #dc3545; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-size: 12px; line-height: 1;">&times;</button>';
                        echo '</div>';
                    }
                }
            }
            ?>
        </div>

        <input type="hidden" id="project_screenshots" name="project_screenshots" value="<?php echo esc_attr($screenshots); ?>">
        <button type="button" id="add-screenshots-btn" class="button"><?php _e('Add Screenshots', 'developer-portfolio'); ?></button>
    </div>

    <script>
    jQuery(document).ready(function($) {
        var frame;

        $('#add-screenshots-btn').on('click', function(e) {
            e.preventDefault();

            if (frame) {
                frame.open();
                return;
            }

            frame = wp.media({
                title: '<?php _e('Select Screenshots', 'developer-portfolio'); ?>',
                button: { text: '<?php _e('Add to Gallery', 'developer-portfolio'); ?>' },
                multiple: true,
                library: { type: 'image' }
            });

            frame.on('select', function() {
                var attachments = frame.state().get('selection').toJSON();
                var container = $('#project-screenshots-container');
                var currentIds = $('#project_screenshots').val();
                var idsArray = currentIds ? currentIds.split(',').filter(Boolean) : [];

                attachments.forEach(function(attachment) {
                    if (idsArray.indexOf(attachment.id.toString()) === -1) {
                        idsArray.push(attachment.id);
                        var thumbUrl = attachment.sizes && attachment.sizes.thumbnail
                            ? attachment.sizes.thumbnail.url
                            : attachment.url;
                        container.append(
                            '<div class="screenshot-item" data-id="' + attachment.id + '" style="position: relative;">' +
                            '<img src="' + thumbUrl + '" style="width: 120px; height: 80px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;">' +
                            '<button type="button" class="remove-screenshot" style="position: absolute; top: -8px; right: -8px; background: #dc3545; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-size: 12px; line-height: 1;">&times;</button>' +
                            '</div>'
                        );
                    }
                });

                $('#project_screenshots').val(idsArray.join(','));
            });

            frame.open();
        });

        $(document).on('click', '.remove-screenshot', function() {
            var item = $(this).closest('.screenshot-item');
            var id = item.data('id').toString();
            var currentIds = $('#project_screenshots').val().split(',').filter(Boolean);
            var newIds = currentIds.filter(function(i) { return i !== id; });
            $('#project_screenshots').val(newIds.join(','));
            item.remove();
        });
    });
    </script>
    <?php
}

/**
 * Save Project Meta Box Data
 */
function developer_portfolio_save_project_meta($post_id) {
    // Check nonce
    if (!isset($_POST['developer_portfolio_project_nonce']) ||
        !wp_verify_nonce($_POST['developer_portfolio_project_nonce'], 'developer_portfolio_project_details')) {
        return;
    }

    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save fields
    $fields = array(
        'project_github_url'   => '_project_github_url',
        'project_links'        => '_project_links',
        'project_technologies' => '_project_technologies',
        'project_icon'         => '_project_icon',
        'project_sort_order'   => '_project_sort_order',
        'project_screenshots'  => '_project_screenshots',
    );

    foreach ($fields as $field => $meta_key) {
        if (isset($_POST[$field])) {
            // Use textarea sanitization for multi-line fields
            if ($field === 'project_links') {
                $value = sanitize_textarea_field($_POST[$field]);
            } else {
                $value = sanitize_text_field($_POST[$field]);
            }
            update_post_meta($post_id, $meta_key, $value);
        }
    }

    // Handle checkbox
    $featured = isset($_POST['project_featured']) ? '1' : '0';
    update_post_meta($post_id, '_project_featured', $featured);
}

/**
 * Enqueue media scripts for project edit page
 */
function developer_portfolio_enqueue_project_admin_scripts($hook) {
    global $post_type;
    if (($hook === 'post.php' || $hook === 'post-new.php') && $post_type === 'project') {
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'developer_portfolio_enqueue_project_admin_scripts');
add_action('save_post_project', 'developer_portfolio_save_project_meta');

/**
 * Get project icon SVG by name
 */
function developer_portfolio_get_project_icon_svg($icon_name) {
    $icons = array(
        'brain' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9.5 2A2.5 2.5 0 0 1 12 4.5v15a2.5 2.5 0 0 1-4.96.44 2.5 2.5 0 0 1-2.96-3.08 3 3 0 0 1-.34-5.58 2.5 2.5 0 0 1 1.32-4.24 2.5 2.5 0 0 1 4.44-1.54"/><path d="M14.5 2A2.5 2.5 0 0 0 12 4.5v15a2.5 2.5 0 0 0 4.96.44 2.5 2.5 0 0 0 2.96-3.08 3 3 0 0 0 .34-5.58 2.5 2.5 0 0 0-1.32-4.24 2.5 2.5 0 0 0-4.44-1.54"/></svg>',
        'apple' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/></svg>',
        'firefox' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.568 5.834c-.328-.234-.724-.34-1.12-.34-.328 0-.656.072-.956.2-.38.17-.688.434-.89.766-.204.332-.31.713-.31 1.103v.026c.003.26.047.52.127.77.08.25.197.487.346.703.15.217.33.41.535.578.206.168.436.308.68.418-.07.35-.18.69-.33 1.01-.24.52-.57 1-.96 1.41-.39.42-.84.77-1.33 1.05-.5.28-1.03.48-1.58.6-.27.06-.55.1-.83.12-.28.02-.56.02-.84 0-.27-.02-.54-.06-.8-.12-.51-.12-1-.32-1.44-.59-.44-.27-.84-.6-1.18-.99-.34-.39-.62-.83-.83-1.3-.21-.47-.35-.97-.42-1.49-.07-.51-.07-1.04 0-1.55.07-.51.21-1.01.42-1.48.21-.47.49-.91.83-1.3.34-.39.74-.72 1.18-.99.44-.27.93-.47 1.44-.59.26-.06.53-.1.8-.12.28-.02.56-.02.84 0 .28.02.56.06.83.12.55.12 1.08.32 1.58.6.49.28.94.63 1.33 1.05.39.41.72.89.96 1.41.15.32.26.66.33 1.01.24-.11.47-.25.68-.42.2-.17.39-.36.54-.58.15-.22.27-.45.35-.7.08-.25.12-.51.13-.77v-.03c0-.39-.1-.77-.31-1.1-.2-.33-.51-.6-.89-.77-.3-.13-.63-.2-.96-.2-.4 0-.79.11-1.12.34z"/></svg>',
        'code' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>',
        'terminal' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="4 17 10 11 4 5"/><line x1="12" y1="19" x2="20" y2="19"/></svg>',
        'puzzle' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M19.439 7.85c-.049.322.059.648.289.878l1.568 1.568c.47.47.706 1.087.706 1.704s-.235 1.233-.706 1.704l-1.611 1.611a.98.98 0 0 1-.837.276c-.47-.07-.802-.48-.968-.925a2.501 2.501 0 1 0-3.214 3.214c.446.166.855.497.925.968a.979.979 0 0 1-.276.837l-1.61 1.61a2.404 2.404 0 0 1-1.705.707 2.402 2.402 0 0 1-1.704-.706l-1.568-1.568a1.026 1.026 0 0 0-.877-.29c-.493.074-.84.504-1.02.968a2.5 2.5 0 1 1-3.237-3.237c.464-.18.894-.527.967-1.02a1.026 1.026 0 0 0-.289-.877l-1.568-1.568A2.402 2.402 0 0 1 1.998 12c0-.617.236-1.234.706-1.704L4.315 8.685a.98.98 0 0 1 .837-.276c.47.07.802.48.968.925a2.501 2.501 0 1 0 3.214-3.214c-.446-.166-.855-.497-.925-.968a.979.979 0 0 1 .276-.837l1.61-1.61a2.404 2.404 0 0 1 1.705-.707c.617 0 1.234.236 1.704.706l1.568 1.568c.23.23.556.338.877.29.493-.074.84-.504 1.02-.968a2.5 2.5 0 1 1 3.237 3.237c-.464.18-.894.527-.967 1.02Z"/></svg>',
        'server' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect width="20" height="8" x="2" y="2" rx="2" ry="2"/><rect width="20" height="8" x="2" y="14" rx="2" ry="2"/><line x1="6" x2="6.01" y1="6" y2="6"/><line x1="6" x2="6.01" y1="18" y2="18"/></svg>',
        'database' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5V19A9 3 0 0 0 21 19V5"/><path d="M3 12A9 3 0 0 0 21 12"/></svg>',
        'book' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg>',
        'hammer' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="m15 12-8.5 8.5c-.83.83-2.17.83-3 0 0 0 0 0 0 0a2.12 2.12 0 0 1 0-3L12 9"/><path d="M17.64 15 22 10.64"/><path d="m20.91 11.7-1.25-1.25c-.6-.6-.93-1.4-.93-2.25v-.86L16.01 4.6a5.56 5.56 0 0 0-3.94-1.64H9l.92.82A6.18 6.18 0 0 1 12 8.4v1.56l2 2h2.47l2.26 1.91"/></svg>',
        'compass' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></svg>',
        'chart-line' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>',
        'network-wired' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="9" y="2" width="6" height="6" rx="1"/><rect x="2" y="16" width="6" height="6" rx="1"/><rect x="16" y="16" width="6" height="6" rx="1"/><path d="M5 16v-3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3"/><path d="M12 12V8"/></svg>',
        'cog' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>',
        'rocket' => '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/><path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/><path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"/><path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/></svg>',
    );

    return isset($icons[$icon_name]) ? $icons[$icon_name] : $icons['code'];
}

/**
 * Get link info (type, label, icon, style) from URL
 */
function developer_portfolio_get_link_info($url) {
    $url_lower = strtolower($url);

    // Define link patterns and their info
    $patterns = array(
        // App Stores
        array(
            'pattern' => 'apps.apple.com',
            'type' => 'appstore',
            'label' => 'App Store',
            'style' => 'appstore',
            'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/></svg>',
        ),
        array(
            'pattern' => 'play.google.com',
            'type' => 'playstore',
            'label' => 'Google Play',
            'style' => 'playstore',
            'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M3,20.5V3.5C3,2.91 3.34,2.39 3.84,2.15L13.69,12L3.84,21.85C3.34,21.6 3,21.09 3,20.5M16.81,15.12L6.05,21.34L14.54,12.85L16.81,15.12M20.16,10.81C20.5,11.08 20.75,11.5 20.75,12C20.75,12.5 20.53,12.9 20.18,13.18L17.89,14.5L15.39,12L17.89,9.5L20.16,10.81M6.05,2.66L16.81,8.88L14.54,11.15L6.05,2.66Z"/></svg>',
        ),
        array(
            'pattern' => 'chrome.google.com/webstore',
            'type' => 'chromestore',
            'label' => 'Chrome Web Store',
            'style' => 'chromestore',
            'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C8.21 0 4.831 1.757 2.632 4.501l3.953 6.848A5.454 5.454 0 0 1 12 6.545h10.691A12 12 0 0 0 12 0zM1.931 5.47A11.943 11.943 0 0 0 0 12c0 6.012 4.42 10.991 10.189 11.864l3.953-6.847a5.45 5.45 0 0 1-6.865-2.29zm13.342 2.166a5.446 5.446 0 0 1 1.45 7.09l.002.001h-.002l-3.952 6.848a12.014 12.014 0 0 0 9.229-9.006zM12 16.364a4.364 4.364 0 1 1 0-8.728 4.364 4.364 0 0 1 0 8.728z"/></svg>',
        ),
        // Browser Extensions
        array(
            'pattern' => 'addons.mozilla.org',
            'type' => 'firefox',
            'label' => 'Firefox Add-ons',
            'style' => 'firefox',
            'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12.001 0C5.376 0 0 5.373 0 11.998c0 .086.008.17.01.256C.03 5.993 5.384.63 11.998.63c.083 0 .165.007.247.01V0h-.244zm11.733 8.046c-.502-1.627-1.328-2.99-2.36-4.082-.196.18-.406.352-.63.51.188.24.364.49.524.75.79 1.29 1.25 2.81 1.29 4.44.03 1.55-.33 3.02-1.02 4.32-.45.85-1.04 1.61-1.74 2.26l.01.01c-1.75 1.64-4.1 2.64-6.69 2.64-5.46 0-9.89-4.43-9.89-9.89 0-.31.02-.62.05-.92-.36-.09-.7-.21-1.03-.36-.07.42-.11.85-.11 1.28 0 6.07 4.93 11 11 11s11-4.93 11-11c0-1.06-.15-2.08-.44-3.05z"/></svg>',
        ),
        array(
            'pattern' => 'microsoftedge.microsoft.com/addons',
            'type' => 'edge',
            'label' => 'Edge Add-ons',
            'style' => 'edge',
            'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M21.86 17.86q.14 0 .25.12.1.13.1.25t-.11.33l-.32.46-.43.53-.44.5q-.21.25-.38.42l-.22.23q-.58.53-1.34 1.04-.76.51-1.6.91-.86.4-1.74.64t-1.67.24q-.9 0-1.69-.28-.8-.28-1.48-.78-.68-.5-1.22-1.17-.53-.66-.92-1.44-.38-.77-.58-1.6-.2-.83-.2-1.67 0-1 .32-1.96.33-.97.87-1.8.14.95.55 1.77.41.81 1.02 1.49.6.68 1.38 1.21.78.54 1.64.9.53.12 1.1.18.56.06 1.13.06.9 0 1.78-.17.87-.17 1.72-.5.85-.32 1.67-.79.8-.48 1.56-1.1.29.24.29.63z"/><path d="M11.96.06q1.35 0 2.56.36 1.21.36 2.27.99 1.06.64 1.95 1.5.9.86 1.6 1.86.68 1 1.15 2.1.48 1.12.72 2.31.08.5.12 1 .05.5.05 1 0 1.73-.57 3.26-.56 1.53-1.58 2.76-.36-.47-.83-.84-.47-.37-1-.63-.53-.26-1.1-.42-.58-.17-1.17-.17-1.18 0-2.18.39-1 .4-1.83 1.05-.83.66-1.49 1.5-.66.83-1.13 1.76-.03.1-.08.2l-.08.21q-.17.43-.32.9-.14.47-.25.96-.11.49-.19.99-.07.5-.11 1.01-.3-.06-.62-.19-.32-.14-.64-.35-.32-.21-.64-.5-.32-.28-.6-.62-.3-.35-.53-.75-.24-.4-.43-.84-.18-.44-.31-.9-.14-.47-.2-.96-.06-.49-.06-.97 0-1.98.72-3.7.71-1.73 2.01-3.01 1.3-1.27 3.1-1.98 1.8-.7 3.96-.7 1.38 0 2.6.27 1.21.26 2.28.73.18-.93.18-1.87 0-1.17-.27-2.24-.27-1.08-.77-2.03-.5-.95-1.2-1.76-.7-.82-1.57-1.48-.86-.66-1.84-1.14-.97-.48-2-.75-1.03-.28-2.1-.35-1.05-.08-2.1.04-1.03.12-2.02.44-.99.32-1.9.82-.9.5-1.7 1.16-.78.66-1.45 1.46-.66.79-1.18 1.7-.51.91-.88 1.9-.36.98-.56 2.01-.2 1.02-.2 2.07 0 .93.19 1.85.2.93.56 1.8.37.88.91 1.67.53.8 1.2 1.5-.32.09-.62.13-.3.04-.61.04-1.19 0-2.22-.4-1.02-.4-1.84-1.1-.8-.7-1.38-1.65-.57-.94-.89-2.05Q0 13.65 0 12.24q0-1.74.5-3.3.5-1.57 1.4-2.9.9-1.34 2.14-2.4Q5.29 2.57 6.8 1.81 8.3 1.06 10 .61 11.69.17 13.5.06h-.03z"/></svg>',
        ),
        // Package Managers
        array(
            'pattern' => 'npmjs.com',
            'type' => 'npm',
            'label' => 'npm',
            'style' => 'npm',
            'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M1.763 0C.786 0 0 .786 0 1.763v20.474C0 23.214.786 24 1.763 24h20.474c.977 0 1.763-.786 1.763-1.763V1.763C24 .786 23.214 0 22.237 0zM5.13 5.323l13.837.019-.009 13.836h-3.464l.01-10.382h-3.456L12.04 19.17H5.113z"/></svg>',
        ),
        array(
            'pattern' => 'pypi.org',
            'type' => 'pypi',
            'label' => 'PyPI',
            'style' => 'pypi',
            'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M23.922 9.96c0 1.12-.478 2.065-1.105 2.73-.596.63-1.354 1.015-2.142 1.188v.014c.035.095.056.192.068.29l.008.136v7.25c0 .57-.246 1.108-.68 1.495-.433.386-.99.603-1.568.603h-5.73c-.292 0-.557-.128-.755-.333-.197-.204-.32-.49-.32-.787v-5.227h-1.626v5.227c0 .297-.124.583-.32.787-.199.205-.464.333-.756.333H3.27c-.578 0-1.135-.217-1.568-.603-.434-.387-.68-.925-.68-1.495v-7.25c0-.102.015-.2.044-.293-.788-.173-1.546-.558-2.142-1.189C.297 12.024-.18 11.08-.18 9.96V2.71c0-.57.247-1.107.68-1.494C.935.83 1.49.614 2.069.614h5.73c.292 0 .557.128.755.333.198.205.32.49.32.787v5.227h1.626V1.734c0-.297.123-.582.32-.787.198-.205.463-.333.755-.333h5.73c.579 0 1.135.216 1.569.603.433.387.68.925.68 1.494zm-4.64 9.55v-5.12c0-.214-.072-.415-.202-.575-.131-.16-.32-.267-.52-.295-.055-.008-.11-.012-.166-.012h-3.167v5.476h3.167c.056 0 .11-.004.166-.012.2-.028.389-.135.52-.295.13-.16.201-.361.201-.575v-.592zm-14.16-5.12v6.304c0 .214.072.415.202.575.13.16.32.267.52.295.055.008.11.012.166.012h3.167v-6.66H5.91c-.056 0-.11.004-.166.012-.2.028-.389.135-.52.295-.13.16-.201.361-.201.575v-.408z"/></svg>',
        ),
        // Code Repositories (non-GitHub)
        array(
            'pattern' => 'gitlab.com',
            'type' => 'gitlab',
            'label' => 'GitLab',
            'style' => 'gitlab',
            'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="m23.6004 9.5927-.0337-.0862L20.3.9814a.851.851 0 0 0-.3362-.405.8748.8748 0 0 0-.9997.0539.8748.8748 0 0 0-.29.4399l-2.2055 6.748H7.5375l-2.2057-6.748a.8573.8573 0 0 0-.29-.4412.8748.8748 0 0 0-.9997-.0537.8585.8585 0 0 0-.3362.4049L.4332 9.5065l-.0349.0862a6.0657 6.0657 0 0 0 2.0106 7.0134l.0113.0087.0295.0222 4.8428 3.6218 2.3982 1.8138 1.4606 1.1041a1.0085 1.0085 0 0 0 1.2197 0l1.4606-1.1041 2.3982-1.8138 4.8745-3.6442.0125-.01a6.0682 6.0682 0 0 0 2.0094-7.0109z"/></svg>',
        ),
        array(
            'pattern' => 'bitbucket.org',
            'type' => 'bitbucket',
            'label' => 'Bitbucket',
            'style' => 'bitbucket',
            'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M.778 1.213a.768.768 0 0 0-.768.892l3.263 19.81c.084.5.515.868 1.022.873H19.95a.772.772 0 0 0 .77-.646l3.27-20.03a.768.768 0 0 0-.768-.891zM14.52 15.53H9.522L8.17 8.466h7.561z"/></svg>',
        ),
        // Documentation
        array(
            'pattern' => 'docs.',
            'type' => 'docs',
            'label' => 'Documentation',
            'style' => 'demo',
            'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg>',
        ),
    );

    // Check each pattern
    foreach ($patterns as $p) {
        if (strpos($url_lower, $p['pattern']) !== false) {
            return $p;
        }
    }

    // Default: generic website link
    return array(
        'type' => 'website',
        'label' => 'Website',
        'style' => 'demo',
        'icon' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>',
    );
}

/**
 * Flush rewrite rules on theme activation
 */
function developer_portfolio_flush_rewrite_rules() {
    developer_portfolio_register_projects_cpt();
    developer_portfolio_register_project_type_taxonomy();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'developer_portfolio_flush_rewrite_rules');

/**
 * Custom error handler for graceful degradation
 * 
 * Logs errors but prevents them from breaking the page in production
 */
function developer_portfolio_error_handler($errno, $errstr, $errfile, $errline) {
    // Only handle errors in theme files
    $theme_path = get_template_directory();
    if (strpos($errfile, $theme_path) === false) {
        return false; // Let other error handlers deal with non-theme errors
    }
    
    // Log the error
    $error_message = sprintf(
        "Theme Error [%d]: %s in %s on line %d",
        $errno,
        $errstr,
        basename($errfile),
        $errline
    );
    error_log($error_message);
    
    // In production (WP_DEBUG is false), suppress the error display
    if (!defined('WP_DEBUG') || !WP_DEBUG) {
        return true; // Suppress error output
    }
    
    return false; // Let PHP handle it normally in development
}

/**
 * Custom exception handler for uncaught exceptions
 */
function developer_portfolio_exception_handler($exception) {
    $error_message = sprintf(
        "Theme Exception: %s in %s on line %d\nStack trace:\n%s",
        $exception->getMessage(),
        basename($exception->getFile()),
        $exception->getLine(),
        $exception->getTraceAsString()
    );
    error_log($error_message);
    
    // In production, show a user-friendly error page
    if (!defined('WP_DEBUG') || !WP_DEBUG) {
        if (!headers_sent()) {
            http_response_code(500);
        }
        echo developer_portfolio_get_error_page();
        exit;
    }
}

/**
 * Get a user-friendly error page HTML
 */
function developer_portfolio_get_error_page() {
    return '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Something went wrong - balakumar.dev</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: #0a192f;
            color: #ccd6f6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .error-container {
            text-align: center;
            padding: 2rem;
            max-width: 500px;
        }
        .error-icon { color: #ff6b6b; margin-bottom: 1rem; }
        h1 { color: #e6f1ff; margin-bottom: 0.5rem; }
        p { color: #8892b0; margin-bottom: 1.5rem; }
        a {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: #64ffda;
            color: #0a192f;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 500;
        }
        a:hover { background: #50e6c2; }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
        </div>
        <h1>Something went wrong</h1>
        <p>We encountered an unexpected error. Please try refreshing the page or come back later.</p>
        <a href="/">Return to Homepage</a>
    </div>
</body>
</html>';
}

/**
 * Initialize error handling on theme setup
 * Only set handlers if not in admin and not doing AJAX
 */
function developer_portfolio_init_error_handling() {
    if (!is_admin() && !wp_doing_ajax()) {
        // Only set custom handler in production
        if (!defined('WP_DEBUG') || !WP_DEBUG) {
            set_error_handler('developer_portfolio_error_handler', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
            set_exception_handler('developer_portfolio_exception_handler');
        }
    }
}
add_action('template_redirect', 'developer_portfolio_init_error_handling', 1);

/**
 * Safe wrapper for potentially failing functions
 * 
 * @param callable $callback The function to call
 * @param mixed $default Default value to return on failure
 * @return mixed The result or default value
 */
function developer_portfolio_safe($callback, $default = '') {
    try {
        return call_user_func($callback);
    } catch (Exception $e) {
        error_log('Theme safe call error: ' . $e->getMessage());
        return $default;
    } catch (Error $e) {
        error_log('Theme safe call error: ' . $e->getMessage());
        return $default;
    }
}

/**
 * Safe content filter to catch any content rendering issues
 */
function developer_portfolio_safe_content_filter($content) {
    // Return empty string if content is invalid
    if (!is_string($content)) {
        return '';
    }
    return $content;
}
add_filter('the_content', 'developer_portfolio_safe_content_filter', 1);

/**
 * Add a heartbeat check for JavaScript errors
 */
function developer_portfolio_add_error_reporting_js() {
    if (is_singular()) {
        ?>
        <script>
        window.devPortfolioErrorLog = [];
        window.addEventListener('error', function(e) {
            window.devPortfolioErrorLog.push({
                message: e.message,
                filename: e.filename,
                lineno: e.lineno,
                timestamp: new Date().toISOString()
            });
            console.warn('[Theme] JavaScript error logged:', e.message);
        });
        </script>
        <?php
    }
}
add_action('wp_head', 'developer_portfolio_add_error_reporting_js', 1);

/**
 * One-time project seeder trigger
 * Remove this after projects are seeded
 */
add_action('init', function() {
    if (get_option('developer_portfolio_projects_seeded') !== 'yes') {
        $seeder_file = get_template_directory() . '/seed-projects.php';
        if (file_exists($seeder_file)) {
            require_once $seeder_file;
            if (function_exists('developer_portfolio_seed_projects')) {
                developer_portfolio_seed_projects();
                update_option('developer_portfolio_projects_seeded', 'yes');
            }
        }
    }
}, 99);
