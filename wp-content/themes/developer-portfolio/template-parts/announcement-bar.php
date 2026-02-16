<?php
/**
 * Announcement Bar Template
 *
 * Thin banner pinned below the header that rotates through
 * the newest featured projects and blog posts.
 *
 * @package Developer_Portfolio
 * @since 1.2.0
 */

if (!defined('ABSPATH')) {
    exit;
}

$bar = isset($GLOBALS['developer_portfolio_announcement_bar'])
    ? $GLOBALS['developer_portfolio_announcement_bar']
    : new Developer_Portfolio_Announcement_Bar();

$items = $bar->get_items();
if (empty($items)) {
    return;
}
?>

<div id="announcement-bar" class="announcement-bar hide-on-mobile">
    <div class="announcement-bar-inner">
        <?php foreach ($items as $index => $item) :
            $type = $bar->get_item_type($item);
            $permalink = get_permalink($item->ID);
            $title = get_the_title($item->ID);
            $excerpt = get_the_excerpt($item->ID);
            if (strlen($excerpt) > 80) {
                $excerpt = substr($excerpt, 0, 77) . '...';
            }
        ?>
            <div class="announcement-item<?php echo $index === 0 ? ' is-active' : ''; ?>" data-post-id="<?php echo esc_attr($item->ID); ?>">
                <span class="announcement-label">New <?php echo esc_html($type); ?>:</span>
                <a href="<?php echo esc_url($permalink); ?>" class="announcement-link"><?php echo esc_html($title); ?></a>
                <?php if ($excerpt) : ?>
                    <span class="announcement-sep">&mdash;</span>
                    <span class="announcement-excerpt"><?php echo esc_html($excerpt); ?></span>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <button class="announcement-dismiss" aria-label="<?php esc_attr_e('Dismiss announcement', 'developer-portfolio'); ?>">&times;</button>
    </div>
</div>
