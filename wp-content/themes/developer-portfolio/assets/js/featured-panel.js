/**
 * Featured Panel JavaScript
 *
 * Handles panel expand/collapse interactions and state persistence.
 *
 * @package Developer_Portfolio
 * @since 1.1.0
 */

(function() {
    "use strict";

    var STORAGE_KEY = "devPortfolio_featuredPanelCollapsed";

    /**
     * Safe execute wrapper for error handling
     *
     * @param {Function} fn Function to execute
     * @param {string} context Context for error logging
     */
    function safeExecute(fn, context) {
        try {
            fn();
        } catch (e) {
            console.warn("[Featured Panel] Error in " + context + ":", e.message);
        }
    }

    /**
     * Initialize the featured panel
     */
    function initFeaturedPanel() {
        var panel = document.getElementById("featured-panel");
        if (!panel) {
            return;
        }

        var tab = panel.querySelector(".featured-panel-tab");
        var closeBtn = panel.querySelector(".featured-panel-close");
        var defaultCollapsed = panel.getAttribute("data-collapsed-default") === "true";

        // Restore state from sessionStorage (or use default)
        var savedState = sessionStorage.getItem(STORAGE_KEY);
        if (savedState !== null) {
            var isCollapsed = savedState === "true";
            setCollapsed(panel, tab, isCollapsed);
        } else if (defaultCollapsed) {
            setCollapsed(panel, tab, true);
        }

        // Tab click - expand panel
        if (tab) {
            tab.addEventListener("click", function() {
                setCollapsed(panel, tab, false);
                saveState(false);
            });
        }

        // Close button - collapse panel
        if (closeBtn) {
            closeBtn.addEventListener("click", function() {
                setCollapsed(panel, tab, true);
                saveState(true);
            });
        }

        // Escape key - collapse panel
        document.addEventListener("keydown", function(e) {
            if (e.key === "Escape" && !panel.classList.contains("is-collapsed")) {
                setCollapsed(panel, tab, true);
                saveState(true);
                // Focus the tab for accessibility
                if (tab) {
                    tab.focus();
                }
            }
        });

        // Click outside to collapse (optional - remove if not desired)
        document.addEventListener("click", function(e) {
            if (!panel.contains(e.target) && !panel.classList.contains("is-collapsed")) {
                // Don't auto-close on outside click - can be annoying
                // Uncomment the following lines to enable this behavior:
                // setCollapsed(panel, tab, true);
                // saveState(true);
            }
        });
    }

    /**
     * Set panel collapsed state
     *
     * @param {HTMLElement} panel Panel element
     * @param {HTMLElement} tab Tab button element
     * @param {boolean} collapsed Whether panel should be collapsed
     */
    function setCollapsed(panel, tab, collapsed) {
        if (collapsed) {
            panel.classList.add("is-collapsed");
        } else {
            panel.classList.remove("is-collapsed");
        }

        // Update ARIA state
        if (tab) {
            tab.setAttribute("aria-expanded", collapsed ? "false" : "true");
        }
    }

    /**
     * Save state to sessionStorage
     *
     * @param {boolean} collapsed Whether panel is collapsed
     */
    function saveState(collapsed) {
        try {
            sessionStorage.setItem(STORAGE_KEY, collapsed ? "true" : "false");
        } catch (e) {
            // sessionStorage might be disabled or full
        }
    }

    // Initialize on DOM ready
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", function() {
            safeExecute(initFeaturedPanel, "initFeaturedPanel");
        });
    } else {
        safeExecute(initFeaturedPanel, "initFeaturedPanel");
    }
})();
