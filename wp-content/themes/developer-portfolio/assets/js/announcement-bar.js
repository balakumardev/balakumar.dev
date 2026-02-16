/**
 * Announcement Bar JavaScript
 *
 * Handles dismiss behavior with sessionStorage persistence
 * and auto-rotation through multiple featured items.
 *
 * @package Developer_Portfolio
 * @since 1.2.0
 */

(function() {
    "use strict";

    var ROTATE_INTERVAL = 4000;
    var STORAGE_KEY = "dismissed_announcement_bar";

    function initAnnouncementBar() {
        var bar = document.getElementById("announcement-bar");
        if (!bar) {
            return;
        }

        var items = bar.querySelectorAll(".announcement-item");
        var dismissBtn = bar.querySelector(".announcement-dismiss");

        // Check if already dismissed this session
        if (sessionStorage.getItem(STORAGE_KEY)) {
            bar.remove();
            return;
        }

        // Show the bar and add body class for offset
        document.body.classList.add("has-announcement-bar");
        bar.classList.add("is-visible");

        // Auto-rotate if multiple items
        if (items.length > 1) {
            var current = 0;
            setInterval(function() {
                items[current].classList.remove("is-active");
                current = (current + 1) % items.length;
                items[current].classList.add("is-active");
            }, ROTATE_INTERVAL);
        }

        // Dismiss handler
        if (dismissBtn) {
            dismissBtn.addEventListener("click", function() {
                bar.classList.add("is-dismissing");
                bar.classList.remove("is-visible");
                sessionStorage.setItem(STORAGE_KEY, "1");

                bar.addEventListener("animationend", function() {
                    document.body.classList.remove("has-announcement-bar");
                    bar.remove();
                }, { once: true });
            });
        }
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", initAnnouncementBar);
    } else {
        initAnnouncementBar();
    }
})();
