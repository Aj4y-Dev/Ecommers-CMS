<?php
/**
 * Foodieland Theme Functions and Definitions
 *
 * @package Foodieland
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define theme constants
define('FOODIELAND_VERSION', '1.0.0');
define('FOODIELAND_DIR', get_template_directory());
define('FOODIELAND_URI', get_template_directory_uri());

/**
 * Foodieland Theme Class
 */
final class Foodieland_Theme {
    
    /**
     * Single instance of the class
     */
    private static $instance = null;
    
    /**
     * Get instance
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Constructor
     */
    private function __construct() {
        $this->setup_hooks();
        $this->load_files();
    }
    
    /**
     * Setup hooks
     */
    private function setup_hooks() {
        // Theme setup
        add_action('after_setup_theme', array($this, 'theme_setup'));
        
        // Enqueue scripts and styles
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
        
        // Register widget areas
        add_action('widgets_init', array($this, 'register_widget_areas'));
        
        // Add custom image sizes
        add_action('after_setup_theme', array($this, 'add_image_sizes'));
        
        // Remove unnecessary elements
        add_action('init', array($this, 'remove_unnecessary'));
        
        // Add body classes
        add_filter('body_class', array($this, 'add_body_classes'));
        
        // Preload fonts
        add_filter('style_loader_tag', array($this, 'preload_fonts'), 10, 2);
    }
    
    /**
     * Load required files
     */
    private function load_files() {
        // Include CPT registrations
        require_once FOODIELAND_DIR . '/inc/cpt/class-recipes.php';
        require_once FOODIELAND_DIR . '/inc/cpt/class-chefs.php';
        require_once FOODIELAND_DIR . '/inc/cpt/class-testimonials.php';
        require_once FOODIELAND_DIR . '/inc/cpt/class-faqs.php';
        require_once FOODIELAND_DIR . '/inc/cpt/class-partners.php';
        require_once FOODIELAND_DIR . '/inc/cpt/class-events.php';
        require_once FOODIELAND_DIR . '/inc/cpt/class-gallery.php';
        require_once FOODIELAND_DIR . '/inc/cpt/class-videos.php';
        
        // Include Taxonomy registrations
        require_once FOODIELAND_DIR . '/inc/taxonomies/class-recipe-taxonomies.php';
        
        // Include Custom Fields
        require_once FOODIELAND_DIR . '/inc/custom-fields/class-recipe-fields.php';
        
        // Include WooCommerce support
        require_once FOODIELAND_DIR . '/inc/class-woocommerce-support.php';
        
        // Include AJAX handlers
        require_once FOODIELAND_DIR . '/inc/class-ajax-handlers.php';
        
        // Include Walker classes
        require_once FOODIELAND_DIR . '/inc/class-walker-nav-menu.php';
        
        // Include template functions
        require_once FOODIELAND_DIR . '/inc/template-functions.php';
    }
    
