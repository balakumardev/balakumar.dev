<?php
/**
 * Hierarchical Tag Navigation
 * Parses tags with "/" delimiter and builds dropdown navigation
 */

function developer_portfolio_get_tag_hierarchy() {
    $tags = get_tags(array(
        'orderby' => 'count',
        'order' => 'DESC',
        'hide_empty' => true
    ));

    $tree = array();

    foreach ($tags as $tag) {
        // Only process hierarchical tags (those containing "/" delimiter)
        // Skip flat tags like "introduction", "general", etc.
        if (strpos($tag->name, '/') === false) {
            continue;
        }

        $parts = explode('/', $tag->name);
        $current = &$tree;

        foreach ($parts as $i => $part) {
            $part = trim($part);
            if (!isset($current[$part])) {
                $current[$part] = array(
                    'name' => $part,
                    'full_path' => implode('/', array_slice($parts, 0, $i + 1)),
                    'tag' => ($i === count($parts) - 1) ? $tag : null,
                    'children' => array()
                );
            }
            if ($i === count($parts) - 1 && $tag) {
                $current[$part]['tag'] = $tag;
            }
            $current = &$current[$part]['children'];
        }
    }

    return $tree;
}

function developer_portfolio_render_tag_nav() {
    $hierarchy = developer_portfolio_get_tag_hierarchy();
    if (empty($hierarchy)) return;

    ?>
    <nav class="tag-navigation" aria-label="Browse by topic">
        <div class="tag-nav-container">
            <span class="tag-nav-label">// topics</span>
            <ul class="tag-nav-list" id="tag-nav-list">
                <li class="tag-nav-item">
                    <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="tag-nav-link tag-nav-all">All</a>
                </li>
                <?php developer_portfolio_render_tag_items($hierarchy); ?>
                <!-- More dropdown for overflow items -->
                <li class="tag-nav-item tag-nav-more has-children" id="tag-nav-more">
                    <a href="#" class="tag-nav-link" onclick="return false;">
                        More
                        <svg class="dropdown-arrow" width="10" height="6" viewBox="0 0 10 6" fill="none">
                            <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                    <ul class="tag-nav-dropdown" id="tag-nav-more-dropdown">
                        <!-- Overflow items will be moved here by JS -->
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <?php
}

function developer_portfolio_render_tag_items($items, $level = 0) {
    foreach ($items as $item) {
        $has_children = !empty($item['children']);
        $tag = $item['tag'];
        $link = $tag ? get_tag_link($tag->term_id) : '#';
        $count = $tag ? $tag->count : 0;
        ?>
        <li class="tag-nav-item<?php echo $has_children ? ' has-children' : ''; ?>">
            <a href="<?php echo esc_url($link); ?>" class="tag-nav-link">
                <?php echo esc_html($item['name']); ?>
                <?php if ($count > 0): ?>
                    <span class="tag-count"><?php echo $count; ?></span>
                <?php endif; ?>
                <?php if ($has_children): ?>
                    <svg class="dropdown-arrow" width="10" height="6" viewBox="0 0 10 6" fill="none">
                        <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                <?php endif; ?>
            </a>
            <?php if ($has_children): ?>
                <ul class="tag-nav-dropdown">
                    <?php developer_portfolio_render_tag_items($item['children'], $level + 1); ?>
                </ul>
            <?php endif; ?>
        </li>
        <?php
    }
}
