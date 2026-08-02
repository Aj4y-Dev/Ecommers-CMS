<?php
/**
 * Single Post Template
 */
if (!defined('ABSPATH')) exit;

get_header();
?>

<div class="single-post-wrapper">
    <?php while (have_posts()) : the_post(); ?>
    
    <!-- Post Hero -->
    <section class="post-hero" style="background-image: url('<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'foodieland-hero')); ?>');">
        <div class="post-hero-overlay"></div>
        <div class="container">
            <div class="post-hero-content">
                <?php 
                $categories = get_the_category();
                if ($categories && !is_wp_error($categories)) :
                ?>
                <span class="post-category"><?php echo esc_html($categories[0]->name); ?></span>
                <?php endif; ?>
                
                <h1 class="post-title"><?php the_title(); ?></h1>
                
                <div class="post-meta">
                    <span><i class="icon-calendar"></i> <?php echo get_the_date(); ?></span>
                    <span><i class="icon-user"></i> <?php the_author(); ?></span>
                    <span><i class="icon-clock"></i> <?php _e('5 min read', 'foodieland'); ?></span>
                    <span><i class="icon-chat"></i> <?php comments_number(__('0 Comments', 'foodieland'), __('1 Comment', 'foodieland'), __('% Comments', 'foodieland')); ?></span>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Post Content -->
    <section class="post-content-section section-padding">
        <div class="container">
            <div class="post-content-grid">
                <article class="post-main-content">
                    <!-- Table of Contents -->
                    <div class="post-toc card mb-2">
                        <h3><?php _e('Table of Contents', 'foodieland'); ?></h3>
                        <div class="toc-container" id="toc-container"></div>
                    </div>
                    
                    <!-- Post Content -->
                    <div class="post-entry">
                        <?php the_content(); ?>
                    </div>
                    
                    <!-- Post Tags -->
                    <div class="post-tags mt-2">
                        <strong><?php _e('Tags:', 'foodieland'); ?></strong>
                        <?php the_tags('<span class="tag-links">', ', ', '</span>'); ?>
                    </div>
                    
                    <!-- Share Buttons -->
                    <div class="post-share">
                        <h4><?php _e('Share this article:', 'foodieland'); ?></h4>
                        <div class="share-buttons">
                            <a href="https://www.facebook.com/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="share-btn facebook">
                                <i class="icon-facebook"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="share-btn twitter">
                                <i class="icon-twitter"></i>
                            </a>
                            <a href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink()); ?>&media=<?php echo urlencode(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>&description=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="share-btn pinterest">
                                <i class="icon-pinterest"></i>
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(get_permalink()); ?>&title=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="share-btn linkedin">
                                <i class="icon-linkedin"></i>
                            </a>
                            <button class="share-btn copy-link" onclick="copyLink()">
                                <i class="icon-link"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Author Box -->
                    <div class="author-box card mt-2">
                        <div class="author-avatar">
                            <?php echo get_avatar(get_the_author_meta('ID'), 100, '', '', array('class' => 'avatar')); ?>
                        </div>
                        <div class="author-info">
                            <h4><?php the_author(); ?></h4>
                            <p><?php echo esc_html(get_the_author_meta('description')); ?></p>
                            <div class="author-social">
                                <?php if (get_the_author_meta('facebook')) : ?>
                                <a href="<?php echo esc_url(get_the_author_meta('facebook')); ?>" target="_blank"><i class="icon-facebook"></i></a>
                                <?php endif; ?>
                                <?php if (get_the_author_meta('twitter')) : ?>
                                <a href="<?php echo esc_url(get_the_author_meta('twitter')); ?>" target="_blank"><i class="icon-twitter"></i></a>
                                <?php endif; ?>
                                <?php if (get_the_author_meta('instagram')) : ?>
                                <a href="<?php echo esc_url(get_the_author_meta('instagram')); ?>" target="_blank"><i class="icon-instagram"></i></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Related Posts -->
                    <div class="related-posts mt-2">
                        <h3><?php _e('Related Articles', 'foodieland'); ?></h3>
                        <div class="related-posts-grid grid grid-3">
                            <?php
                            $categories = get_the_category();
                            $category_ids = array();
                            if ($categories && !is_wp_error($categories)) {
                                foreach ($categories as $cat) {
                                    $category_ids[] = $cat->term_id;
                                }
                            }
                            
                            $related_args = array(
                                'post_type' => 'post',
                                'posts_per_page' => 3,
                                'post__not_in' => array(get_the_ID()),
                                'category__in' => $category_ids,
                            );
                            
                            $related_query = new WP_Query($related_args);
                            
                            if ($related_query->have_posts()) :
                                while ($related_query->have_posts()) : $related_query->the_post();
                            ?>
                            <article class="related-post-card card">
                                <?php if (has_post_thumbnail()) : ?>
                                <div class="related-post-image">
                                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('foodieland-card'); ?></a>
                                </div>
                                <?php endif; ?>
                                <div class="related-post-content">
                                    <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                    <span class="post-date"><?php echo get_the_date(); ?></span>
                                </div>
                            </article>
                            <?php 
                                endwhile;
                                wp_reset_postdata();
                            else :
                                echo '<p>' . __('No related articles found.', 'foodieland') . '</p>';
                            endif;
                            ?>
                        </div>
                    </div>
                    
                    <!-- Comments -->
                    <?php 
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                    ?>
                </article>
                
                <!-- Sidebar -->
                <aside class="post-sidebar">
                    <!-- Search Widget -->
                    <div class="widget card">
                        <h4 class="widget-title"><?php _e('Search', 'foodieland'); ?></h4>
                        <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                            <input type="search" class="search-field" placeholder="<?php _e('Search...', 'foodieland'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                            <button type="submit" class="search-submit"><i class="icon-search"></i></button>
                        </form>
                    </div>
                    
                    <!-- Categories Widget -->
                    <div class="widget card mt-2">
                        <h4 class="widget-title"><?php _e('Categories', 'foodieland'); ?></h4>
                        <ul class="category-list">
                            <?php
                            $categories = get_categories(array(
                                'number' => 10,
                            ));
                            if ($categories && !is_wp_error($categories)) :
                                foreach ($categories as $category) :
                            ?>
                            <li>
                                <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                                    <?php echo esc_html($category->name); ?>
                                    <span>(<?php echo esc_html($category->count); ?>)</span>
                                </a>
                            </li>
                            <?php 
                                endforeach;
                            endif;
                            ?>
                        </ul>
                    </div>
                    
                    <!-- Recent Posts Widget -->
                    <div class="widget card mt-2">
                        <h4 class="widget-title"><?php _e('Recent Posts', 'foodieland'); ?></h4>
                        <?php
                        $recent_args = array(
                            'posts_per_page' => 5,
                            'post_status' => 'publish',
                        );
                        $recent_query = new WP_Query($recent_args);
                        
                        if ($recent_query->have_posts()) :
                            while ($recent_query->have_posts()) : $recent_query->the_post();
                        ?>
                        <div class="recent-post-item">
                            <?php if (has_post_thumbnail()) : ?>
                            <div class="recent-post-thumb">
                                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
                            </div>
                            <?php endif; ?>
                            <div class="recent-post-info">
                                <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                                <span class="post-date"><?php echo get_the_date(); ?></span>
                            </div>
                        </div>
                        <?php 
                            endwhile;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>
                    
                    <!-- Newsletter Widget -->
                    <div class="widget card mt-2 bg-primary text-white">
                        <h4 class="widget-title"><?php _e('Newsletter', 'foodieland'); ?></h4>
                        <p><?php _e('Subscribe to get the latest articles!', 'foodieland'); ?></p>
                        <?php echo do_shortcode('[foodieland_newsletter]'); ?>
                    </div>
                </aside>
            </div>
        </div>
    </section>
    
    <?php endwhile; ?>
</div>

<script>
// Generate Table of Contents
document.addEventListener('DOMContentLoaded', function() {
    const entry = document.querySelector('.post-entry');
    const tocContainer = document.getElementById('toc-container');
    
    if (entry && tocContainer) {
        const headings = entry.querySelectorAll('h2, h3');
        if (headings.length > 0) {
            let tocHTML = '<ul class="toc-list">';
            headings.forEach((heading, index) => {
                const id = 'heading-' + index;
                heading.id = id;
                const level = heading.tagName.toLowerCase() === 'h2' ? '' : 'sub';
                tocHTML += `<li class="${level}"><a href="#${id}">${heading.textContent}</a></li>`;
            });
            tocHTML += '</ul>';
            tocContainer.innerHTML = tocHTML;
        }
    }
});

// Copy Link Function
function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(function() {
        showToast('<?php _e('Link copied!', 'foodieland'); ?>');
    });
}
</script>

<?php
get_footer();
