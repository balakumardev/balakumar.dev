/**
 * Featured Panel JavaScript
 *
 * Scroll-triggered panel: hidden initially, fades in after scrolling
 * past the hero section, shown as collapsed tab.
 *
 * @package Developer_Portfolio
 * @since 1.1.0
 */

(function() {
    "use strict";

    var STORAGE_KEY = "devPortfolio_featuredPanelCollapsed";
    var SCROLL_THRESHOLD = 500;

    function initFeaturedPanel() {
        var panel = document.getElementById("featured-panel");
        if (!panel) {
            return;
        }

        var tab = panel.querySelector(".featured-panel-tab");
        var closeBtn = panel.querySelector(".featured-panel-close");
        var isVisible = false;

        // Always start hidden and collapsed
        panel.classList.add("is-collapsed");
        panel.classList.remove("is-visible");
        if (tab) {
            tab.setAttribute("aria-expanded", "false");
        }

        // If user already scrolled past threshold on page load (e.g. refresh mid-page)
        if (window.scrollY > SCROLL_THRESHOLD) {
            showPanel();
        }

        // Scroll listener — show/hide based on scroll position
        window.addEventListener("scroll", function() {
            if (window.scrollY > SCROLL_THRESHOLD && !isVisible) {
                showPanel();
            } else if (window.scrollY <= SCROLL_THRESHOLD && isVisible) {
                hidePanel();
            }
        }, { passive: true });

        // Tab click — expand panel
        if (tab) {
            tab.addEventListener("click", function() {
                setCollapsed(false);
            });
        }

        // Close button — collapse panel
        if (closeBtn) {
            closeBtn.addEventListener("click", function() {
                setCollapsed(true);
            });
        }

        // Escape key — collapse panel
        document.addEventListener("keydown", function(e) {
            if (e.key === "Escape" && !panel.classList.contains("is-collapsed")) {
                setCollapsed(true);
                if (tab) {
                    tab.focus();
                }
            }
        });

        function showPanel() {
            isVisible = true;
            panel.classList.add("is-visible");
        }

        function hidePanel() {
            isVisible = false;
            // Collapse first, then hide
            setCollapsed(true);
            panel.classList.remove("is-visible");
        }

        function setCollapsed(collapsed) {
            if (collapsed) {
                panel.classList.add("is-collapsed");
            } else {
                panel.classList.remove("is-collapsed");
            }
            if (tab) {
                tab.setAttribute("aria-expanded", collapsed ? "false" : "true");
            }
        }
    }

    // Initialize on DOM ready
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", initFeaturedPanel);
    } else {
        initFeaturedPanel();
    }
})();
