<?php
/**
 * Balakumar Dark Theme Functions
 */

// Theme Setup
function balakumar_dark_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ));
    add_theme_support('automatic-feed-links');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'balakumar-dark'),
        'footer'  => __('Footer Menu', 'balakumar-dark'),
    ));
}
add_action('after_setup_theme', 'balakumar_dark_setup');

// Enqueue Scripts and Styles
function balakumar_dark_scripts() {
    // Google Fonts
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap',
        array(),
        null
    );

    // Theme stylesheet
    wp_enqueue_style(
        'balakumar-dark-style',
        get_stylesheet_uri(),
        array('google-fonts'),
        time()
    );

    // Theme JavaScript
    wp_enqueue_script(
        'balakumar-dark-script',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        time(),
        true
    );
}
add_action('wp_enqueue_scripts', 'balakumar_dark_scripts');

// Custom excerpt length
function balakumar_dark_excerpt_length($length) {
    return 25;
}
add_filter('excerpt_length', 'balakumar_dark_excerpt_length');

// Custom excerpt more
function balakumar_dark_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'balakumar_dark_excerpt_more');

// Add custom body classes
function balakumar_dark_body_classes($classes) {
    if (is_front_page()) {
        $classes[] = 'front-page';
    }
    return $classes;
}
add_filter('body_class', 'balakumar_dark_body_classes');

// Custom walker for navigation (simplified)
function balakumar_dark_nav_menu($args = array()) {
    $defaults = array(
        'theme_location' => 'primary',
        'container'      => false,
        'menu_class'     => 'main-nav',
        'fallback_cb'    => 'balakumar_dark_fallback_menu',
    );
    $args = wp_parse_args($args, $defaults);
    wp_nav_menu($args);
}

// Fallback menu if none set
function balakumar_dark_fallback_menu() {
    echo '<ul class="main-nav">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">Home</a></li>';
    echo '<li><a href="' . esc_url(home_url('/#experience')) . '">Experience</a></li>';
    echo '<li><a href="' . esc_url(home_url('/#portfolio')) . '">Portfolio</a></li>';
    echo '<li><a href="' . esc_url(home_url('/blog')) . '">Blog</a></li>';
    echo '<li><a href="' . esc_url(home_url('/#contact')) . '">Contact</a></li>';
    echo '</ul>';
}

// Register widget areas
function balakumar_dark_widgets_init() {
    register_sidebar(array(
        'name'          => __('Footer Widget', 'balakumar-dark'),
        'id'            => 'footer-widget',
        'description'   => __('Add widgets here.', 'balakumar-dark'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'balakumar_dark_widgets_init');

// Experience data
function balakumar_dark_get_experience() {
    return array(
        array(
            'company' => 'Intuit',
            'logo' => 'I',
            'role' => 'Senior Software Engineer',
            'description' => 'Developed advanced e-commerce platform with shopping cart consolidation. Built B2B and B2C cart integration with persistent cart features and multi-model charge handling.',
            'tech' => array('Spring Boot', 'GraphQL', 'Netflix DGS', 'ArgoCD', 'Java 11', 'Redis', 'Kubernetes', 'AWS', 'DynamoDB'),
        ),
        array(
            'company' => 'Amazon',
            'logo' => 'A',
            'role' => 'Software Development Engineer',
            'description' => 'Developed speech middleware stack for Alexa including AVS SDK, core speech functionality, and capability agents. Deployed to millions of devices worldwide.',
            'tech' => array('C++', 'AWS', 'Alexa', 'AVS SDK', 'Speech Processing'),
        ),
        array(
            'company' => 'Dell',
            'logo' => 'D',
            'role' => 'Software Development Engineer',
            'description' => 'Developed 52+ cloud-native microservices from scratch. Pioneered an automation framework for microservice refactoring that got patented. Reduced 60% boilerplate with reusable libraries.',
            'tech' => array('Spring Boot', 'Kafka', 'Microservices', 'CometD', 'Salesforce', 'PCF'),
        ),
        array(
            'company' => 'VMware',
            'logo' => 'V',
            'role' => 'Software Engineer',
            'description' => 'Contributed to enterprise virtualization solutions and cloud infrastructure development.',
            'tech' => array('Virtualization', 'Cloud', 'Enterprise Solutions'),
        ),
    );
}

// Portfolio/Projects data
function balakumar_dark_get_projects() {
    return array(
        array(
            'name' => 'BHelper',
            'description' => 'macOS Menu Bar App for AI Text Rewriting. Provides quick access to AI-powered text transformation tools directly from your menu bar.',
            'tech' => array('Swift', 'macOS', 'OpenAI', 'Claude', 'Gemini'),
            'url' => 'https://github.com/balakumardev/bhelper',
        ),
        array(
            'name' => 'AI Agent Design Patterns',
            'description' => 'Production-ready patterns for building robust AI agents. Comprehensive guide covering architecture, error handling, and best practices.',
            'tech' => array('Python', 'LangChain', 'AI/ML', 'Architecture'),
            'url' => 'https://github.com/balakumardev/ai-agent-design-patterns',
        ),
        array(
            'name' => 'Java Code Navigator',
            'description' => 'VSCode Extension for enhanced Java development workflow. Jump to definitions, find references, and navigate large codebases efficiently.',
            'tech' => array('TypeScript', 'VSCode API', 'Java'),
            'url' => 'https://github.com/balakumardev/java-code-navigator',
        ),
        array(
            'name' => 'GhostWriter',
            'description' => 'Android Voice-to-Text app with AI refinement. Convert speech to polished text using advanced speech recognition and AI enhancement.',
            'tech' => array('Kotlin', 'Android', 'Speech Recognition', 'AI'),
            'url' => 'https://github.com/balakumardev/ghostwriter',
        ),
        array(
            'name' => 'Perplexity Web Wrapper',
            'description' => 'MCP Server for seamless AI integration with Perplexity search. Enables AI assistants to leverage web search capabilities.',
            'tech' => array('Python', 'MCP Protocol', 'AI Integration'),
            'url' => 'https://github.com/balakumardev/perplexity-web-wrapper',
        ),
        array(
            'name' => 'BSummarize Firefox',
            'description' => 'Firefox Extension for AI-powered content summaries. Get quick summaries of web pages using Google Gemini.',
            'tech' => array('JavaScript', 'WebExtension', 'Gemini'),
            'url' => 'https://github.com/balakumardev/bsummarize-firefox',
        ),
    );
}

// Profile data
function balakumar_dark_get_profile() {
    return array(
        'name' => 'Bala Kumar',
        'title' => 'Senior Software Engineer',
        'tagline' => 'Building Scalable Distributed Systems',
        'bio' => 'Senior Full-Stack Software Engineer with 5+ years of experience leading the development of secure, efficient, and high-performance distributed systems. Proficient in Spring Framework and microservices architecture across cloud platforms including AWS, Azure, and PCF.',
        'email' => 'hire@balakumar.dev',
        'phone' => '+917073352596',
        'location' => 'Bangalore, India',
    );
}

// Skills data
function balakumar_dark_get_skills() {
    return array(
        'Expert' => array('Java', 'Spring Boot', 'Microservices', 'REST APIs', 'GraphQL'),
        'Advanced' => array('C++', 'React', 'Angular', 'Python', 'Node.js'),
        'DevOps' => array('AWS', 'Kubernetes', 'Docker', 'Kafka', 'Redis', 'MongoDB'),
    );
}
