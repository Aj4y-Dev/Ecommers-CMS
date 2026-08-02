<?php
/**
 * Template Functions
 */

if (!defined('ABSPATH')) exit;

class Foodieland_Template_Functions {
    
    public function __construct() {
        add_shortcode('foodieland_recipes', array($this, 'recipes_shortcode'));
        add_shortcode('foodieland_products', array($this, 'products_shortcode'));
        add_shortcode('foodieland_testimonials', array($this, 'testimonials_shortcode'));
        add_shortcode('foodieland_newsletter', array($this, 'newsletter_shortcode'));
        add_filter('excerpt_length', array($this, 'custom_excerpt_length'), 999);
        add_filter('excerpt_more', array($this, 'custom_excerpt_more'));
    }
    
    public function recipes_shortcode($atts) {
        $atts = shortcode_atts(array(
            'limit' => 6,
            'category' => '',
            'columns' => 3,
        ), $atts);
        
        $args = array(
            'post_type' => 'recipe',
            'posts_per_page' => intval($atts['limit']),
            'post_status' => 'publish',
        );
        
        if ($atts['category']) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'recipe_category',
                    'field' => 'slug',
                    'terms' => $atts['category'],
                ),
            );
        }
        
        $query = new WP_Query($args);
        
        ob_start();
        if ($query->have_posts()) {
            echo '<div class="recipes-grid grid grid-' . esc_attr($atts['columns']) . '">';
            while ($query->have_posts()) {
                $query->the_post();
                get_template_part('template-parts/recipe', 'card');
            }
            echo '</div>';
            wp_reset_postdata();
        }
        return ob_get_clean();
    }
    
    public function products_shortcode($atts) {
        $atts = shortcode_atts(array(
            'limit' => 4,
            'columns' => 4,
        ), $atts);
        
        ob_start();
        echo do_shortcode('[products limit="' . esc_attr($atts['limit']) . '" columns="' . esc_attr($atts['columns']) . '"]');
        return ob_get_clean();
    }
    
    public function testimonials_shortcode($atts) {
        $atts = shortcode_atts(array(
            'limit' => 3,
        ), $atts);
        
        $args = array(
            'post_type' => 'testimonial',
            'posts_per_page' => intval($atts['limit']),
            'post_status' => 'publish',
        );
        
        $query = new WP_Query($args);
        
        ob_start();
        if ($query->have_posts()) {
            echo '<div class="testimonials-slider swiper">';
            echo '<div class="swiper-wrapper">';
            while ($query->have_posts()) {
                $query->the_post();
                get_template_part('template-parts/testimonial', 'card');
            }
            echo '</div>';
            echo '<div class="swiper-pagination"></div>';
            echo '<div class="swiper-button-next"></div>';
            echo '<div class="swiper-button-prev"></div>';
            echo '</div>';
            wp_reset_postdata();
        }
        return ob_get_clean();
    }
    
    public function newsletter_shortcode($atts) {
        $atts = shortcode_atts(array(
            'title' => __('Subscribe to our Newsletter', 'foodieland'),
            'description' => __('Get the latest recipes and updates delivered to your inbox.', 'foodieland'),
        ), $atts);
        
        ob_start();
        ?>
        <div class="newsletter-section" data-alpine="newsletterForm">
            <h3><?php echo esc_html($atts['title']); ?></h3>
            <p><?php echo esc_html($atts['description']); ?></p>
            <form class="newsletter-form" onsubmit="handleNewsletterSubmit(event)">
                <input type="email" name="email" placeholder="<?php _e('Enter your email', 'foodieland'); ?>" required />
                <button type="submit" class="btn btn-primary"><?php _e('Subscribe', 'foodieland'); ?></button>
            </form>
            <div class="newsletter-message"></div>
        </div>
        <?php
        return ob_get_clean();
    }
    
    public function custom_excerpt_length($length) {
        return 20;
    }
    
    public function custom_excerpt_more($more) {
        return '&hellip;';
    }
}

new Foodieland_Template_Functions();

// Helper functions
if (!function_exists('foodieland_get_recipe_meta')) {
    function foodieland_get_recipe_meta($post_id) {
        return array(
            'prep_time' => get_post_meta($post_id, '_recipe_prep_time', true),
            'cook_time' => get_post_meta($post_id, '_recipe_cook_time', true),
            'servings' => get_post_meta($post_id, '_recipe_servings', true),
            'difficulty' => get_post_meta($post_id, '_recipe_difficulty', true),
            'calories' => get_post_meta($post_id, '_recipe_calories', true),
            'rating' => get_post_meta($post_id, '_recipe_rating', true),
        );
    }
}

if (!function_exists('foodieland_breadcrumbs')) {
    function foodieland_breadcrumbs() {
        echo '<nav class="breadcrumbs" aria-label="Breadcrumb">';
        echo '<a href="' . esc_url(home_url('/')) . '">' . __('Home', 'foodieland') . '</a>';
        
        if (is_singular()) {
            global $post;
            $post_ancestors = get_post_ancestors($post);
            if ($post_ancestors) {
                $post_ancestors = array_reverse($post_ancestors);
                foreach ($post_ancestors as $ancestor) {
                    echo ' <span class="separator">/</span> <a href="' . esc_url(get_permalink($ancestor)) . '">' . esc_html(get_the_title($ancestor)) . '</a>';
                }
            }
            echo ' <span class="separator">/</span> <span class="current">' . esc_html(get_the_title()) . '</span>';
        } elseif (is_archive() || is_search()) {
            echo ' <span class="separator">/</span> <span class="current">' . get_the_archive_title() . '</span>';
        }
        
        echo '</nav>';
    }
}

if (!function_exists('foodieland_star_rating')) {
    function foodieland_star_rating($rating, $echo = true) {
        $html = '<div class="star-rating" role="img" aria-label="' . sprintf(__('%d out of 5 stars', 'foodieland'), $rating) . '">';
        for ($i = 1; $i <= 5; $i++) {
            $html .= $i <= $rating ? '<span class="star filled">★</span>' : '<span class="star">☆</span>';
        }
        $html .= '</div>';
        
        if ($echo) {
            echo $html;
        } else {
            return $html;
        }
    }
}

if (!function_exists('foodieland_format_time')) {
    function foodieland_format_time($minutes) {
        if ($minutes < 60) {
            return sprintf(_n('%d minute', '%d minutes', $minutes, 'foodieland'), $minutes);
        } else {
            $hours = floor($minutes / 60);
            $mins = $minutes % 60;
            if ($mins > 0) {
                return sprintf(_n('%d hour', '%d hours', $hours, 'foodieland') . ' %d ' . _n('minute', 'minutes', $mins, 'foodieland'), $hours, $mins);
            }
            return sprintf(_n('%d hour', '%d hours', $hours, 'foodieland'), $hours);
        }
    }
}
