<?php
/**
 * Contact Page Template
 */
if (!defined('ABSPATH')) exit;

get_header();
?>

<div class="contact-page-wrapper">
    <?php while (have_posts()) : the_post(); ?>
    
    <!-- Page Header -->
    <section class="page-header-section section-padding bg-light">
        <div class="container">
            <h1 class="page-title"><?php the_title(); ?></h1>
            <?php if (get_the_excerpt()) : ?>
            <p class="page-excerpt"><?php echo esc_html(get_the_excerpt()); ?></p>
            <?php endif; ?>
        </div>
    </section>
    
    <!-- Contact Content -->
    <section class="contact-content-section section-padding">
        <div class="container">
            <div class="contact-grid">
                <!-- Contact Form -->
                <div class="contact-form-wrapper">
                    <h2><?php _e('Send us a Message', 'foodieland'); ?></h2>
                    <form class="contact-form" method="post" action="" data-alpine="contactForm">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name"><?php _e('Your Name', 'foodieland'); ?> *</label>
                                <input type="text" id="name" name="name" required x-model="formData.name" />
                            </div>
                            <div class="form-group">
                                <label for="email"><?php _e('Email Address', 'foodieland'); ?> *</label>
                                <input type="email" id="email" name="email" required x-model="formData.email" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="phone"><?php _e('Phone Number', 'foodieland'); ?></label>
                                <input type="tel" id="phone" name="phone" x-model="formData.phone" />
                            </div>
                            <div class="form-group">
                                <label for="subject"><?php _e('Subject', 'foodieland'); ?> *</label>
                                <input type="text" id="subject" name="subject" required x-model="formData.subject" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="message"><?php _e('Message', 'foodieland'); ?> *</label>
                            <textarea id="message" name="message" rows="6" required x-model="formData.message"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="privacy" required />
                                <span><?php printf(__('I agree to the <a href="%s">Privacy Policy</a>', 'foodieland'), esc_url(home_url('/privacy-policy'))); ?></span>
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary" :disabled="submitting">
                            <span x-show="!submitting"><?php _e('Send Message', 'foodieland'); ?></span>
                            <span x-show="submitting"><?php _e('Sending...', 'foodieland'); ?></span>
                        </button>
                    </form>
                </div>
                
                <!-- Contact Info -->
                <div class="contact-info-wrapper">
                    <h2><?php _e('Contact Information', 'foodieland'); ?></h2>
                    
                    <div class="contact-info-card card">
                        <div class="info-item">
                            <i class="icon-location"></i>
                            <div>
                                <h4><?php _e('Address', 'foodieland'); ?></h4>
                                <p><?php echo esc_html(get_option('foodieland_address', '123 Food Street, New York, NY 10001')); ?></p>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="icon-phone"></i>
                            <div>
                                <h4><?php _e('Phone', 'foodieland'); ?></h4>
                                <p><a href="tel:<?php echo esc_attr(get_option('foodieland_phone', '+1234567890')); ?>"><?php echo esc_html(get_option('foodieland_phone', '+1 234 567 890')); ?></a></p>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="icon-email"></i>
                            <div>
                                <h4><?php _e('Email', 'foodieland'); ?></h4>
                                <p><a href="mailto:<?php echo esc_attr(get_option('foodieland_email', 'hello@foodieland.com')); ?>"><?php echo esc_html(get_option('foodieland_email', 'hello@foodieland.com')); ?></a></p>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="icon-clock"></i>
                            <div>
                                <h4><?php _e('Opening Hours', 'foodieland'); ?></h4>
                                <p><?php _e('Monday - Friday: 9:00 AM - 6:00 PM', 'foodieland'); ?></p>
                                <p><?php _e('Saturday: 10:00 AM - 4:00 PM', 'foodieland'); ?></p>
                                <p><?php _e('Sunday: Closed', 'foodieland'); ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Social Links -->
                    <div class="social-links-card card mt-2">
                        <h3><?php _e('Follow Us', 'foodieland'); ?></h3>
                        <div class="social-links">
                            <a href="<?php echo esc_url(get_option('foodieland_facebook', '#')); ?>" target="_blank" aria-label="Facebook">
                                <i class="icon-facebook"></i>
                            </a>
                            <a href="<?php echo esc_url(get_option('foodieland_twitter', '#')); ?>" target="_blank" aria-label="Twitter">
                                <i class="icon-twitter"></i>
                            </a>
                            <a href="<?php echo esc_url(get_option('foodieland_instagram', '#')); ?>" target="_blank" aria-label="Instagram">
                                <i class="icon-instagram"></i>
                            </a>
                            <a href="<?php echo esc_url(get_option('foodieland_pinterest', '#')); ?>" target="_blank" aria-label="Pinterest">
                                <i class="icon-pinterest"></i>
                            </a>
                            <a href="<?php echo esc_url(get_option('foodieland_youtube', '#')); ?>" target="_blank" aria-label="YouTube">
                                <i class="icon-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Google Maps -->
    <?php if ($map_embed = get_option('foodieland_map_embed')) : ?>
    <section class="contact-map-section">
        <div class="map-container">
            <?php echo wp_kses_post($map_embed); ?>
        </div>
    </section>
    <?php endif; ?>
    
    <!-- FAQ Section -->
    <section class="contact-faq-section section-padding bg-light">
        <div class="container">
            <h2 class="section-title text-center"><?php _e('Frequently Asked Questions', 'foodieland'); ?></h2>
            <div class="faq-grid">
                <?php
                $faq_args = array(
                    'post_type' => 'faqs',
                    'posts_per_page' => 6,
                );
                $faq_query = new WP_Query($faq_args);
                
                if ($faq_query->have_posts()) :
                    while ($faq_query->have_posts()) : $faq_query->the_post();
                ?>
                <div class="faq-item card" data-aline="faqItem">
                    <button class="faq-question" @click="open = !open">
                        <h4><?php the_title(); ?></h4>
                        <i class="icon-plus" :class="{ 'active': open }"></i>
                    </button>
                    <div class="faq-answer" x-show="open" x-collapse>
                        <?php the_content(); ?>
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
    
    <?php endwhile; ?>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('contactForm', () => ({
        formData: {
            name: '',
            email: '',
            phone: '',
            subject: '',
            message: ''
        },
        submitting: false,
        async submit() {
            this.submitting = true;
            
            try {
                const response = await fetch(foodieland_ajax.ajax_url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        action: 'send_contact_message',
                        nonce: foodieland_ajax.nonce,
                        ...this.formData
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showToast('<?php _e('Message sent successfully!', 'foodieland'); ?>', 'success');
                    this.formData = { name: '', email: '', phone: '', subject: '', message: '' };
                } else {
                    showToast(data.data.message || '<?php _e('Something went wrong. Please try again.', 'foodieland'); ?>', 'error');
                }
            } catch (error) {
                showToast('<?php _e('An error occurred. Please try again.', 'foodieland'); ?>', 'error');
            } finally {
                this.submitting = false;
            }
        }
    }));
});
</script>

<?php
get_footer();
