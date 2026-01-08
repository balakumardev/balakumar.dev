<?php
/**
 * Featured Panel Admin Settings
 *
 * Adds a settings page under Appearance > Featured Panel.
 *
 * @package Developer_Portfolio
 * @since 1.1.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add settings page under Appearance menu
 */
function developer_portfolio_add_featured_panel_page() {
    add_theme_page(
        __('Featured Panel', 'developer-portfolio'),
        __('Featured Panel', 'developer-portfolio'),
        'edit_theme_options',
        'featured-panel-settings',
        'developer_portfolio_featured_panel_page_callback'
    );
}
add_action('admin_menu', 'developer_portfolio_add_featured_panel_page');

/**
 * Register settings
 */
function developer_portfolio_register_featured_panel_settings() {
    register_setting(
        'developer_portfolio_featured_panel_group',
        'developer_portfolio_featured_panel',
        'developer_portfolio_sanitize_featured_panel_options'
    );

    // General Settings Section
    add_settings_section(
        'featured_panel_general',
        __('General Settings', 'developer-portfolio'),
        '__return_null',
        'featured-panel-settings'
    );

    add_settings_field(
        'enabled',
        __('Enable Panel', 'developer-portfolio'),
        'developer_portfolio_render_checkbox_field',
        'featured-panel-settings',
        'featured_panel_general',
        array(
            'field' => 'enabled',
            'label' => __('Show the featured panel on your site', 'developer-portfolio'),
        )
    );

    add_settings_field(
        'position',
        __('Position', 'developer-portfolio'),
        'developer_portfolio_render_select_field',
        'featured-panel-settings',
        'featured_panel_general',
        array(
            'field'   => 'position',
            'options' => array(
                'right' => __('Right side', 'developer-portfolio'),
                'left'  => __('Left side', 'developer-portfolio'),
            ),
        )
    );

    add_settings_field(
        'collapsed_default',
        __('Start Collapsed', 'developer-portfolio'),
        'developer_portfolio_render_checkbox_field',
        'featured-panel-settings',
        'featured_panel_general',
        array(
            'field' => 'collapsed_default',
            'label' => __('Panel starts collapsed (visitors can expand it)', 'developer-portfolio'),
        )
    );

    add_settings_field(
        'hide_on_mobile',
        __('Hide on Mobile', 'developer-portfolio'),
        'developer_portfolio_render_checkbox_field',
        'featured-panel-settings',
        'featured_panel_general',
        array(
            'field' => 'hide_on_mobile',
            'label' => __('Hide the panel on screens smaller than 1024px', 'developer-portfolio'),
        )
    );

    // Content Settings Section
    add_settings_section(
        'featured_panel_content',
        __('Content Settings', 'developer-portfolio'),
        '__return_null',
        'featured-panel-settings'
    );

    add_settings_field(
        'projects_count',
        __('Featured Projects', 'developer-portfolio'),
        'developer_portfolio_render_number_field',
        'featured-panel-settings',
        'featured_panel_content',
        array(
            'field' => 'projects_count',
            'min'   => 1,
            'max'   => 5,
            'desc'  => __('Number of featured projects to show (1-5)', 'developer-portfolio'),
        )
    );

    add_settings_field(
        'projects_heading',
        __('Projects Heading', 'developer-portfolio'),
        'developer_portfolio_render_text_field',
        'featured-panel-settings',
        'featured_panel_content',
        array(
            'field' => 'projects_heading',
        )
    );

    add_settings_field(
        'posts_count',
        __('Featured Posts', 'developer-portfolio'),
        'developer_portfolio_render_number_field',
        'featured-panel-settings',
        'featured_panel_content',
        array(
            'field' => 'posts_count',
            'min'   => 1,
            'max'   => 5,
            'desc'  => __('Number of featured posts to show (1-5)', 'developer-portfolio'),
        )
    );

    add_settings_field(
        'posts_heading',
        __('Posts Heading', 'developer-portfolio'),
        'developer_portfolio_render_text_field',
        'featured-panel-settings',
        'featured_panel_content',
        array(
            'field' => 'posts_heading',
        )
    );
}
add_action('admin_init', 'developer_portfolio_register_featured_panel_settings');

/**
 * Get current option value
 *
 * @param string $field Field name.
 * @return mixed
 */
function developer_portfolio_get_featured_panel_option($field) {
    $defaults = array(
        'enabled'           => true,
        'position'          => 'right',
        'projects_count'    => 3,
        'posts_count'       => 3,
        'projects_heading'  => 'Featured Projects',
        'posts_heading'     => 'Featured Posts',
        'collapsed_default' => false,
        'hide_on_mobile'    => true,
    );
    $options = get_option('developer_portfolio_featured_panel', array());
    $options = wp_parse_args($options, $defaults);
    return isset($options[$field]) ? $options[$field] : '';
}

/**
 * Render checkbox field
 */
function developer_portfolio_render_checkbox_field($args) {
    $value = developer_portfolio_get_featured_panel_option($args['field']);
    ?>
    <label>
        <input type="checkbox"
               name="developer_portfolio_featured_panel[<?php echo esc_attr($args['field']); ?>]"
               value="1"
               <?php checked($value, true); ?>>
        <?php if (isset($args['label'])) echo esc_html($args['label']); ?>
    </label>
    <?php
}

