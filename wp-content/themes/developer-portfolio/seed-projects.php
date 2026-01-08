<?php
/**
 * Project Seeder Script
 *
 * Seeds the 9 portfolio projects into WordPress database.
 *
 * Usage:
 *   Via WP-CLI: wp eval-file wp-content/themes/developer-portfolio/seed-projects.php
 *   Via browser: Add ?seed_projects=1 to any admin page URL (requires admin login)
 *
 * @package developer-portfolio
 */

// Prevent direct access unless via WP-CLI or WordPress admin
if (!defined('ABSPATH')) {
    // Check if running via WP-CLI
    if (defined('WP_CLI') && WP_CLI) {
        // Running via WP-CLI, continue
    } else {
        exit('Direct access not allowed.');
    }
}

/**
 * Main seeder function
 */
function developer_portfolio_seed_projects() {
    // Define all projects to seed
    $projects = array(
        array(
            'title'       => 'BHelper',
            'description' => 'A macOS menu bar app for AI-powered text rewriting. Supports Claude, GPT, and other LLMs for instant text enhancement, translation, and formatting.',
            'github'      => 'https://github.com/balakumardev/bhelper',
            'tech'        => 'Swift, SwiftUI, Claude API, GPT API',
            'icon'        => 'apple',
            'type_slug'   => 'macos-app',
            'featured'    => '1',
            'sort_order'  => 1,
        ),
        array(
            'title'       => 'project-echo',
            'description' => 'Privacy-first macOS utility for meeting transcription using local AI. Transcribes meetings without sending data to the cloud.',
            'github'      => 'https://github.com/balakumardev/project-echo',
            'tech'        => 'Swift, Whisper, Local AI',
            'icon'        => 'apple',
            'type_slug'   => 'macos-app',
            'featured'    => '1',
            'sort_order'  => 2,
        ),
        array(
            'title'       => 'bsummarize-firefox',
            'description' => 'Firefox extension for AI-powered web page summarization and translation. Supports Gemini, Llama3, and Mistral models.',
            'github'      => 'https://github.com/balakumardev/bsummarize-firefox',
            'tech'        => 'JavaScript, WebExtensions API, Gemini, Llama3',
            'icon'        => 'firefox',
            'type_slug'   => 'browser-extension',
            'featured'    => '1',
            'sort_order'  => 3,
        ),
        array(
            'title'       => 'ContextCraft',
            'description' => 'JetBrains IDE plugin that helps AI assistants understand your code better by providing rich context about your project structure.',
            'github'      => 'https://github.com/balakumardev/ContextCraft',
            'tech'        => 'Kotlin, IntelliJ Platform SDK',
            'icon'        => 'puzzle',
            'type_slug'   => 'ide-plugin',
            'featured'    => '1',
            'sort_order'  => 4,
        ),
        array(
            'title'       => 'PromptForge',
            'description' => 'JetBrains plugin for generating context-rich prompts for LLMs. Right-click any code, get intelligent prompts ready for AI assistants.',
            'github'      => 'https://github.com/balakumardev/PromptForge',
            'tech'        => 'Kotlin, IntelliJ Platform SDK',
            'icon'        => 'hammer',
            'type_slug'   => 'ide-plugin',
            'featured'    => '0',
            'sort_order'  => 5,
        ),
        array(
            'title'       => 'VSCodeCompass',
            'description' => 'AI-powered code search and Q&A tool for VS Code. Ask questions about your codebase and get intelligent answers.',
            'github'      => 'https://github.com/balakumardev/VSCodeCompass',
            'tech'        => 'TypeScript, VS Code API, LangChain',
            'icon'        => 'compass',
            'type_slug'   => 'ide-plugin',
            'featured'    => '0',
            'sort_order'  => 6,
        ),
        array(
            'title'       => 'perplexity-web-wrapper',
            'description' => 'Python wrapper and MCP server for Perplexity AI. Enables Claude Code, Cursor, and other AI tools to use Perplexity for web research.',
            'github'      => 'https://github.com/balakumardev/perplexity-web-wrapper',
            'tech'        => 'Python, FastMCP, Perplexity API',
            'icon'        => 'server',
            'type_slug'   => 'mcp-server',
            'featured'    => '1',
            'sort_order'  => 7,
        ),
        array(
            'title'       => 'antigravity-reverseproxy-api',
            'description' => 'Proxy server that exposes Anthropic and OpenAI APIs for Claude Code CLI. Enables seamless API access for AI coding assistants.',
            'github'      => 'https://github.com/balakumardev/antigravity-reverseproxy-api',
            'tech'        => 'JavaScript, Node.js, Express',
            'icon'        => 'network-wired',
            'type_slug'   => 'developer-tool',
            'featured'    => '0',
            'sort_order'  => 8,
        ),
        array(
            'title'       => 'ai-agent-design-patterns',
            'description' => 'Production-ready architectural patterns for building AI agents. Comprehensive guide with code examples for common agent patterns.',
            'github'      => 'https://github.com/balakumardev/ai-agent-design-patterns',
            'tech'        => 'Python, LangChain, OpenAI',
            'icon'        => 'book',
            'type_slug'   => 'documentation',
            'featured'    => '0',
            'sort_order'  => 9,
        ),
    );

    // Define project types (taxonomy terms)
    $project_types = array(
        'macos-app'         => 'macOS App',
        'browser-extension' => 'Browser Extension',
        'ide-plugin'        => 'IDE Plugin',
        'mcp-server'        => 'MCP Server',
        'developer-tool'    => 'Developer Tool',
        'documentation'     => 'Documentation',
        'web-app'           => 'Web App',
        'cli-tool'          => 'CLI Tool',
    );

    // Output function (works in both CLI and browser)
    $output = function($message) {
        if (defined('WP_CLI') && WP_CLI) {
            WP_CLI::log($message);
        } else {
            echo $message . "<br>\n";
        }
    };

    $success = function($message) {
        if (defined('WP_CLI') && WP_CLI) {
            WP_CLI::success($message);
        } else {
            echo "<span style='color:green;'>SUCCESS: $message</span><br>\n";
        }
    };

    $warning = function($message) {
        if (defined('WP_CLI') && WP_CLI) {
            WP_CLI::warning($message);
        } else {
            echo "<span style='color:orange;'>WARNING: $message</span><br>\n";
        }
    };

    $error = function($message) {
        if (defined('WP_CLI') && WP_CLI) {
            WP_CLI::error($message, false);
        } else {
            echo "<span style='color:red;'>ERROR: $message</span><br>\n";
        }
    };

    $output("========================================");
    $output("Starting Project Seeder");
    $output("========================================");
    $output("");

    // Step 1: Ensure project_type taxonomy terms exist
    $output("Step 1: Creating project type taxonomy terms...");
    $output("----------------------------------------");

    foreach ($project_types as $slug => $name) {
        $term = term_exists($slug, 'project_type');
        if (!$term) {
            $result = wp_insert_term($name, 'project_type', array('slug' => $slug));
            if (is_wp_error($result)) {
                $error("Failed to create term '$name': " . $result->get_error_message());
            } else {
                $success("Created term: $name ($slug)");
            }
        } else {
            $output("Term already exists: $name ($slug)");
        }
    }

    $output("");
    $output("Step 2: Seeding projects...");
    $output("----------------------------------------");

    // Track statistics
    $created = 0;
    $skipped = 0;
    $errors = 0;

    // Step 2: Insert projects
    foreach ($projects as $project) {
        // Check if project already exists by title
        $existing = get_page_by_title($project['title'], OBJECT, 'project');

        if ($existing) {
            $warning("Project '{$project['title']}' already exists (ID: {$existing->ID}). Skipping.");
            $skipped++;
            continue;
        }

        // Create the project post
        $post_data = array(
            'post_title'   => $project['title'],
            'post_content' => $project['description'],
            'post_excerpt' => $project['description'],
            'post_status'  => 'publish',
            'post_type'    => 'project',
            'post_author'  => 1, // Admin user
        );

        $post_id = wp_insert_post($post_data);

        if (is_wp_error($post_id)) {
            $error("Failed to create project '{$project['title']}': " . $post_id->get_error_message());
            $errors++;
            continue;
        }

        // Set the project type taxonomy term
        $term = get_term_by('slug', $project['type_slug'], 'project_type');
        if ($term) {
            wp_set_object_terms($post_id, $term->term_id, 'project_type');
        } else {
            $warning("Project type term '{$project['type_slug']}' not found for project '{$project['title']}'");
        }

        // Add meta fields
        update_post_meta($post_id, '_project_github_url', $project['github']);
        update_post_meta($post_id, '_project_homepage_url', ''); // No homepage URL for these projects
        update_post_meta($post_id, '_project_technologies', $project['tech']);
        update_post_meta($post_id, '_project_icon', $project['icon']);
        update_post_meta($post_id, '_project_featured', $project['featured']);
        update_post_meta($post_id, '_project_sort_order', $project['sort_order']);

        $featured_label = $project['featured'] === '1' ? ' [FEATURED]' : '';
        $success("Created project: {$project['title']} (ID: $post_id)$featured_label");
        $created++;
    }

    // Summary
    $output("");
    $output("========================================");
    $output("Seeding Complete!");
    $output("========================================");
    $output("Created: $created projects");
    $output("Skipped: $skipped projects (already exist)");
    $output("Errors:  $errors projects");
    $output("");

    // Flush rewrite rules to ensure project URLs work
    flush_rewrite_rules();
    $output("Rewrite rules flushed.");

    return array(
        'created' => $created,
        'skipped' => $skipped,
        'errors'  => $errors,
    );
}

// Execute the seeder
// When running via WP-CLI with eval-file, WordPress is already loaded
if (defined('WP_CLI') && WP_CLI) {
    developer_portfolio_seed_projects();
}

// Allow running from admin with query param
add_action('admin_init', function() {
    if (isset($_GET['seed_projects']) && $_GET['seed_projects'] === '1') {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized access');
        }

        echo '<!DOCTYPE html><html><head><title>Project Seeder</title></head><body style="font-family: monospace; padding: 20px;">';
        developer_portfolio_seed_projects();
        echo '<br><br><a href="' . admin_url('edit.php?post_type=project') . '">View Projects</a>';
        echo '</body></html>';
        exit;
    }
});
