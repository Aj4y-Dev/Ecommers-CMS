<?php
/**
 * AJAX Handlers
 */

if (!defined('ABSPATH')) exit;

class Foodieland_Ajax_Handlers {
    
    public function __construct() {
        // Wishlist functionality
        add_action('wp_ajax_add_to_wishlist', array($this, 'add_to_wishlist'));
        add_action('wp_ajax_nopriv_add_to_wishlist', array($this, 'add_to_wishlist'));
        
        add_action('wp_ajax_remove_from_wishlist', array($this, 'remove_from_wishlist'));
        add_action('wp_ajax_nopriv_remove_from_wishlist', array($this, 'remove_from_wishlist'));
        
        // Recipe favorites
        add_action('wp_ajax_toggle_recipe_favorite', array($this, 'toggle_recipe_favorite'));
        add_action('wp_ajax_nopriv_toggle_recipe_favorite', array($this, 'toggle_recipe_favorite'));
        
        // Newsletter subscription
        add_action('wp_ajax_subscribe_newsletter', array($this, 'subscribe_newsletter'));
        add_action('wp_ajax_nopriv_subscribe_newsletter', array($this, 'subscribe_newsletter'));
        
        // Quick view product
        add_action('wp_ajax_quick_view_product', array($this, 'quick_view_product'));
        add_action('wp_ajax_nopriv_quick_view_product', array($this, 'quick_view_product'));
        
        // Contact form
        add_action('wp_ajax_send_contact_message', array($this, 'send_contact_message'));
        add_action('wp_ajax_nopriv_send_contact_message', array($this, 'send_contact_message'));
        
        // Search recipes
        add_action('wp_ajax_search_recipes', array($this, 'search_recipes'));
        add_action('wp_ajax_nopriv_search_recipes', array($this, 'search_recipes'));
    }
    
    public function add_to_wishlist() {
        check_ajax_referer('foodieland_nonce', 'nonce');
        
        $product_id = intval($_POST['product_id']);
        
        if (!$product_id) {
            wp_send_json_error(array('message' => __('Invalid product ID', 'foodieland')));
        }
        
        $wishlist = WC()->session->get('wishlist', array());
        
        if (!in_array($product_id, $wishlist)) {
            $wishlist[] = $product_id;
            WC()->session->set('wishlist', $wishlist);
            wp_send_json_success(array(
                'message' => __('Added to wishlist!', 'foodieland'),
                'count' => count($wishlist)
            ));
        } else {
            wp_send_json_error(array('message' => __('Already in wishlist', 'foodieland')));
        }
    }
    
    public function remove_from_wishlist() {
        check_ajax_referer('foodieland_nonce', 'nonce');
        
        $product_id = intval($_POST['product_id']);
        $wishlist = WC()->session->get('wishlist', array());
        
        $key = array_search($product_id, $wishlist);
        if ($key !== false) {
            unset($wishlist[$key]);
            WC()->session->set('wishlist', array_values($wishlist));
            wp_send_json_success(array(
                'message' => __('Removed from wishlist', 'foodieland'),
                'count' => count($wishlist)
            ));
        } else {
            wp_send_json_error(array('message' => __('Not in wishlist', 'foodieland')));
        }
    }
    
    public function toggle_recipe_favorite() {
        check_ajax_referer('foodieland_nonce', 'nonce');
        
        $recipe_id = intval($_POST['recipe_id']);
        $user_id = get_current_user_id();
        
        if (!$user_id) {
            $favorites = isset($_COOKIE['foodieland_favorites']) ? json_decode(stripslashes($_COOKIE['foodieland_favorites']), true) : array();
        } else {
            $favorites = get_user_meta($user_id, '_recipe_favorites', true);
            if (!is_array($favorites)) $favorites = array();
        }
        
        if (in_array($recipe_id, $favorites)) {
            $key = array_search($recipe_id, $favorites);
            unset($favorites[$key]);
            $action = 'removed';
        } else {
            $favorites[] = $recipe_id;
            $action = 'added';
        }
        
        if (!$user_id) {
            setcookie('foodieland_favorites', json_encode($favorites), time() + (30 * DAY_IN_SECONDS), '/');
        } else {
            update_user_meta($user_id, '_recipe_favorites', $favorites);
        }
        
        wp_send_json_success(array(
            'action' => $action,
            'count' => count($favorites)
        ));
    }
    