/**
 * Render select field
 */
function developer_portfolio_render_select_field($args) {
    $value = developer_portfolio_get_featured_panel_option($args['field']);
    ?>
    <select name="developer_portfolio_featured_panel[<?php echo esc_attr($args['field']); ?>]">
        <?php foreach ($args['options'] as $key => $label) : ?>
            <option value="<?php echo esc_attr($key); ?>" <?php selected($value, $key); ?>>
                <?php echo esc_html($label); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <?php
}

/**
 * Render number field
 */
function developer_portfolio_render_number_field($args) {
    $value = developer_portfolio_get_featured_panel_option($args['field']);
    ?>
    <input type="number"
           name="developer_portfolio_featured_panel[<?php echo esc_attr($args['field']); ?>]"
           value="<?php echo esc_attr($value); ?>"
           min="<?php echo esc_attr($args['min']); ?>"
           max="<?php echo esc_attr($args['max']); ?>"
           style="width: 60px;">
    <?php if (isset($args['desc'])) : ?>
        <p class="description"><?php echo esc_html($args['desc']); ?></p>
    <?php endif; ?>
    <?php
}

/**
 * Render text field
 */
function developer_portfolio_render_text_field($args) {
    $value = developer_portfolio_get_featured_panel_option($args['field']);
    ?>
    <input type="text"
           name="developer_portfolio_featured_panel[<?php echo esc_attr($args['field']); ?>]"
           value="<?php echo esc_attr($value); ?>"
           class="regular-text">
    <?php
}

/**
 * Sanitize options
 *
 * @param array $input Input values.
 * @return array
 */
function developer_portfolio_sanitize_featured_panel_options($input) {
    $sanitized = array();

    $sanitized['enabled'] = isset($input['enabled']) ? true : false;
    $sanitized['position'] = isset($input['position']) && in_array($input['position'], array('left', 'right'))
        ? $input['position']
        : 'right';
    $sanitized['collapsed_default'] = isset($input['collapsed_default']) ? true : false;
    $sanitized['hide_on_mobile'] = isset($input['hide_on_mobile']) ? true : false;

    $sanitized['projects_count'] = isset($input['projects_count'])
        ? max(1, min(5, intval($input['projects_count'])))
        : 3;
    $sanitized['posts_count'] = isset($input['posts_count'])
        ? max(1, min(5, intval($input['posts_count'])))
        : 3;

    $sanitized['projects_heading'] = isset($input['projects_heading'])
        ? sanitize_text_field($input['projects_heading'])
        : 'Featured Projects';
    $sanitized['posts_heading'] = isset($input['posts_heading'])
        ? sanitize_text_field($input['posts_heading'])
        : 'Featured Posts';

    return $sanitized;
}

/**
 * Settings page callback
 */
function developer_portfolio_featured_panel_page_callback() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

        <form method="post" action="options.php">
            <?php
            settings_fields('developer_portfolio_featured_panel_group');
            do_settings_sections('featured-panel-settings');
            submit_button();
            ?>
        </form>

        <hr>

        <h2><?php _e('Quick Guide', 'developer-portfolio'); ?></h2>
        <p><?php _e('To feature content in the panel:', 'developer-portfolio'); ?></p>
        <ol>
            <li>
                <strong><?php _e('Projects:', 'developer-portfolio'); ?></strong>
                <?php _e('Edit a project and check "Featured Project" in the Project Details box.', 'developer-portfolio'); ?>
            </li>
            <li>
                <strong><?php _e('Posts:', 'developer-portfolio'); ?></strong>
                <?php _e('Edit a post and check "Feature this post" in the sidebar.', 'developer-portfolio'); ?>
            </li>
        </ol>

        <?php
        // Show current featured items
        $panel = new Developer_Portfolio_Featured_Panel();
        $projects = $panel->get_featured_projects();
        $posts = $panel->get_featured_posts();
        ?>

        <h3><?php _e('Currently Featured', 'developer-portfolio'); ?></h3>

        <div style="display: flex; gap: 40px; flex-wrap: wrap;">
            <div>
                <h4><?php _e('Projects', 'developer-portfolio'); ?> (<?php echo $projects->found_posts; ?>)</h4>
                <?php if ($projects->have_posts()) : ?>
                    <ul>
                        <?php while ($projects->have_posts()) : $projects->the_post(); ?>
                            <li>
                                <a href="<?php echo get_edit_post_link(); ?>"><?php the_title(); ?></a>
                            </li>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </ul>
                <?php else : ?>
                    <p style="color: #666;"><?php _e('No featured projects yet.', 'developer-portfolio'); ?></p>
                <?php endif; ?>
            </div>

            <div>
                <h4><?php _e('Posts', 'developer-portfolio'); ?> (<?php echo $posts->found_posts; ?>)</h4>
                <?php if ($posts->have_posts()) : ?>
                    <ul>
                        <?php while ($posts->have_posts()) : $posts->the_post(); ?>
                            <li>
                                <a href="<?php echo get_edit_post_link(); ?>"><?php the_title(); ?></a>
                            </li>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </ul>
                <?php else : ?>
                    <p style="color: #666;"><?php _e('No featured posts yet.', 'developer-portfolio'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
}
