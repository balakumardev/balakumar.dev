<?php
/**
 * Footer Template
 *
 * @package Developer_Portfolio
 */
?>
    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="footer-container">
            <div class="footer-grid">
                <!-- About Section -->
                <div class="footer-section footer-about">
                    <h4 class="footer-heading">
                        <span class="bracket">{</span> About <span class="bracket">}</span>
                    </h4>
                    <p class="footer-description">
                        Senior Software Engineer at Intuit, passionate about building scalable distributed systems, 
                        AI-powered tools, and sharing knowledge through technical writing.
                    </p>
                </div>

                <!-- Quick Links -->
                <div class="footer-section footer-links">
                    <h4 class="footer-heading">
                        <span class="bracket">{</span> Links <span class="bracket">}</span>
                    </h4>
                    <nav class="footer-nav">
                        <?php
                        wp_nav_menu(array(
                            "theme_location" => "footer",
                            "menu_class"     => "footer-menu",
                            "container"      => false,
                            "depth"          => 1,
                            "fallback_cb"    => "developer_portfolio_footer_fallback",
                        ));
                        ?>
                    </nav>
                </div>

                <!-- Categories -->
                <div class="footer-section footer-categories">
                    <h4 class="footer-heading">
                        <span class="bracket">{</span> Categories <span class="bracket">}</span>
                    </h4>
                    <ul class="footer-category-list">
                        <?php
                        $categories = get_categories(array(
                            "orderby"    => "count",
                            "order"      => "DESC",
                            "hide_empty" => true,
                            "number"     => 5,
                        ));
                        
                        foreach ($categories as $category) :
                        ?>
                            <li>
                                <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                                    <span class="cat-arrow">-&gt;</span>
                                    <?php echo esc_html($category->name); ?>
                                    <span class="cat-count">(<?php echo esc_html($category->count); ?>)</span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Connect -->
                <div class="footer-section footer-connect">
                    <h4 class="footer-heading">
                        <span class="bracket">{</span> Connect <span class="bracket">}</span>
                    </h4>
                    <div class="footer-social">
                        <?php
                        $social_links = developer_portfolio_get_social_links();
                        foreach ($social_links as $social) :
                        ?>
                            <a href="<?php echo esc_url($social["url"]); ?>" 
                               class="social-link social-<?php echo esc_attr($social["icon"]); ?>"
                               target="_blank" 
                               rel="noopener noreferrer"
                               aria-label="<?php echo esc_attr($social["name"]); ?>">
                                <?php echo developer_portfolio_get_social_icon($social["icon"]); ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="footer-copyright">
                    <span class="code-comment">// &copy; <?php echo date("Y"); ?></span>
                    <a href="<?php echo esc_url(home_url("/")); ?>" class="footer-site-name">
                        <?php bloginfo("name"); ?>
                    </a>
                    <span class="code-comment">// All rights reserved</span>
                </div>
                
                <div class="footer-meta">
                    <span class="built-with">
                        Built with <span class="heart">&#x2764;</span> and WordPress
                    </span>
                </div>
            </div>
        </div>

        <!-- Animated background particles -->
        <div class="footer-particles" aria-hidden="true">
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
        </div>
    </footer>
</div><!-- #page -->

<?php
// Render Featured Panel
if (isset($GLOBALS['developer_portfolio_featured_panel'])) {
    $GLOBALS['developer_portfolio_featured_panel']->render();
}
?>

<?php wp_footer(); ?>

</body>
</html>
