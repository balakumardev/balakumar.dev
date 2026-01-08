<?php
/**
 * Front Page Template
 *
 * @package Developer_Portfolio
 */

get_header();
?>

<main id="primary" class="site-main front-page-main">
    
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-background">
            <div class="hero-gradient"></div>
            <div class="hero-grid"></div>
            <div class="hero-particles">
                <?php for ($i = 0; $i < 20; $i++) : ?>
                    <div class="particle" style="--delay: <?php echo $i * 0.5; ?>s; --x: <?php echo rand(0, 100); ?>%; --y: <?php echo rand(0, 100); ?>%;"></div>
                <?php endfor; ?>
            </div>
        </div>
        
        <div class="hero-container">
            <div class="hero-content">
                <div class="terminal-window animate-on-scroll">
                    <div class="terminal-header">
                        <span class="terminal-dot red"></span>
                        <span class="terminal-dot yellow"></span>
                        <span class="terminal-dot green"></span>
                        <span class="terminal-title">~/balakumar.dev</span>
                    </div>
                    <div class="terminal-body">
                        <div class="terminal-line">
                            <span class="terminal-prompt">$</span>
                            <span class="terminal-command typing-animation">whoami</span>
                        </div>
                        <div class="terminal-output">
                            <h1 class="hero-name">
                                <span class="name-first">Bala</span> <span class="name-last">Kumar</span>
                            </h1>
                        </div>
                        <div class="terminal-line">
                            <span class="terminal-prompt">$</span>
                            <span class="terminal-command">cat role.txt</span>
                        </div>
                        <div class="terminal-output">
                            <p class="hero-title">Senior Software Engineer @ <span class="highlight-intuit">Intuit</span></p>
                        </div>
                        <div class="terminal-line">
                            <span class="terminal-prompt">$</span>
                            <span class="terminal-command">cat about.txt</span>
                        </div>
                        <div class="terminal-output">
                            <p class="hero-tagline">
                                Building scalable distributed systems by day,<br>
                                exploring AI and sharing knowledge by night.
                            </p>
                        </div>
                        <div class="terminal-line">
                            <span class="terminal-prompt">$</span>
                            <span class="terminal-cursor">_</span>
                        </div>
                    </div>
                </div>
                
                <div class="hero-cta animate-on-scroll" style="--delay: 0.5s;">
                    <a href="#latest-posts" class="cta-button primary">
                        <span class="cta-icon">&#x2192;</span>
                        Read Latest Posts
                    </a>
                    <a href="#projects" class="cta-button secondary">
                        <span class="cta-icon">&#x2605;</span>
                        View Projects
                    </a>
                </div>
                
                <div class="hero-stats animate-on-scroll" style="--delay: 0.7s;">
                    <?php
                    $post_count = wp_count_posts()->publish;
                    $categories_count = wp_count_terms("category");
                    ?>
                    <div class="stat-item">
                        <span class="stat-value"><?php echo $post_count; ?></span>
                        <span class="stat-label">Articles</span>
                    </div>
                    <div class="stat-divider">//</div>
                    <div class="stat-item">
                        <span class="stat-value"><?php echo $categories_count; ?></span>
                        <span class="stat-label">Topics</span>
                    </div>
                    <div class="stat-divider">//</div>
                    <div class="stat-item">
                        <span class="stat-value">10+</span>
                        <span class="stat-label">Years XP</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="scroll-indicator">
            <span class="scroll-text">Scroll to explore</span>
            <div class="scroll-arrow">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 5v14M5 12l7 7 7-7"/>
                </svg>
            </div>
        </div>
    </section>

    <!-- Latest Posts Section -->
    <section id="latest-posts" class="section latest-posts-section">
        <div class="section-container">
            <header class="section-header animate-on-scroll">
                <span class="section-tag">// Recent Articles</span>
                <h2 class="section-title">
                    <span class="title-bracket">{</span>
                    Latest Posts
                    <span class="title-bracket">}</span>
                </h2>
                <p class="section-subtitle">Deep dives into distributed systems, AI, and software engineering</p>
            </header>
            
            <div class="posts-grid">
                <?php
                $latest_posts = new WP_Query(array(
                    "posts_per_page" => 6,
                    "post_status"    => "publish",
                ));
                
                if ($latest_posts->have_posts()) :
                    $post_index = 0;
                    while ($latest_posts->have_posts()) : $latest_posts->the_post();
                        $categories = get_the_category();
                        $primary_cat = !empty($categories) ? $categories[0] : null;
                        $gradient_class = $primary_cat ? developer_portfolio_get_category_gradient($primary_cat->slug) : "gradient-default";
                        $reading_time = developer_portfolio_reading_time();
                ?>
                    <article class="post-card animate-on-scroll <?php echo $gradient_class; ?>" style="--delay: <?php echo $post_index * 0.1; ?>s;">
                        <div class="post-card-inner">
                            <div class="post-card-header">
                                <?php if ($primary_cat) : ?>
                                    <a href="<?php echo esc_url(get_category_link($primary_cat->term_id)); ?>" class="post-category">
                                        <span class="category-icon">&#x25B6;</span>
                                        <?php echo esc_html($primary_cat->name); ?>
                                    </a>
                                <?php endif; ?>
                                <span class="post-reading-time"><?php echo $reading_time; ?> min read</span>
                            </div>
                            
                            <h3 class="post-card-title">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h3>
                            
                            <p class="post-card-excerpt">
                                <?php echo wp_trim_words(get_the_excerpt(), 20, "..."); ?>
                            </p>
                            
                            <footer class="post-card-footer">
                                <time class="post-date" datetime="<?php echo get_the_date("c"); ?>">
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
                    <div class="no-posts-message">
                        <p>No posts yet. Check back soon!</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="section-footer animate-on-scroll">
                <a href="<?php echo esc_url(developer_portfolio_get_blog_url()); ?>" class="view-all-link">
                    View all articles <span class="arrow">&#x2192;</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <section id="projects" class="section projects-section">
        <div class="section-container">
            <header class="section-header animate-on-scroll">
                <span class="section-tag">// Open Source</span>
                <h2 class="section-title">
                    <span class="title-bracket">{</span>
                    Projects
                    <span class="title-bracket">}</span>
                </h2>
                <p class="section-subtitle">Tools and libraries I have built for the developer community</p>
            </header>
            
            <div class="projects-grid">
                <?php
                $projects = developer_portfolio_get_projects();
                $project_index = 0;
                foreach ($projects as $project) :
                ?>
                    <article class="project-card animate-on-scroll" style="--delay: <?php echo $project_index * 0.1; ?>s;">
                        <div class="project-card-inner">
                            <div class="project-icon">
                                <?php echo developer_portfolio_get_project_icon($project["icon"]); ?>
                            </div>
                            
                            <h3 class="project-title"><?php echo esc_html($project["title"]); ?></h3>
                            
                            <p class="project-description"><?php echo esc_html($project["description"]); ?></p>
                            
                            <div class="project-tech">
                                <?php foreach ($project["tech"] as $tech) : ?>
                                    <span class="tech-tag"><?php echo esc_html($tech); ?></span>
                                <?php endforeach; ?>
                            </div>
                            
                            <a href="<?php echo esc_url($project["github"]); ?>" 
                               class="project-link" 
                               target="_blank" 
                               rel="noopener noreferrer">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                </svg>
                                View on GitHub
                            </a>
                        </div>
                        <div class="project-card-glow"></div>
                    </article>
                <?php
                    $project_index++;
                endforeach;
                ?>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section id="categories" class="section categories-section">
        <div class="section-container">
            <header class="section-header animate-on-scroll">
                <span class="section-tag">// Explore Topics</span>
                <h2 class="section-title">
                    <span class="title-bracket">{</span>
                    Categories
                    <span class="title-bracket">}</span>
                </h2>
                <p class="section-subtitle">Browse articles by topic</p>
            </header>
            
            <div class="categories-grid">
                <?php
                $categories = get_categories(array(
                    "orderby"    => "count",
                    "order"      => "DESC",
                    "hide_empty" => false,
                    "number"     => 8,
                    "exclude"    => get_cat_ID("Uncategorized"),
                ));
                
                $cat_index = 0;
                foreach ($categories as $category) :
                    $icon = developer_portfolio_get_category_icon($category->slug);
                    $gradient = developer_portfolio_get_category_gradient($category->slug);
                ?>
                    <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" 
                       class="category-card animate-on-scroll <?php echo $gradient; ?>"
                       style="--delay: <?php echo $cat_index * 0.1; ?>s;">
                        <div class="category-icon">
                            <?php echo developer_portfolio_get_category_icon_svg($icon); ?>
                        </div>
                        <h3 class="category-name"><?php echo esc_html($category->name); ?></h3>
                        <span class="category-count"><?php echo $category->count; ?> articles</span>
                        <div class="category-arrow">&#x2192;</div>
                    </a>
                <?php
                    $cat_index++;
                endforeach;
                ?>
            </div>
        </div>
    </section>

    <!-- Connect Section -->
    <section id="connect" class="section connect-section">
        <div class="section-container">
            <div class="connect-content animate-on-scroll">
                <header class="section-header">
                    <span class="section-tag">// Get in Touch</span>
                    <h2 class="section-title">
                        <span class="title-bracket">{</span>
                        Let us Connect
                        <span class="title-bracket">}</span>
                    </h2>
                    <p class="section-subtitle">
                        Interested in collaborating, discussing tech, or just saying hi?
                    </p>
                </header>
                
                <div class="connect-links">
                    <?php
                    $social_links = developer_portfolio_get_social_links();
                    foreach ($social_links as $index => $social) :
                    ?>
                        <a href="<?php echo esc_url($social["url"]); ?>" 
                           class="connect-link animate-on-scroll"
                           style="--delay: <?php echo $index * 0.1; ?>s;"
                           target="_blank" 
                           rel="noopener noreferrer">
                            <div class="connect-link-icon">
                                <?php echo developer_portfolio_get_social_icon($social["icon"]); ?>
                            </div>
                            <span class="connect-link-name"><?php echo esc_html($social["name"]); ?></span>
                            <span class="connect-link-arrow">&#x2192;</span>
                        </a>
                    <?php endforeach; ?>
                </div>
                
                <div class="connect-email animate-on-scroll" style="--delay: 0.5s;">
                    <p class="email-label">Or drop me an email at</p>
                    <a href="mailto:hello@balakumar.dev" class="email-link">
                        hello@balakumar.dev
                    </a>
                </div>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();

