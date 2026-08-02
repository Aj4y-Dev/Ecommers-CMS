<?php
/**
 * Header Template
 */
if (!defined('ABSPATH')) exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#primary"><?php _e('Skip to content', 'foodieland'); ?></a>

<header class="site-header" data-alpine="headerNav">
    <div class="header-top">
        <div class="container">
            <div class="header-top-content">
                <div class="contact-info">
                    <span><i class="icon-phone"></i> <?php echo esc_html(get_option('foodieland_phone', '+1 234 567 890')); ?></span>
                    <span><i class="icon-email"></i> <?php echo esc_html(get_option('foodieland_email', 'hello@foodieland.com')); ?></span>
                </div>
                <div class="header-actions">
                    <?php if (function_exists('is_woocommerce')) : ?>
                    <a href="<?php echo wc_get_cart_url(); ?>" class="cart-icon">
                        <i class="icon-cart"></i>
                        <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                    </a>
                    <?php endif; ?>
                    <button class="search-toggle" @click="searchOpen = !searchOpen">
                        <i class="icon-search"></i>
                    </button>
                    <?php if (is_user_logged_in()) : ?>
                    <a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>" class="account-link">
                        <i class="icon-user"></i>
                    </a>
                    <?php else : ?>
                    <a href="<?php echo wp_login_url(); ?>" class="login-link"><?php _e('Login', 'foodieland'); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="header-main">
        <div class="container">
            <div class="header-main-content">
                <div class="site-branding">
                    <?php if (has_custom_logo()) : ?>
                    <div class="custom-logo">
                        <?php the_custom_logo(); ?>
                    </div>
                    <?php else : ?>
                    <h1 class="site-title">
                        <a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
                    </h1>
                    <p class="site-description"><?php bloginfo('description'); ?></p>
                    <?php endif; ?>
                </div>
                
                <nav class="main-navigation" aria-label="<?php esc_attr_e('Primary Menu', 'foodieland'); ?>">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_class' => 'primary-menu',
                        'container' => false,
                        'fallback_cb' => false,
                        'walker' => new Foodieland_Walker_Nav_Menu(),
                    ));
                    ?>
                </nav>
                
                <button class="mobile-menu-toggle" @click="mobileMenuOpen = !mobileMenuOpen" aria-label="<?php _e('Toggle menu', 'foodieland'); ?>">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </div>
    
    <div class="mobile-menu" x-show="mobileMenuOpen" x-transition>
        <div class="mobile-menu-content">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'mobile',
                'menu_class' => 'mobile-menu-list',
                'container' => false,
            ));
            ?>
        </div>
    </div>
    
    <div class="search-overlay" x-show="searchOpen" x-transition>
        <div class="search-form-container">
            <button class="search-close" @click="searchOpen = false">&times;</button>
            <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                <input type="search" class="search-field" placeholder="<?php _e('Search recipes, products...', 'foodieland'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                <button type="submit" class="search-submit"><?php _e('Search', 'foodieland'); ?></button>
            </form>
        </div>
    </div>
</header>

<main id="primary" class="site-main">