    public function subscribe_newsletter() {
        check_ajax_referer('foodieland_nonce', 'nonce');
        
        $email = sanitize_email($_POST['email']);
        
        if (!is_email($email)) {
            wp_send_json_error(array('message' => __('Please enter a valid email', 'foodieland')));
        }
        
        // Store subscriber (in production, integrate with email service)
        $subscribers = get_option('foodieland_newsletter_subscribers', array());
        if (!in_array($email, $subscribers)) {
            $subscribers[] = $email;
            update_option('foodieland_newsletter_subscribers', $subscribers);
            
            // Send confirmation email
            wp_mail(
                $email,
                __('Welcome to Foodieland Newsletter!', 'foodieland'),
                __('Thank you for subscribing to our newsletter!', 'foodieland')
            );
            
            wp_send_json_success(array('message' => __('Successfully subscribed!', 'foodieland')));
        } else {
            wp_send_json_error(array('message' => __('Email already subscribed', 'foodieland')));
        }
    }
    
    public function quick_view_product() {
        check_ajax_referer('foodieland_nonce', 'nonce');
        
        $product_id = intval($_POST['product_id']);
        $product = wc_get_product($product_id);
        
        if (!$product) {
            wp_send_json_error(array('message' => __('Product not found', 'foodieland')));
        }
        
        ob_start();
        ?>
        <div class="quick-view-product">
            <div class="product-image">
                <?php echo $product->get_image('large'); ?>
            </div>
            <div class="product-details">
                <h3><?php echo esc_html($product->get_name()); ?></h3>
                <p class="price"><?php echo $product->get_price_html(); ?></p>
                <div class="product-description">
                    <?php echo wpautop(esc_html($product->get_short_description())); ?>
                </div>
                <?php if ($product->is_in_stock()) : ?>
                    <button class="btn btn-primary add-to-cart" data-product-id="<?php echo $product_id; ?>">
                        <?php _e('Add to Cart', 'foodieland'); ?>
                    </button>
                <?php else : ?>
                    <span class="out-of-stock"><?php _e('Out of Stock', 'foodieland'); ?></span>
                <?php endif; ?>
            </div>
        </div>
        <?php
        $html = ob_get_clean();
        
        wp_send_json_success(array('html' => $html));
    }
    
    public function send_contact_message() {
        check_ajax_referer('foodieland_nonce', 'nonce');
        
        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);
        $subject = sanitize_text_field($_POST['subject']);
        $message = sanitize_textarea_field($_POST['message']);
        
        if (empty($name) || empty($email) || empty($message)) {
            wp_send_json_error(array('message' => __('All fields are required', 'foodieland')));
        }
        
        if (!is_email($email)) {
            wp_send_json_error(array('message' => __('Invalid email address', 'foodieland')));
        }
        
        $to = get_option('admin_email');
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $headers[] = 'Reply-To: ' . $email;
        
        $body = sprintf(
            '<p><strong>Name:</strong> %s</p><p><strong>Email:</strong> %s</p><p><strong>Subject:</strong> %s</p><p><strong>Message:</strong></p><p>%s</p>',
            $name, $email, $subject, nl2br($message)
        );
        
        if (wp_mail($to, '[Foodieland] ' . $subject, $body, $headers)) {
            wp_send_json_success(array('message' => __('Message sent successfully!', 'foodieland')));
        } else {
            wp_send_json_error(array('message' => __('Failed to send message', 'foodieland')));
        }
    }
    
    public function search_recipes() {
        check_ajax_referer('foodieland_nonce', 'nonce');
        
        $query = sanitize_text_field($_POST['query']);
        $category = sanitize_text_field($_POST['category']);
        $difficulty = sanitize_text_field($_POST['difficulty']);
        
        $args = array(
            'post_type' => 'recipe',
            'posts_per_page' => 6,
            's' => $query,
        );
        
        if ($category) {
            $args['tax_query'][] = array(
                'taxonomy' => 'recipe_category',
                'field' => 'slug',
                'terms' => $category,
            );
        }
        
        if ($difficulty) {
            $args['tax_query'][] = array(
                'taxonomy' => 'difficulty',
                'field' => 'slug',
                'terms' => $difficulty,
            );
        }
        
        $recipes = new WP_Query($args);
        
        if ($recipes->have_posts()) {
            ob_start();
            while ($recipes->have_posts()) {
                $recipes->the_post();
                get_template_part('template-parts/recipe', 'card');
            }
            $html = ob_get_clean();
            wp_send_json_success(array('html' => $html));
        } else {
            wp_send_json_error(array('message' => __('No recipes found', 'foodieland')));
        }
    }
}

new Foodieland_Ajax_Handlers();