/**
 * Get project icon SVG
 */
function developer_portfolio_get_project_icon($icon) {
    $icons = array(
        "brain" => "<svg width=\"32\" height=\"32\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.5\"><path d=\"M9.5 2A2.5 2.5 0 0 1 12 4.5v15a2.5 2.5 0 0 1-4.96.44 2.5 2.5 0 0 1-2.96-3.08 3 3 0 0 1-.34-5.58 2.5 2.5 0 0 1 1.32-4.24 2.5 2.5 0 0 1 4.44-1.54\"/><path d=\"M14.5 2A2.5 2.5 0 0 0 12 4.5v15a2.5 2.5 0 0 0 4.96.44 2.5 2.5 0 0 0 2.96-3.08 3 3 0 0 0 .34-5.58 2.5 2.5 0 0 0-1.32-4.24 2.5 2.5 0 0 0-4.44-1.54\"/></svg>",
        "hammer" => "<svg width=\"32\" height=\"32\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.5\"><path d=\"m15 12-8.5 8.5c-.83.83-2.17.83-3 0 0 0 0 0 0 0a2.12 2.12 0 0 1 0-3L12 9\"/><path d=\"M17.64 15 22 10.64\"/><path d=\"m20.91 11.7-1.25-1.25c-.6-.6-.93-1.4-.93-2.25v-.86L16.01 4.6a5.56 5.56 0 0 0-3.94-1.64H9l.92.82A6.18 6.18 0 0 1 12 8.4v1.56l2 2h2.47l2.26 1.91\"/></svg>",
        "compass" => "<svg width=\"32\" height=\"32\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.5\"><circle cx=\"12\" cy=\"12\" r=\"10\"/><polygon points=\"16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76\"/></svg>",
        "database" => "<svg width=\"32\" height=\"32\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.5\"><ellipse cx=\"12\" cy=\"5\" rx=\"9\" ry=\"3\"/><path d=\"M3 5V19A9 3 0 0 0 21 19V5\"/><path d=\"M3 12A9 3 0 0 0 21 12\"/></svg>",
        "network-wired" => "<svg width=\"32\" height=\"32\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.5\"><rect x=\"9\" y=\"2\" width=\"6\" height=\"6\" rx=\"1\"/><rect x=\"2\" y=\"16\" width=\"6\" height=\"6\" rx=\"1\"/><rect x=\"16\" y=\"16\" width=\"6\" height=\"6\" rx=\"1\"/><path d=\"M5 16v-3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3\"/><path d=\"M12 12V8\"/></svg>",
        "chart-line" => "<svg width=\"32\" height=\"32\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.5\"><path d=\"M3 3v18h18\"/><path d=\"m19 9-5 5-4-4-3 3\"/></svg>",
    );
    
    return isset($icons[$icon]) ? $icons[$icon] : $icons["database"];
}

