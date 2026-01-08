<?php
/**
 * Search Form Template
 *
 * @package Developer_Portfolio
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url("/")); ?>">
    <label class="screen-reader-text" for="search-field">
        <?php esc_html_e("Search for:", "developer-portfolio"); ?>
    </label>
    <div class="search-input-wrapper">
        <span class="search-prompt">$</span>
        <input type="search" 
               id="search-field" 
               class="search-field" 
               placeholder="<?php esc_attr_e("Search articles...", "developer-portfolio"); ?>"
               value="<?php echo get_search_query(); ?>" 
               name="s" 
               autocomplete="off" />
        <button type="submit" class="search-submit" aria-label="<?php esc_attr_e("Search", "developer-portfolio"); ?>">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="M21 21l-4.35-4.35"></path>
            </svg>
        </button>
    </div>
</form>
