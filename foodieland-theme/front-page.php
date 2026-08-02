<?php
/**
 * Front Page Template (Homepage)
 */
if (!defined('ABSPATH')) exit;

get_header();
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-slider swiper">
        <div class="swiper-wrapper">
            <?php
            $hero_args = array(
                'post_type' => 'recipe',
                'posts_per_page' => 5,
                'meta_key' => '_recipe_featured',
                'meta_value' => '1',
            );
            $hero_query = new WP_Query($hero_args);
            
            if ($hero_query->have_posts()) :
                while ($hero_query->have_posts()) : $hero_query->the_post();
            ?>
            <div class="hero-slide swiper-slide" style="background-image: url('<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'foodieland-hero')); ?>');">
                <div class="hero-overlay"></div>
                <div class="container">
                    <div class="hero-content">
                        <span class="hero-category"><?php echo esc_html(get_the_terms(get_the_ID(), 'recipe_category')[0]->name ?? ''); ?></span>
                        <h1 class="hero-title"><?php the_title(); ?></h1>
                        <p class="hero-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 20)); ?></p>
                        <div class="hero-meta">
                            <span><i class="icon-time"></i> <?php echo esc_html(foodieland_format_time(get_post_meta(get_the_ID(), '_recipe_prep_time', true) + get_post_meta(get_the_ID(), '_recipe_cook_time', true))); ?></span>
                            <span><i class="icon-star"></i> <?php foodieland_star_rating(get_post_meta(get_the_ID(), '_recipe_rating', true)); ?></span>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="btn btn-primary"><?php _e('View Recipe', 'foodieland'); ?></a>
                    </div>
                </div>
            </div>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</section>

<!-- Categories Section -->
<section class="categories-section section-padding">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title"><?php _e('Browse by Category', 'foodieland'); ?></h2>
            <p class="section-subtitle"><?php _e('Find your favorite recipes', 'foodieland'); ?></p>
        </div>
        <div class="categories-grid grid grid-4">
            <?php
            $categories = get_terms(array(
                'taxonomy' => 'recipe_category',
                'hide_empty' => true,
                'number' => 8,
            ));
            
            if ($categories && !is_wp_error($categories)) :
                foreach ($categories as $category) :
            ?>
            <a href="<?php echo esc_url(get_term_link($category)); ?>" class="category-card card">
                <div class="category-icon">
                    <i class="icon-<?php echo esc_attr($category->slug); ?>"></i>
                </div>
                <h3 class="category-name"><?php echo esc_html($category->name); ?></h3>
                <span class="category-count"><?php echo esc_html($category->count); ?> <?php _e('Recipes', 'foodieland'); ?></span>
            </a>
            <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>
</section>

<!-- Featured Recipes Section -->
<section class="featured-recipes section-padding bg-light">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title"><?php _e('Featured Recipes', 'foodieland'); ?></h2>
            <p class="section-subtitle"><?php _e('Hand-picked delicious recipes', 'foodieland'); ?></p>
        </div>
        <div class="recipes-grid grid grid-3">
            <?php echo do_shortcode('[foodieland_recipes limit="6" columns="3"]'); ?>
        </div>
        <div class="text-center mt-2">
            <a href="<?php echo esc_url(get_post_type_archive_link('recipe')); ?>" class="btn btn-outline"><?php _e('View All Recipes', 'foodieland'); ?></a>
        </div>
    </div>
</section>

<!-- Popular Recipes Section -->
<section class="popular-recipes section-padding">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title"><?php _e('Popular This Week', 'foodieland'); ?></h2>
            <p class="section-subtitle"><?php _e('Most viewed recipes', 'foodieland'); ?></p>
        </div>
        <div class="recipes-grid grid grid-3">
            <?php
            $popular_args = array(
                'post_type' => 'recipe',
                'posts_per_page' => 6,
                'meta_key' => '_recipe_views',
                'orderby' => 'meta_value_num',
                'order' => 'DESC',
            );
            $popular_query = new WP_Query($popular_args);
            
            if ($popular_query->have_posts()) :
                while ($popular_query->have_posts()) : $popular_query->the_post();
                    get_template_part('template-parts/recipe', 'card');
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<?php if (function_exists('is_woocommerce')) : ?>
<section class="featured-products section-padding bg-light">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title"><?php _e('Featured Products', 'foodieland'); ?></h2>
            <p class="section-subtitle"><?php _e('Shop our curated selection', 'foodieland'); ?></p>
        </div>
        <?php echo do_shortcode('[products limit="4" columns="4" visibility="featured"]'); ?>
    </div>
</section>
<?php endif; ?>

<!-- Testimonials Section -->
<section class="testimonials-section section-padding">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title"><?php _e('What Our Users Say', 'foodieland'); ?></h2>
        </div>
        <?php echo do_shortcode('[foodieland_testimonials limit="3"]'); ?>
    </div>
</section>

<!-- Newsletter Section -->
<section class="newsletter-section section-padding bg-primary">
    <div class="container">
        <div class="newsletter-content text-center">
            <h2><?php _e('Subscribe to Our Newsletter', 'foodieland'); ?></h2>
            <p><?php _e('Get the latest recipes and cooking tips delivered to your inbox!', 'foodieland'); ?></p>
            <?php echo do_shortcode('[foodieland_newsletter]'); ?>
        </div>
    </div>
</section>

<?php
get_footer();
