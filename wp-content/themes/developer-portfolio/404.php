<?php
/**
 * 404 Template
 *
 * @package Developer_Portfolio
 */

get_header();
?>

<main id="primary" class="site-main error-main">
    <div class="error-container">
        <div class="error-content animate-on-scroll">
            <div class="error-terminal">
                <div class="terminal-header">
                    <span class="terminal-dot red"></span>
                    <span class="terminal-dot yellow"></span>
                    <span class="terminal-dot green"></span>
                    <span class="terminal-title">~/error</span>
                </div>
                <div class="terminal-body">
                    <div class="terminal-line">
                        <span class="terminal-prompt">$</span>
                        <span class="terminal-command">find page</span>
                    </div>
                    <div class="terminal-output error-output">
                        <span class="error-code">Error 404:</span> Page not found
                    </div>
                    <div class="terminal-line">
                        <span class="terminal-prompt">$</span>
                        <span class="terminal-cursor">_</span>
                    </div>
                </div>
            </div>
            
            <h1 class="error-title">
                <span class="glitch" data-text="404">404</span>
            </h1>
            
            <p class="error-message">
                Looks like this page took a wrong turn in the codebase.
            </p>
            
            <div class="error-suggestions">
                <p class="suggestions-label">Try one of these instead:</p>
                <div class="error-links">
                    <a href="<?php echo esc_url(home_url("/")); ?>" class="error-link">
                        <span class="link-icon">&#x2302;</span>
                        Home
                    </a>
                    <a href="<?php echo esc_url(get_permalink(get_option("page_for_posts"))); ?>" class="error-link">
                        <span class="link-icon">&#x270E;</span>
                        Blog
                    </a>
                    <a href="<?php echo esc_url(home_url("/#projects")); ?>" class="error-link">
                        <span class="link-icon">&#x2605;</span>
                        Projects
                    </a>
                </div>
            </div>
            
            <div class="error-search">
                <p class="search-label">Or search for what you need:</p>
                <?php get_search_form(); ?>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
