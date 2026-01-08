<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Bala Kumar - Senior Software Engineer specializing in distributed systems, microservices, and cloud platforms.">
    <?php wp_head(); ?>
<style>.site-logo img,.custom-logo,header img{max-height:40px!important;height:40px!important;width:auto!important}</style></head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="nav-container">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
            <?php
            if (has_custom_logo()) {
                the_custom_logo();
            } else {
                echo 'BK';
            }
            ?>
        </a>

        <button class="menu-toggle" aria-label="Toggle navigation" onclick="document.querySelector('.main-nav').classList.toggle('active')">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <?php balakumar_dark_nav_menu(); ?>
    </div>
</header>

<main id="main" class="site-main">