    /**
     * Theme setup
     */
    public function theme_setup() {
        // Add default posts feed to RSS feeds
        add_feed('lastfm', function() {});
        
        // Make theme available for translation
        load_theme_textdomain('foodieland', FOODIELAND_DIR . '/languages');
        
        // Add default posts feed to RSS feeds
        add_theme_support('automatic-feed-links');
        
        // Let WordPress manage the document title
        add_theme_support('title-tag');
        
        // Enable support for Post Thumbnails
        add_theme_support('post-thumbnails');
        
        // Register nav menus
        register_nav_menus(array(
            'primary'   => __('Primary Menu', 'foodieland'),
            'mobile'    => __('Mobile Menu', 'foodieland'),
            'footer'    => __('Footer Menu', 'foodieland'),
            'social'    => __('Social Links Menu', 'foodieland'),
        ));
        
        // Switch default core markup for various elements to HTML5
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ));
        
        // Add support for core custom logo
        add_theme_support('custom-logo', array(
            'height'      => 60,
            'width'       => 200,
            'flex-width'  => true,
            'flex-height' => true,
        ));
        
        // Add support for custom background
        add_theme_support('custom-background');
        
        // Add support for custom header
        add_theme_support('custom-header', array(
            'default-image'      => '',
            'width'              => 1920,
            'height'             => 400,
            'flex-width'         => true,
            'flex-height'        => true,
        ));
        
        // Add support for responsive embeds
        add_theme_support('responsive-embeds');
        
        // Add support for wide alignment
        add_theme_support('align-wide');
        
        // Add support for editor styles
        add_theme_support('editor-styles');
        
        // Add WooCommerce support
        add_theme_support('woocommerce');
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');
        
        // Add Gutenberg support
        add_theme_support('wp-block-styles');
        add_theme_support('align-full');
        add_theme_support('align-wide');
        add_theme_support('responsive-embeds');
    }
    
    /**
     * Enqueue scripts and styles
     */
    public function enqueue_assets() {
        // Google Fonts
        wp_enqueue_style('google-fonts', 
            'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap',
            array(),
            null
        );
        
        // Tailwind CSS (CDN for development - use build process for production)
        // wp_enqueue_script('tailwindcss', 'https://cdn.tailwindcss.com', array(), '3.0', false);
        
        // Main stylesheet
        wp_enqueue_style('foodieland-style', 
            get_stylesheet_uri(), 
            array('google-fonts'), 
            FOODIELAND_VERSION
        );
        
        // Alpine.js
        wp_enqueue_script('alpinejs', 
            'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js', 
            array(), 
            '3.0', 
            true
        );
        
        // Swiper.js
        wp_enqueue_style('swiper-css', 
            'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css', 
            array(), 
            '10.0'
        );
        
        wp_enqueue_script('swiper-js', 
            'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js', 
            array(), 
            '10.0', 
            true
        );
        
        // Main JS
        wp_enqueue_script('foodieland-main', 
            FOODIELAND_URI . '/assets/js/main.js', 
            array('jquery', 'alpinejs', 'swiper-js'), 
            FOODIELAND_VERSION, 
            true
        );
        
        // Localize script
        wp_localize_script('foodieland-main', 'foodieland_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('foodieland_nonce'),
            'rest_url' => rest_url(),
        ));
        
        // Comment reply script
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
    }
    
    /**
     * Register widget areas
     */
    public function register_widget_areas() {
        register_sidebar(array(
            'name'          => __('Blog Sidebar', 'foodieland'),
            'id'            => 'blog-sidebar',
            'description'   => __('Widgets in this area will be shown on blog posts and archives.', 'foodieland'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>',
        ));
        
        register_sidebar(array(
            'name'          => __('Shop Sidebar', 'foodieland'),
            'id'            => 'shop-sidebar',
            'description'   => __('Widgets in this area will be shown on shop pages.', 'foodieland'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>',
        ));
        
        register_sidebar(array(
            'name'          => __('Footer 1', 'foodieland'),
            'id'            => 'footer-1',
            'description'   => __('First footer widget area.', 'foodieland'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h5 class="widget-title">',
            'after_title'   => '</h5>',
        ));
        
        register_sidebar(array(
            'name'          => __('Footer 2', 'foodieland'),
            'id'            => 'footer-2',
            'description'   => __('Second footer widget area.', 'foodieland'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h5 class="widget-title">',
            'after_title'   => '</h5>',
        ));
        
        register_sidebar(array(
            'name'          => __('Footer 3', 'foodieland'),
            'id'            => 'footer-3',
            'description'   => __('Third footer widget area.', 'foodieland'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h5 class="widget-title">',
            'after_title'   => '</h5>',
        ));
        
        register_sidebar(array(
            'name'          => __('Footer 4', 'foodieland'),
            'id'            => 'footer-4',
            'description'   => __('Fourth footer widget area.', 'foodieland'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h5 class="widget-title">',
            'after_title'   => '</h5>',
        ));
    }
    
    /**
     * Add custom image sizes
     */
    public function add_image_sizes() {
        add_image_size('foodieland-hero', 1920, 800, true);
        add_image_size('foodieland-card', 600, 400, true);
        add_image_size('foodieland-thumbnail', 300, 200, true);
        add_image_size('foodieland-square', 400, 400, true);
        add_image_size('foodieland-portrait', 600, 800, true);
        add_image_size('foodieland-landscape', 800, 500, true);
    }
    
    /**
     * Remove unnecessary elements
     */
    public function remove_unnecessary() {
        // Remove WP version from head
        remove_action('wp_head', 'wp_generator');
        
        // Remove WLW manifest
        remove_action('wp_head', 'wlwmanifest_link');
        
        // Remove RSD link
        remove_action('wp_head', 'rsd_link');
        
        // Remove shortlink
        remove_action('wp_head', 'wp_shortlink_wp_head');
        
        // Remove adjacent posts links
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
        
        // Remove emoji scripts
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_styles', 'print_emoji_styles');
        
        // Remove REST API links
        remove_action('wp_head', 'rest_output_link_wp_head', 10);
        
        // Remove oEmbed discovery links
        remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
        
        // Remove DNS prefetch
        remove_action('wp_head', 'wp_resource_hints', 2);
    }
    
    /**
     * Add body classes
     */
    public function add_body_classes($classes) {
        // Add slug to body class
        if (is_singular()) {
            global $post;
            $classes[] = 'single-' . $post->post_type . '-' . $post->post_name;
        }
        
        // Add browser classes
        global $is_ie, $is_iphone;
        if ($is_ie) {
            $classes[] = 'ie';
        }
        if ($is_iphone) {
            $classes[] = 'iphone';
        }
        
        return $classes;
    }
    
    /**
     * Preload fonts
     */
    public function preload_fonts($tag, $handle) {
        if ('google-fonts' === $handle) {
            $tag = str_replace(
                "rel='stylesheet'",
                "rel='preconnect' href='https://fonts.gstatic.com' crossorigin><link rel='stylesheet'",
                $tag
            );
        }
        return $tag;
    }
}

// Initialize the theme
Foodieland_Theme::get_instance();
