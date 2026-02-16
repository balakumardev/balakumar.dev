<?php
/**
 * Announcement Bar Class
 *
 * Displays a thin banner at the top of every page rotating through
 * the newest featured projects and blog posts.
 *
 * @package Developer_Portfolio
 * @since 1.2.0
 */

if (!defined('ABSPATH')) {
    exit;
}

class Developer_Portfolio_Announcement_Bar {

    /**
     * Cached featured items
     *
     * @var array|false False means not yet fetched
     */
    private $items = false;

    /**
     * Get the newest featured projects and posts, sorted by date
     *
     * @return array Array of WP_Post objects
     */
    public function get_items() {
        if ($this->items !== false) {
            return $this->items;
        }

        $all = array();

        // Get featured projects
        $project_query = new WP_Query(array(
            'post_type'      => 'project',
            'posts_per_page' => 3,
            'post_status'    => 'publish',
            'meta_query'     => array(
                array(
                    'key'   => '_project_featured',
                    'value' => '1',
                ),
            ),
            'orderby' => 'date',
            'order'   => 'DESC',
        ));

        if ($project_query->have_posts()) {
            $all = array_merge($all, $project_query->posts);
        }

        // Get featured blog posts
        $post_query = new WP_Query(array(
            'post_type'      => 'post',
            'posts_per_page' => 3,
            'post_status'    => 'publish',
            'meta_query'     => array(
                array(
                    'key'   => '_post_featured',
                    'value' => '1',
                ),
            ),
            'orderby' => 'date',
            'order'   => 'DESC',
        ));

        if ($post_query->have_posts()) {
            $all = array_merge($all, $post_query->posts);
        }

        wp_reset_postdata();

        // Sort by date descending and take top 3
        usort($all, function($a, $b) {
            return strtotime($b->post_date) - strtotime($a->post_date);
        });

        $this->items = array_slice($all, 0, 3);

        return $this->items;
    }

    /**
     * Check if the announcement bar should display
     *
     * @return bool
     */
    public function should_display() {
        if (is_admin() || is_404()) {
            return false;
        }

        return count($this->get_items()) > 0;
    }

    /**
     * Get the item type label
     *
     * @param WP_Post $item
     * @return string
     */
    public function get_item_type($item) {
        return $item->post_type === 'project' ? 'Project' : 'Post';
    }

    /**
     * Render the announcement bar
     */
    public function render() {
        if (!$this->should_display()) {
            return;
        }

        $template = get_template_directory() . '/template-parts/announcement-bar.php';
        if (file_exists($template)) {
            include $template;
        }
    }
}
