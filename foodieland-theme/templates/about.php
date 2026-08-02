<?php
/**
 * About Page Template
 */
if (!defined('ABSPATH')) exit;

get_header();
?>

<div class="about-page-wrapper">
    <?php while (have_posts()) : the_post(); ?>
    
    <!-- Hero Section -->
    <section class="about-hero-section" style="background-image: url('<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'foodieland-hero')); ?>');">
        <div class="about-hero-overlay"></div>
        <div class="container">
            <div class="about-hero-content text-center">
                <h1 class="page-title"><?php the_title(); ?></h1>
                <?php if (get_the_excerpt()) : ?>
                <p class="page-excerpt"><?php echo esc_html(get_the_excerpt()); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>
    
    <!-- Our Story Section -->
    <section class="our-story-section section-padding">
        <div class="container">
            <div class="story-grid">
                <div class="story-content">
                    <h2><?php _e('Our Story', 'foodieland'); ?></h2>
                    <p><?php echo esc_html(get_option('foodieland_story_text', 'Foodieland was born from a passion for great food and a desire to share delicious recipes with the world. What started as a small blog has grown into a community of food lovers from around the globe.')); ?></p>
                    <p><?php _e('We believe that cooking should be enjoyable, accessible, and inspiring. Whether you\'re a beginner or an experienced chef, our recipes are designed to help you create memorable meals for yourself and your loved ones.', 'foodieland'); ?></p>
                    
                    <div class="story-signature">
                        <img src="<?php echo FOODIELAND_URI; ?>/assets/images/signature.png" alt="Founder Signature" />
                        <p><strong><?php echo esc_html(get_option('foodieland_founder_name', 'John Smith')); ?></strong></p>
                        <p><?php _e('Founder & CEO', 'foodieland'); ?></p>
                    </div>
                </div>
                <div class="story-image">
                    <img src="<?php echo FOODIELAND_URI; ?>/assets/images/about-story.jpg" alt="<?php _e('Our Story', 'foodieland'); ?>" loading="lazy" />
                </div>
            </div>
        </div>
    </section>
    
    <!-- Mission & Values -->
    <section class="mission-section section-padding bg-light">
        <div class="container">
            <div class="section-header text-center">
                <h2><?php _e('Our Mission & Values', 'foodieland'); ?></h2>
            </div>
            <div class="mission-grid grid grid-3">
                <div class="mission-card card text-center">
                    <div class="mission-icon">
                        <i class="icon-heart"></i>
                    </div>
                    <h3><?php _e('Passion for Food', 'foodieland'); ?></h3>
                    <p><?php _e('We're passionate about discovering and sharing the best recipes from around the world.', 'foodieland'); ?></p>
                </div>
                <div class="mission-card card text-center">
                    <div class="mission-icon">
                        <i class="icon-users"></i>
                    </div>
                    <h3><?php _e('Community First', 'foodieland'); ?></h3>
                    <p><?php _e('Building a supportive community of food enthusiasts who love to cook and share.', 'foodieland'); ?></p>
                </div>
                <div class="mission-card card text-center">
                    <div class="mission-icon">
                        <i class="icon-leaf"></i>
                    </div>
                    <h3><?php _e('Quality Ingredients', 'foodieland'); ?></h3>
                    <p><?php _e('Promoting the use of fresh, quality ingredients in every recipe we share.', 'foodieland'); ?></p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Team Section -->
    <section class="team-section section-padding">
        <div class="container">
            <div class="section-header text-center">
                <h2><?php _e('Meet Our Team', 'foodieland'); ?></h2>
                <p><?php _e('The talented people behind Foodieland', 'foodieland'); ?></p>
            </div>
            <div class="team-grid grid grid-4">
                <?php
                $chef_args = array(
                    'post_type' => 'chefs',
                    'posts_per_page' => 8,
                );
                $chef_query = new WP_Query($chef_args);
                
                if ($chef_query->have_posts()) :
                    while ($chef_query->have_posts()) : $chef_query->the_post();
                ?>
                <div class="team-member card">
                    <div class="member-image">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('foodieland-portrait'); ?>
                        <?php else : ?>
                            <img src="<?php echo FOODIELAND_URI; ?>/assets/images/placeholder-chef.jpg" alt="<?php the_title_attribute(); ?>" />
                        <?php endif; ?>
                        <div class="member-social">
                            <?php if (get_post_meta(get_the_ID(), '_chef_facebook', true)) : ?>
                            <a href="<?php echo esc_url(get_post_meta(get_the_ID(), '_chef_facebook', true)); ?>" target="_blank"><i class="icon-facebook"></i></a>
                            <?php endif; ?>
                            <?php if (get_post_meta(get_the_ID(), '_chef_instagram', true)) : ?>
                            <a href="<?php echo esc_url(get_post_meta(get_the_ID(), '_chef_instagram', true)); ?>" target="_blank"><i class="icon-instagram"></i></a>
                            <?php endif; ?>
                            <?php if (get_post_meta(get_the_ID(), '_chef_twitter', true)) : ?>
                            <a href="<?php echo esc_url(get_post_meta(get_the_ID(), '_chef_twitter', true)); ?>" target="_blank"><i class="icon-twitter"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="member-info">
                        <h3><?php the_title(); ?></h3>
                        <p class="member-role"><?php echo esc_html(get_post_meta(get_the_ID(), '_chef_role', true)); ?></p>
                    </div>
                </div>
                <?php 
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>
    </section>
    
    <!-- Stats Section -->
    <section class="stats-section section-padding bg-primary text-white">
        <div class="container">
            <div class="stats-grid grid grid-4">
                <div class="stat-item text-center">
                    <div class="stat-number" data-count="<?php echo esc_attr(get_option('foodieland_recipes_count', '500')); ?>">0</div>
                    <p><?php _e('Recipes', 'foodieland'); ?></p>
                </div>
                <div class="stat-item text-center">
                    <div class="stat-number" data-count="<?php echo esc_attr(get_option('foodieland_users_count', '50000')); ?>">0</div>
                    <p><?php _e('Happy Users', 'foodieland'); ?></p>
                </div>
                <div class="stat-item text-center">
                    <div class="stat-number" data-count="<?php echo esc_attr(get_option('foodieland_countries_count', '80')); ?>">0</div>
                    <p><?php _e('Countries', 'foodieland'); ?></p>
                </div>
                <div class="stat-item text-center">
                    <div class="stat-number" data-count="<?php echo esc_attr(get_option('foodieland_awards_count', '15')); ?>">0</div>
                    <p><?php _e('Awards Won', 'foodieland'); ?></p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Testimonials Section -->
    <section class="testimonials-section section-padding">
        <div class="container">
            <div class="section-header text-center">
                <h2><?php _e('What Our Community Says', 'foodieland'); ?></h2>
            </div>
            <?php echo do_shortcode('[foodieland_testimonials limit="3"]'); ?>
        </div>
    </section>
    
    <!-- Partners Section -->
    <section class="partners-section section-padding bg-light">
        <div class="container">
            <div class="section-header text-center">
                <h2><?php _e('Our Partners', 'foodieland'); ?></h2>
            </div>
            <div class="partners-grid grid grid-6">
                <?php
                $partner_args = array(
                    'post_type' => 'partners',
                    'posts_per_page' => 6,
                );
                $partner_query = new WP_Query($partner_args);
                
                if ($partner_query->have_posts()) :
                    while ($partner_query->have_posts()) : $partner_query->the_post();
                ?>
                <div class="partner-logo">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('foodieland-square'); ?>
                    <?php else : ?>
                        <img src="<?php echo FOODIELAND_URI; ?>/assets/images/placeholder-partner.png" alt="<?php the_title_attribute(); ?>" />
                    <?php endif; ?>
                </div>
                <?php 
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="cta-section section-padding bg-primary text-white text-center">
        <div class="container">
            <h2><?php _e('Join Our Community', 'foodieland'); ?></h2>
            <p><?php _e('Subscribe to get exclusive recipes, cooking tips, and special offers!', 'foodieland'); ?></p>
            <?php echo do_shortcode('[foodieland_newsletter]'); ?>
        </div>
    </section>
    
    <?php endwhile; ?>
</div>

<script>
// Animate stats on scroll
document.addEventListener('DOMContentLoaded', function() {
    const statNumbers = document.querySelectorAll('.stat-number');
    
    const animateStats = () => {
        statNumbers.forEach(stat => {
            const rect = stat.getBoundingClientRect();
            if (rect.top < window.innerHeight && rect.bottom > 0) {
                const target = parseInt(stat.dataset.count);
                let current = 0;
                const increment = target / 50;
                
                const updateCount = () => {
                    if (current < target) {
                        current += increment;
                        stat.textContent = Math.ceil(current).toLocaleString();
                        setTimeout(updateCount, 40);
                    } else {
                        stat.textContent = target.toLocaleString();
                    }
                };
                
                updateCount();
                stat.classList.add('animated');
            }
        });
    };
    
    window.addEventListener('scroll', animateStats);
    animateStats(); // Check on load
});
</script>

<?php
get_footer();
