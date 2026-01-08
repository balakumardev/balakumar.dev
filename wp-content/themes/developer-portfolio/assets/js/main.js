/**
 * Developer Portfolio Theme - Main JavaScript
 * 
 * @package Developer_Portfolio
 * @version 1.2.0
 * 
 * Features robust error handling to ensure the page never breaks
 */

(function() {
    "use strict";

    // Global error tracking
    var errorCount = 0;
    var maxErrors = 5;
    var errorBannerShown = false;

    /**
     * Safe function wrapper - catches errors and logs them
     * @param {Function} fn - The function to execute
     * @param {string} name - Name of the function for logging
     * @returns {Function} - Wrapped function
     */
    function safeExecute(fn, name) {
        return function() {
            try {
                return fn.apply(this, arguments);
            } catch (error) {
                errorCount++;
                console.warn("[Theme Error] " + name + ":", error.message);
                logError(name, error);
                
                // Show error banner only if too many errors
                if (errorCount >= maxErrors && !errorBannerShown) {
                    showErrorBanner();
                }
                return undefined;
            }
        };
    }

    /**
     * Log error for debugging
     */
    function logError(context, error) {
        if (window.devPortfolioErrorLog) {
            window.devPortfolioErrorLog.push({
                context: context,
                message: error.message,
                stack: error.stack,
                timestamp: new Date().toISOString()
            });
        }
    }

    /**
     * Show error banner to user (only for severe issues)
     */
    function showErrorBanner() {
        if (errorBannerShown) return;
        errorBannerShown = true;

        var banner = document.createElement("div");
        banner.className = "js-error-banner";
        banner.innerHTML = 
            '<div class="js-error-banner-header">' +
                '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">' +
                    '<circle cx="12" cy="12" r="10"/>' +
                    '<line x1="12" y1="8" x2="12" y2="12"/>' +
                    '<line x1="12" y1="16" x2="12.01" y2="16"/>' +
                '</svg>' +
                '<span>Minor Issues Detected</span>' +
            '</div>' +
            '<p>Some features may not work properly. Try refreshing the page.</p>' +
            '<div class="js-error-banner-actions">' +
                '<button class="js-error-dismiss">Dismiss</button>' +
                '<button class="js-error-reload">Reload Page</button>' +
            '</div>';

        document.body.appendChild(banner);

        // Add event listeners
        banner.querySelector(".js-error-dismiss").addEventListener("click", function() {
            banner.remove();
        });

        banner.querySelector(".js-error-reload").addEventListener("click", function() {
            window.location.reload();
        });

        // Auto-dismiss after 10 seconds
        setTimeout(function() {
            if (banner.parentNode) {
                banner.style.opacity = "0";
                banner.style.transition = "opacity 0.3s ease";
                setTimeout(function() {
                    if (banner.parentNode) banner.remove();
                }, 300);
            }
        }, 10000);
    }

    // DOM Ready with error handling
    document.addEventListener("DOMContentLoaded", function() {
        // Initialize all features with error protection
        safeExecute(initHeaderScroll, "initHeaderScroll")();
        safeExecute(initMobileMenu, "initMobileMenu")();
        safeExecute(initSearchOverlay, "initSearchOverlay")();
        safeExecute(initScrollAnimations, "initScrollAnimations")();
        safeExecute(initSmoothScroll, "initSmoothScroll")();
        safeExecute(initCopyLink, "initCopyLink")();
        safeExecute(initCodeHighlighting, "initCodeHighlighting")();
        safeExecute(initTOCHighlight, "initTOCHighlight")();
        safeExecute(initTypingAnimation, "initTypingAnimation")();
        safeExecute(initCategoryFilter, "initCategoryFilter")();
        safeExecute(initLoadMore, "initLoadMore")();
    });

    // Header Scroll Effect
    function initHeaderScroll() {
        var header = document.getElementById("masthead");
        if (!header) return;

        var scrollThreshold = 50;

        function handleScroll() {
            var currentScroll = window.pageYOffset || document.documentElement.scrollTop || 0;
            
            if (currentScroll > scrollThreshold) {
                header.classList.add("scrolled");
            } else {
                header.classList.remove("scrolled");
            }
        }

        window.addEventListener("scroll", throttle(handleScroll, 10));
        handleScroll();
    }

    // Mobile Menu
    function initMobileMenu() {
        var menuToggle = document.querySelector(".menu-toggle");
        var primaryMenu = document.querySelector(".primary-menu");
        
        if (!menuToggle || !primaryMenu) return;

        menuToggle.addEventListener("click", function() {
            var isExpanded = this.getAttribute("aria-expanded") === "true";
            
            this.setAttribute("aria-expanded", !isExpanded);
            primaryMenu.classList.toggle("active");
            document.body.classList.toggle("menu-open");
        });

        var menuLinks = primaryMenu.querySelectorAll("a");
        menuLinks.forEach(function(link) {
            link.addEventListener("click", function() {
                menuToggle.setAttribute("aria-expanded", "false");
                primaryMenu.classList.remove("active");
                document.body.classList.remove("menu-open");
            });
        });

        document.addEventListener("keydown", function(e) {
            if (e.key === "Escape" && primaryMenu.classList.contains("active")) {
                menuToggle.setAttribute("aria-expanded", "false");
                primaryMenu.classList.remove("active");
                document.body.classList.remove("menu-open");
            }
        });
    }

    // Search Overlay
    function initSearchOverlay() {
        var searchToggle = document.querySelector(".search-toggle");
        var searchOverlay = document.querySelector(".search-overlay");
        var searchClose = document.querySelector(".search-close");
        var searchField = document.querySelector(".search-field");

        if (!searchToggle || !searchOverlay) return;

        function openSearch() {
            searchOverlay.classList.add("active");
            searchOverlay.setAttribute("aria-hidden", "false");
            document.body.style.overflow = "hidden";
            
            setTimeout(function() {
                if (searchField) searchField.focus();
            }, 300);
        }

        function closeSearch() {
            searchOverlay.classList.remove("active");
            searchOverlay.setAttribute("aria-hidden", "true");
            document.body.style.overflow = "";
            searchToggle.focus();
        }

        searchToggle.addEventListener("click", openSearch);
        
        if (searchClose) {
            searchClose.addEventListener("click", closeSearch);
        }

        document.addEventListener("keydown", function(e) {
            if (e.key === "Escape" && searchOverlay.classList.contains("active")) {
                closeSearch();
            }
        });

        searchOverlay.addEventListener("click", function(e) {
            if (e.target === searchOverlay) {
                closeSearch();
            }
        });
    }

    // Scroll Animations with IntersectionObserver
    function initScrollAnimations() {
        var animatedElements = document.querySelectorAll(".animate-on-scroll:not(.is-visible)");
        
        if (!animatedElements.length) return;

        // Fallback for browsers without IntersectionObserver
        if (!("IntersectionObserver" in window)) {
            animatedElements.forEach(function(el) {
                el.classList.add("is-visible");
            });
            return;
        }

        var observerOptions = {
            root: null,
            rootMargin: "0px 0px -100px 0px",
            threshold: 0.1
        };

        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    var delay = entry.target.style.getPropertyValue("--delay") || "0s";
                    var delayMs = parseFloat(delay) * 1000 || 0;
                    
                    setTimeout(function() {
                        entry.target.classList.add("is-visible");
                    }, delayMs);
                    
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        animatedElements.forEach(function(el) {
            observer.observe(el);
        });
    }

    // Category Filter with AJAX
    function initCategoryFilter() {
        var filterContainer = document.getElementById("category-filter");
        var postsContainer = document.getElementById("posts-container");
        var loadingIndicator = document.getElementById("posts-loading");
        var loadMoreContainer = document.getElementById("load-more-container");
        
        if (!filterContainer || !postsContainer) return;
        if (typeof devPortfolioAjax === "undefined") return;

        var filterButtons = filterContainer.querySelectorAll(".filter-pill");
        var currentCategory = "all";
        var isLoading = false;

        filterButtons.forEach(function(button) {
            button.addEventListener("click", function() {
                if (isLoading) return;
                
                var category = this.dataset.category;
                if (category === currentCategory) return;

                // Update active state
                filterButtons.forEach(function(btn) {
                    btn.classList.remove("active");
                    btn.setAttribute("aria-pressed", "false");
                });
                this.classList.add("active");
                this.setAttribute("aria-pressed", "true");

                currentCategory = category;
                postsContainer.dataset.category = category;
                postsContainer.dataset.page = "1";

                // Add ripple effect
                safeExecute(addRippleEffect, "addRippleEffect")(this);

                // Fetch filtered posts
                fetchPosts(category, 1, true);
            });
        });

        function fetchPosts(category, page, replace) {
            isLoading = true;
            
            // Show loading state
            if (loadingIndicator) {
                loadingIndicator.setAttribute("aria-hidden", "false");
                loadingIndicator.classList.add("active");
            }
            
            // Fade out current posts
            postsContainer.classList.add("loading");

            var formData = new FormData();
            formData.append("action", "filter_posts");
            formData.append("category", category);
            formData.append("page", page);
            formData.append("nonce", devPortfolioAjax.nonce);

            fetch(devPortfolioAjax.ajaxUrl, {
                method: "POST",
                body: formData,
                credentials: "same-origin"
            })
            .then(function(response) {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then(function(data) {
                if (data.success) {
                    // Update posts container
                    if (replace) {
                        postsContainer.innerHTML = data.data.html;
                    } else {
                        postsContainer.insertAdjacentHTML("beforeend", data.data.html);
                    }
                    
                    // Update data attributes
                    postsContainer.dataset.page = data.data.current_page;
                    postsContainer.dataset.maxPages = data.data.max_pages;

                    // Update pagination info
                    updatePaginationInfo(data.data);

                    // Show/hide load more button
                    if (loadMoreContainer) {
                        if (data.data.current_page >= data.data.max_pages) {
                            loadMoreContainer.classList.add("hidden");
                        } else {
                            loadMoreContainer.classList.remove("hidden");
                        }
                    }

                    // Re-initialize scroll animations for new posts
                    setTimeout(function() {
                        safeExecute(initScrollAnimations, "initScrollAnimations")();
                    }, 100);
                }
            })
            .catch(function(error) {
                console.error("Filter error:", error);
                // Show user-friendly error
                postsContainer.innerHTML = 
                    '<div class="content-error">' +
                        '<h3>Unable to load posts</h3>' +
                        '<p>Please try again or refresh the page.</p>' +
                        '<button onclick="location.reload()" class="error-retry-btn">Retry</button>' +
                    '</div>';
            })
            .finally(function() {
                isLoading = false;
                postsContainer.classList.remove("loading");
                
                if (loadingIndicator) {
                    loadingIndicator.setAttribute("aria-hidden", "true");
                    loadingIndicator.classList.remove("active");
                }
            });
        }

        function updatePaginationInfo(data) {
            var showingCount = document.getElementById("showing-count");
            var totalCount = document.getElementById("total-count");
            
            if (showingCount && totalCount) {
                var showing = Math.min(data.current_page * 6, data.found_posts);
                showingCount.textContent = showing;
                totalCount.textContent = data.found_posts;
            }
        }

        function addRippleEffect(element) {
            var ripple = document.createElement("span");
            ripple.className = "filter-ripple";
            element.appendChild(ripple);
            
            setTimeout(function() {
                if (ripple.parentNode) ripple.remove();
            }, 600);
        }

        // Expose fetchPosts for load more functionality
        window.devPortfolioFetchPosts = fetchPosts;
        window.devPortfolioGetCurrentCategory = function() { return currentCategory; };
    }

    // Load More Button
    function initLoadMore() {
        var loadMoreBtn = document.getElementById("load-more-btn");
        var postsContainer = document.getElementById("posts-container");
        var loadMoreContainer = document.getElementById("load-more-container");
        
        if (!loadMoreBtn || !postsContainer) return;
        if (typeof devPortfolioAjax === "undefined") return;

        var isLoading = false;

        loadMoreBtn.addEventListener("click", function() {
            if (isLoading) return;
            
            var currentPage = parseInt(postsContainer.dataset.page) || 1;
            var maxPages = parseInt(postsContainer.dataset.maxPages) || 1;
            var category = postsContainer.dataset.category || "all";
            
            if (currentPage >= maxPages) {
                if (loadMoreContainer) loadMoreContainer.classList.add("hidden");
                return;
            }

            isLoading = true;
            loadMoreBtn.classList.add("loading");

            var formData = new FormData();
            formData.append("action", "load_more_posts");
            formData.append("category", category);
            formData.append("page", currentPage + 1);
            formData.append("nonce", devPortfolioAjax.nonce);

            fetch(devPortfolioAjax.ajaxUrl, {
                method: "POST",
                body: formData,
                credentials: "same-origin"
            })
            .then(function(response) {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then(function(data) {
                if (data.success && data.data.html) {
                    // Append new posts
                    postsContainer.insertAdjacentHTML("beforeend", data.data.html);
                    
                    // Update data attributes
                    postsContainer.dataset.page = data.data.current_page;

                    // Update pagination info
                    var showingCount = document.getElementById("showing-count");
                    var totalCount = document.getElementById("total-count");
                    
                    if (showingCount && totalCount) {
                        var showing = Math.min(data.data.current_page * 6, data.data.found_posts);
                        showingCount.textContent = showing;
                        totalCount.textContent = data.data.found_posts;
                    }

                    // Hide button if no more pages
                    if (data.data.current_page >= data.data.max_pages) {
                        if (loadMoreContainer) loadMoreContainer.classList.add("hidden");
                    }

                    // Re-initialize scroll animations for new posts
                    setTimeout(function() {
                        safeExecute(initScrollAnimations, "initScrollAnimations")();
                    }, 100);
                }
            })
            .catch(function(error) {
                console.error("Load more error:", error);
            })
            .finally(function() {
                isLoading = false;
                loadMoreBtn.classList.remove("loading");
            });
        });
    }

    // Smooth Scroll for anchor links
    function initSmoothScroll() {
        var anchors = document.querySelectorAll("a[href^=\"#\"]");
        
        anchors.forEach(function(anchor) {
            anchor.addEventListener("click", function(e) {
                var targetId = this.getAttribute("href");
                
                if (targetId === "#" || !targetId) return;
                
                var targetElement = null;
                try {
                    targetElement = document.querySelector(targetId);
                } catch (err) {
                    // Invalid selector, ignore
                    return;
                }
                
                if (targetElement) {
                    e.preventDefault();
                    
                    var header = document.getElementById("masthead");
                    var headerHeight = header ? header.offsetHeight : 80;
                    var targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - headerHeight - 20;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: "smooth"
                    });

                    if (history.pushState) {
                        history.pushState(null, null, targetId);
                    }
                }
            });
        });
    }

    // Terminal Typing Animation
    function initTypingAnimation() {
        var terminalWindow = document.querySelector(".terminal-window");
        if (!terminalWindow) return;

        var commands = terminalWindow.querySelectorAll(".terminal-command");
        var outputs = terminalWindow.querySelectorAll(".terminal-output");
        var cursor = terminalWindow.querySelector(".terminal-cursor");

        if (!commands.length) return;

        outputs.forEach(function(output) {
            output.style.opacity = "0";
            output.style.transform = "translateY(10px)";
        });

        if (cursor) {
            cursor.style.opacity = "0";
        }

        var commandTexts = [];
        commands.forEach(function(cmd) {
            commandTexts.push(cmd.textContent || "");
            cmd.textContent = "";
        });

        var currentCommand = 0;
        var currentChar = 0;
        var typingSpeed = 50;
        var pauseBetweenCommands = 500;
        var pauseAfterCommand = 300;

        function typeNextChar() {
            if (currentCommand >= commands.length) {
                if (cursor) {
                    cursor.style.opacity = "1";
                }
                return;
            }

            var cmd = commands[currentCommand];
            var text = commandTexts[currentCommand] || "";

            if (currentChar < text.length) {
                cmd.textContent += text[currentChar];
                currentChar++;
                setTimeout(typeNextChar, typingSpeed);
            } else {
                setTimeout(function() {
                    if (outputs[currentCommand]) {
                        outputs[currentCommand].style.transition = "opacity 0.4s ease, transform 0.4s ease";
                        outputs[currentCommand].style.opacity = "1";
                        outputs[currentCommand].style.transform = "translateY(0)";
                    }
                    
                    currentCommand++;
                    currentChar = 0;
                    setTimeout(typeNextChar, pauseBetweenCommands);
                }, pauseAfterCommand);
            }
        }

        setTimeout(typeNextChar, 800);
    }

    // Copy Link
    function initCopyLink() {
        var copyButtons = document.querySelectorAll(".share-copy");
        
        copyButtons.forEach(function(button) {
            button.addEventListener("click", function() {
                var url = this.dataset.url;
                var btn = this;
                
                if (!navigator.clipboard) {
                    // Fallback for older browsers
                    fallbackCopyTextToClipboard(url, btn);
                    return;
                }
                
                navigator.clipboard.writeText(url).then(function() {
                    showCopySuccess(btn);
                }).catch(function(err) {
                    console.warn("Clipboard API failed, using fallback:", err);
                    fallbackCopyTextToClipboard(url, btn);
                });
            });
        });
    }

    function fallbackCopyTextToClipboard(text, btn) {
        var textArea = document.createElement("textarea");
        textArea.value = text;
        textArea.style.cssText = "position:fixed;top:0;left:0;width:2em;height:2em;padding:0;border:none;outline:none;box-shadow:none;background:transparent";
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        
        try {
            document.execCommand("copy");
            showCopySuccess(btn);
        } catch (err) {
            console.error("Fallback copy failed:", err);
        }
        
        document.body.removeChild(textArea);
    }

    function showCopySuccess(btn) {
        var originalContent = btn.innerHTML;
        btn.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>';
        btn.style.color = "var(--color-accent-primary)";
        
        setTimeout(function() {
            btn.innerHTML = originalContent;
            btn.style.color = "";
        }, 2000);
    }

    // Code Highlighting Enhancement with robust error handling
    function initCodeHighlighting() {
        var codeBlocks = document.querySelectorAll("pre[class*=\"language-\"], pre.line-numbers, .single-content pre, .page-content pre");
        var processedBlocks = new Set();

        codeBlocks.forEach(function(block) {
            try {
                if (processedBlocks.has(block)) return;
                processedBlocks.add(block);

                var codeElement = block.querySelector("code");
                if (!codeElement && !block.textContent.trim()) return;

                var copyButton = document.createElement("button");
                copyButton.className = "code-copy-button";
                copyButton.setAttribute("aria-label", "Copy code");
                copyButton.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg><span>Copy</span>';

                block.style.position = "relative";

                if (codeElement) {
                    var langMatch = codeElement.className.match(/language-(\w+)/);
                    if (langMatch) {
                        block.setAttribute("data-language", langMatch[1]);
                    }
                }

                copyButton.addEventListener("click", function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    var code = block.querySelector("code");
                    var text = code ? code.textContent : block.textContent;
                    var btn = this;

                    if (!navigator.clipboard) {
                        fallbackCopyTextToClipboard(text, btn);
                        return;
                    }

                    navigator.clipboard.writeText(text).then(function() {
                        btn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg><span>Copied!</span>';
                        btn.classList.add("copied");

                        setTimeout(function() {
                            btn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg><span>Copy</span>';
                            btn.classList.remove("copied");
                        }, 2000);

                    }).catch(function(err) {
                        console.warn("Copy failed:", err);
                        fallbackCopyTextToClipboard(text, btn);
                    });
                });

                block.appendChild(copyButton);
            } catch (error) {
                console.warn("Error processing code block:", error);
            }
        });

        // Safely initialize Prism.js with error recovery
        initPrismSafely();
    }

    /**
     * Safely initialize Prism.js syntax highlighting
     */
    function initPrismSafely() {
        if (typeof Prism === "undefined") {
            console.info("[Theme] Prism.js not loaded, code blocks will display without syntax highlighting");
            return;
        }

        try {
            // Set a timeout in case Prism hangs
            var highlightTimeout = setTimeout(function() {
                console.warn("[Theme] Prism.js highlighting took too long, aborting");
            }, 5000);

            Prism.highlightAll();
            clearTimeout(highlightTimeout);
        } catch (error) {
            console.warn("[Theme] Prism.js highlighting failed:", error.message);
            // Code blocks will still display, just without syntax colors
            
            // Add a visual indicator that highlighting failed
            var failedBlocks = document.querySelectorAll("pre code:not(.prism-highlighted)");
            failedBlocks.forEach(function(block) {
                block.closest("pre").classList.add("highlight-fallback");
            });
        }
    }

    // Table of Contents Highlight
    function initTOCHighlight() {
        var toc = document.querySelector(".toc");
        if (!toc) return;

        var tocLinks = toc.querySelectorAll(".toc-link");
        var headings = [];
        
        tocLinks.forEach(function(link) {
            var href = link.getAttribute("href");
            if (!href || href === "#") return;
            
            try {
                var heading = document.querySelector(href);
                if (heading) {
                    headings.push({
                        link: link,
                        heading: heading
                    });
                }
            } catch (err) {
                // Invalid selector, skip
            }
        });

        if (!headings.length) return;

        function highlightCurrentSection() {
            var header = document.getElementById("masthead");
            var headerHeight = header ? header.offsetHeight : 80;
            var scrollPosition = window.pageYOffset + headerHeight + 100;

            var current = headings[0];
            
            headings.forEach(function(item) {
                if (item.heading.offsetTop <= scrollPosition) {
                    current = item;
                }
            });

            tocLinks.forEach(function(link) {
                link.classList.remove("active");
                link.style.color = "";
            });
            
            if (current && current.link) {
                current.link.classList.add("active");
                current.link.style.color = "var(--color-accent-primary)";
            }
        }

        window.addEventListener("scroll", throttle(highlightCurrentSection, 100));
        highlightCurrentSection();
    }

    // Utility Functions
    function throttle(func, limit) {
        var inThrottle;
        return function() {
            var args = arguments;
            var context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(function() {
                    inThrottle = false;
                }, limit);
            }
        };
    }

    function debounce(func, wait) {
        var timeout;
        return function executedFunction() {
            var context = this;
            var args = arguments;
            var later = function() {
                timeout = null;
                func.apply(context, args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Expose utility for external use
    window.devPortfolioSafeExecute = safeExecute;

})();
