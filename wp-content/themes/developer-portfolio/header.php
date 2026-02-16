<?php
/**
 * Header Template
 *
 * @package Developer_Portfolio
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo("charset"); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <!-- Preconnect for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary">
        <?php esc_html_e("Skip to content", "developer-portfolio"); ?>
    </a>

    <header id="masthead" class="site-header">
        <div class="header-container">
            <div class="site-branding">
                <a href="<?php echo esc_url(home_url("/")); ?>" class="site-logo-link" aria-label="<?php bloginfo("name"); ?>">
                    <svg class="site-logo-svg" viewBox="0 0 56 40" xmlns="http://www.w3.org/2000/svg">
                        <g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <!-- Opening bracket < -->
                            <polyline points="8,12 2,20 8,28"/>
                            <!-- Letter B -->
                            <path d="M16,12 L16,28"/>
                            <path d="M16,12 L24,12 C27,12 28,14 28,16 C28,18 27,20 24,20 L16,20"/>
                            <path d="M16,20 L25,20 C28,20 29,22 29,24 C29,26 28,28 25,28 L16,28"/>
                            <!-- Forward slash / -->
                            <line x1="33" y1="28" x2="39" y2="12"/>
                            <!-- Closing bracket > -->
                            <polyline points="46,12 54,20 46,28"/>
                        </g>
                    </svg>
                </a>
            </div>

            <nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e("Primary Menu", "developer-portfolio"); ?>">
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <span class="hamburger">
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                    </span>
                    <span class="screen-reader-text"><?php esc_html_e("Menu", "developer-portfolio"); ?></span>
                </button>
                
                <?php
                wp_nav_menu(array(
                    "theme_location" => "primary",
                    "menu_id"        => "primary-menu",
                    "menu_class"     => "primary-menu",
                    "container"      => false,
                    "fallback_cb"    => "developer_portfolio_fallback_menu",
                ));
                ?>
            </nav>

            <div class="header-actions">
                <button class="search-toggle" aria-label="<?php esc_attr_e("Search", "developer-portfolio"); ?>">
                    <svg class="icon-search" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="M21 21l-4.35-4.35"></path>
                    </svg>
                </button>
                
                <a href="https://github.com/balakumardev" target="_blank" rel="noopener noreferrer" class="header-github" aria-label="GitHub">
                    <svg class="icon-github" width="22" height="22" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Search Overlay -->
        <div class="search-overlay" aria-hidden="true">
            <div class="search-overlay-content">
                <button class="search-close" aria-label="<?php esc_attr_e("Close search", "developer-portfolio"); ?>">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
                <?php get_search_form(); ?>
            </div>
        </div>
    </header>

    <?php
    // Announcement bar — pinned below the header
    if (isset($GLOBALS['developer_portfolio_announcement_bar'])) {
        $GLOBALS['developer_portfolio_announcement_bar']->render();
    }

    // Show tag navigation on blog listing, category/tag archives, single blog posts, and search results
    // Note: is_home() && !is_front_page() = blog listing when static front page is set
    // is_category() || is_tag() = category and tag archives only (not project archives)
    // is_single() && get_post_type() === 'post' = only blog posts, not custom post types
    if ((is_home() && !is_front_page()) || is_page('blog') || is_category() || is_tag() || (is_single() && get_post_type() === 'post') || is_search()) {
        developer_portfolio_render_tag_nav();
    }
    ?>

    <div id="content" class="site-content">
<?php

/**
 * Fallback menu if no menu is assigned
 */
function developer_portfolio_fallback_menu() {
    echo "<ul id=\"primary-menu\" class=\"primary-menu\">";
    echo "<li class=\"menu-item\"><a href=\"" . esc_url(home_url("/")) . "\">Home</a></li>";
    echo "<li class=\"menu-item\"><a href=\"" . esc_url(home_url("/projects/")) . "\">Projects</a></li>";
    echo "<li class=\"menu-item\"><a href=\"" . esc_url(home_url("/blog/")) . "\">Blog</a></li>";
    echo "<li class=\"menu-item\"><a href=\"" . esc_url(home_url("/about")) . "\">About</a></li>";
    echo "</ul>";
}
