<?php
/**
 * Featured Panel Class
 *
 * Handles the floating panel that displays featured projects and posts.
 *
 * @package Developer_Portfolio
 * @since 1.1.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class Developer_Portfolio_Featured_Panel
 */
class Developer_Portfolio_Featured_Panel {

    /**
     * Panel options
     *
     * @var array
     */
    private $options;

    /**
     * Default options
     *
     * @var array
     */
    private $defaults = array(
        'enabled'           => true,
        'position'          => 'right',
        'projects_count'    => 3,
        'posts_count'       => 3,
        'projects_heading'  => 'Featured Projects',
        'posts_heading'     => 'Featured Posts',
        'collapsed_default' => false,
        'hide_on_mobile'    => true,
    );

    /**
     * Constructor
     */
    public function __construct() {
        $this->options = $this->get_options();
    }

    /**
     * Get panel options with defaults
     *
     * @return array
     */
    public function get_options() {
        $saved = get_option('developer_portfolio_featured_panel', array());
        return wp_parse_args($saved, $this->defaults);
    }

    /**
     * Check if panel should display on current page
     *
     * @return bool
     */
    public function should_display() {
        // Check if enabled
        if (!$this->options['enabled']) {
            return false;
        }

        // Don't show on 404
        if (is_404()) {
            return false;
        }

        // Don't show in admin
        if (is_admin()) {
            return false;
        }

        // Check if we have any content to show
        $projects = $this->get_featured_projects();
        $posts = $this->get_featured_posts();

        if (!$projects->have_posts() && !$posts->have_posts()) {
            return false;
        }

        return true;
    }

    /**
     * Get featured projects
     *
     * @return WP_Query
     */
    public function get_featured_projects() {
        return new WP_Query(array(
            'post_type'      => 'project',
            'posts_per_page' => intval($this->options['projects_count']),
            'post_status'    => 'publish',
            'meta_query'     => array(
                array(
                    'key'   => '_project_featured',
                    'value' => '1',
                ),
            ),
            'orderby'        => 'meta_value_num',
            'meta_key'       => '_project_sort_order',
            'order'          => 'ASC',
        ));
    }

    /**
     * Get featured posts
     *
     * @return WP_Query
     */
    public function get_featured_posts() {
        return new WP_Query(array(
            'post_type'      => 'post',
            'posts_per_page' => intval($this->options['posts_count']),
            'post_status'    => 'publish',
            'meta_query'     => array(
                array(
                    'key'   => '_post_featured',
                    'value' => '1',
                ),
            ),
            'orderby'        => 'date',
            'order'          => 'DESC',
        ));
    }

    /**
     * Get option value
     *
     * @param string $key Option key.
     * @return mixed
     */
    public function get_option($key) {
        return isset($this->options[$key]) ? $this->options[$key] : null;
    }

    /**
     * Render the panel
     */
    public function render() {
        if (!$this->should_display()) {
            return;
        }

        $template = get_template_directory() . '/template-parts/featured-panel.php';
        if (file_exists($template)) {
            include $template;
        }
    }
}
