<?php
/**
 * Front Page Template
 */
get_header();

$profile = balakumar_dark_get_profile();
$experience = balakumar_dark_get_experience();
$projects = balakumar_dark_get_projects();
$skills = balakumar_dark_get_skills();
?>

<!-- Hero Section -->
<section class="hero" id="home">
    <div class="hero-content">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/profile.png" alt="<?php echo esc_attr($profile['name']); ?>" class="hero-image" onerror="this.style.display='none'">
        <h1><?php echo esc_html($profile['name']); ?></h1>
        <p class="tagline"><?php echo esc_html($profile['tagline']); ?></p>
        <p class="intro"><?php echo esc_html($profile['bio']); ?></p>
        <div class="cta-buttons">
            <a href="#portfolio" class="btn btn-primary">View Portfolio</a>
            <a href="mailto:<?php echo esc_attr($profile['email']); ?>" class="btn btn-secondary">Hire Me</a>
        </div>
    </div>
</section>

<!-- Experience Section -->
<section class="section section-dark" id="experience">
    <div class="container">
        <div class="section-title">
            <h2>Experience</h2>
            <p>Companies I've had the privilege to work with</p>
        </div>

        <div class="portfolio-grid">
            <?php foreach ($experience as $item) : ?>
            <article class="portfolio-card">
                <div class="card-header">
                    <div class="company-logo"><?php echo esc_html($item['logo']); ?></div>
                    <h3><?php echo esc_html($item['company']); ?></h3>
                    <span class="role"><?php echo esc_html($item['role']); ?></span>
                </div>
                <div class="card-body">
                    <p class="description"><?php echo esc_html($item['description']); ?></p>
                    <div class="tech-stack">
                        <?php foreach ($item['tech'] as $tech) : ?>
                        <span class="tech-tag"><?php echo esc_html($tech); ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Portfolio Section -->
<section class="section" id="portfolio">
    <div class="container">
        <div class="section-title">
            <h2>Portfolio</h2>
            <p>Open source projects and side ventures</p>
        </div>

        <div class="portfolio-grid">
            <?php foreach ($projects as $project) : ?>
            <article class="portfolio-card project-card">
                <div class="card-header">
                    <div class="project-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                        </svg>
                    </div>
                    <h3><?php echo esc_html($project['name']); ?></h3>
                </div>
                <div class="card-body">
                    <p class="description"><?php echo esc_html($project['description']); ?></p>
                    <div class="tech-stack">
                        <?php foreach ($project['tech'] as $tech) : ?>
                        <span class="tech-tag"><?php echo esc_html($tech); ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?php echo esc_url($project['url']); ?>" class="github-link" target="_blank" rel="noopener">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                        </svg>
                        View on GitHub
                    </a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Skills Section -->
<section class="section section-dark" id="skills">
    <div class="container">
        <div class="section-title">
            <h2>Skills & Expertise</h2>
            <p>Technologies and tools I work with</p>
        </div>

        <div class="skills-grid">
            <?php foreach ($skills as $category => $skill_list) : ?>
            <div class="skill-category">
                <h3><?php echo esc_html($category); ?></h3>
                <ul class="skill-list">
                    <?php foreach ($skill_list as $skill) : ?>
                    <li>
                        <span><?php echo esc_html($skill); ?></span>
                        <span class="skill-level"><?php echo esc_html($category); ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Blog Section -->
<section class="section" id="blog">
    <div class="container">
        <div class="section-title">
            <h2>Latest Posts</h2>
            <p>Thoughts, tutorials, and insights</p>
        </div>

        <div class="blog-grid">
            <?php
            $recent_posts = new WP_Query(array(
                'posts_per_page' => 3,
                'post_status' => 'publish',
            ));

            if ($recent_posts->have_posts()) :
                while ($recent_posts->have_posts()) : $recent_posts->the_post();
            ?>
            <article class="blog-card">
                <div class="thumbnail">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('medium_large'); ?>
                    <?php endif; ?>
                </div>
                <div class="card-content">
                    <div class="meta"><?php echo get_the_date(); ?></div>
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <p class="excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                </div>
            </article>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
            ?>
            <div class="no-posts">
                <p>No blog posts yet. Check back soon!</p>
            </div>
            <?php endif; ?>
        </div>

        <?php if ($recent_posts->have_posts()) : ?>
        <div style="text-align: center; margin-top: 2rem;">
            <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="btn btn-secondary">View All Posts</a>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Contact Section -->
<section class="section section-dark" id="contact">
    <div class="container">
        <div class="section-title">
            <h2>Get In Touch</h2>
            <p>Let's build something amazing together</p>
        </div>

        <div class="contact-content">
            <p>I'm always interested in hearing about new projects and opportunities. Whether you have a question or just want to say hi, feel free to reach out!</p>

            <div class="contact-links">
                <a href="mailto:<?php echo esc_attr($profile['email']); ?>" class="contact-link">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    <?php echo esc_html($profile['email']); ?>
                </a>
                <a href="tel:<?php echo esc_attr($profile['phone']); ?>" class="contact-link">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                    <?php echo esc_html($profile['phone']); ?>
                </a>
            </div>

            <div class="social-links">
                <a href="https://github.com/balakumardev" class="social-link" target="_blank" rel="noopener" aria-label="GitHub">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                    </svg>
                </a>
                <a href="https://linkedin.com/in/balakumardev" class="social-link" target="_blank" rel="noopener" aria-label="LinkedIn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                    </svg>
                </a>
                <a href="https://twitter.com/balakumardev" class="social-link" target="_blank" rel="noopener" aria-label="Twitter">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
