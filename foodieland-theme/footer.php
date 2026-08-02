<?php
/**
 * Footer Template
 */
if (!defined('ABSPATH')) exit;
?>
</main>

<footer class="site-footer">
    <div class="footer-main">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-widget" id="footer-1">
                    <?php if (is_active_sidebar('footer-1')) : ?>
                        <?php dynamic_sidebar('footer-1'); ?>
                    <?php else : ?>
                    <div class="footer-about">
                        <h5><?php bloginfo('name'); ?></h5>
                        <p><?php bloginfo('description'); ?></p>
                        <div class="social-links">
                            <a href="#" aria-label="Facebook"><i class="icon-facebook"></i></a>
                            <a href="#" aria-label="Twitter"><i class="icon-twitter"></i></a>
                            <a href="#" aria-label="Instagram"><i class="icon-instagram"></i></a>
                            <a href="#" aria-label="Pinterest"><i class="icon-pinterest"></i></a>
                            <a href="#" aria-label="YouTube"><i class="icon-youtube"></i></a>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="footer-widget" id="footer-2">
                    <?php if (is_active_sidebar('footer-2')) : ?>
                        <?php dynamic_sidebar('footer-2'); ?>
                    <?php else : ?>
                    <div class="footer-links">
                        <h5><?php _e('Quick Links', 'foodieland'); ?></h5>
                        <ul>
                            <li><a href="<?php echo esc_url(home_url('/about')); ?>"><?php _e('About Us', 'foodieland'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/recipes')); ?>"><?php _e('Recipes', 'foodieland'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/shop')); ?>"><?php _e('Shop', 'foodieland'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/blog')); ?>"><?php _e('Blog', 'foodieland'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/contact')); ?>"><?php _e('Contact', 'foodieland'); ?></a></li>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="footer-widget" id="footer-3">
                    <?php if (is_active_sidebar('footer-3')) : ?>
                        <?php dynamic_sidebar('footer-3'); ?>
                    <?php else : ?>
                    <div class="footer-contact">
                        <h5><?php _e('Contact Info', 'foodieland'); ?></h5>
                        <ul class="contact-list">
                            <li><i class="icon-location"></i> <?php echo esc_html(get_option('foodieland_address', '123 Food Street, NY 10001')); ?></li>
                            <li><i class="icon-phone"></i> <?php echo esc_html(get_option('foodieland_phone', '+1 234 567 890')); ?></li>
                            <li><i class="icon-email"></i> <?php echo esc_html(get_option('foodieland_email', 'hello@foodieland.com')); ?></li>
                            <li><i class="icon-clock"></i> <?php _e('Mon - Fri: 9AM - 6PM', 'foodieland'); ?></li>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="footer-widget" id="footer-4">
                    <?php if (is_active_sidebar('footer-4')) : ?>
                        <?php dynamic_sidebar('footer-4'); ?>
                    <?php else : ?>
                    <div class="footer-newsletter">
                        <h5><?php _e('Newsletter', 'foodieland'); ?></h5>
                        <p><?php _e('Subscribe to get latest updates!', 'foodieland'); ?></p>
                        <form class="newsletter-form" onsubmit="handleNewsletterSubmit(event)">
                            <input type="email" placeholder="<?php _e('Your email', 'foodieland'); ?>" required />
                            <button type="submit"><?php _e('Subscribe', 'foodieland'); ?></button>
                        </form>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-content">
                <p class="copyright">
                    &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php _e('All rights reserved.', 'foodieland'); ?>
                </p>
                <div class="footer-bottom-links">
                    <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>"><?php _e('Privacy Policy', 'foodieland'); ?></a>
                    <a href="<?php echo esc_url(home_url('/terms')); ?>"><?php _e('Terms of Service', 'foodieland'); ?></a>
                </div>
            </div>
        </div>
    </div>
</footer>

<div class="toast-container" data-alpine="toast"></div>

<?php wp_footer(); ?>
</body>
</html>