/**
 * Get category icon SVG
 */
function developer_portfolio_get_category_icon_svg($icon) {
    $icons = array(
        "brain" => "<svg width=\"28\" height=\"28\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.5\"><path d=\"M9.5 2A2.5 2.5 0 0 1 12 4.5v15a2.5 2.5 0 0 1-4.96.44 2.5 2.5 0 0 1-2.96-3.08 3 3 0 0 1-.34-5.58 2.5 2.5 0 0 1 1.32-4.24 2.5 2.5 0 0 1 4.44-1.54\"/><path d=\"M14.5 2A2.5 2.5 0 0 0 12 4.5v15a2.5 2.5 0 0 0 4.96.44 2.5 2.5 0 0 0 2.96-3.08 3 3 0 0 0 .34-5.58 2.5 2.5 0 0 0-1.32-4.24 2.5 2.5 0 0 0-4.44-1.54\"/></svg>",
        "server" => "<svg width=\"28\" height=\"28\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.5\"><rect x=\"2\" y=\"2\" width=\"20\" height=\"8\" rx=\"2\" ry=\"2\"/><rect x=\"2\" y=\"14\" width=\"20\" height=\"8\" rx=\"2\" ry=\"2\"/><line x1=\"6\" y1=\"6\" x2=\"6.01\" y2=\"6\"/><line x1=\"6\" y1=\"18\" x2=\"6.01\" y2=\"18\"/></svg>",
        "graduation-cap" => "<svg width=\"28\" height=\"28\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.5\"><path d=\"M22 10v6M2 10l10-5 10 5-10 5z\"/><path d=\"M6 12v5c3 3 9 3 12 0v-5\"/></svg>",
        "code" => "<svg width=\"28\" height=\"28\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.5\"><polyline points=\"16 18 22 12 16 6\"/><polyline points=\"8 6 2 12 8 18\"/></svg>",
        "folder" => "<svg width=\"28\" height=\"28\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.5\"><path d=\"M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z\"/></svg>",
        "file-alt" => "<svg width=\"28\" height=\"28\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.5\"><path d=\"M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z\"/><polyline points=\"14 2 14 8 20 8\"/><line x1=\"16\" y1=\"13\" x2=\"8\" y2=\"13\"/><line x1=\"16\" y1=\"17\" x2=\"8\" y2=\"17\"/></svg>",
        "sitemap" => "<svg width=\"28\" height=\"28\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.5\"><rect x=\"9\" y=\"2\" width=\"6\" height=\"6\" rx=\"1\"/><rect x=\"2\" y=\"16\" width=\"6\" height=\"6\" rx=\"1\"/><rect x=\"9\" y=\"16\" width=\"6\" height=\"6\" rx=\"1\"/><rect x=\"16\" y=\"16\" width=\"6\" height=\"6\" rx=\"1\"/><path d=\"M5 16v-3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3M12 8v4\"/></svg>",
        "cloud" => "<svg width=\"28\" height=\"28\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.5\"><path d=\"M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z\"/></svg>",
    );
    
    return isset($icons[$icon]) ? $icons[$icon] : $icons["file-alt"];
}
