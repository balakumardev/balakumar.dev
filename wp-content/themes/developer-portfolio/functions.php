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
