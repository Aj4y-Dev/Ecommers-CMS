<?php
/**
 * Content None Template Part (No results found)
 */
if (!defined('ABSPATH')) exit;
?>

<article class="no-results card">
    <div class="no-results-content text-center">
        <i class="icon-content-empty"></i>
        <h2><?php _e('Nothing Found', 'foodieland'); ?></h2>
        
        <?php if (is_search()) : ?>
        <p><?php printf(__('Sorry, but nothing matched your search terms for "%s". Please try again with some different keywords.', 'foodieland'), get_search_query()); ?></p>
        
        <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
            <input type="search" class="search-field" placeholder="<?php _e('Search again...', 'foodieland'); ?>" value="" name="s" />
            <button type="submit" class="search-submit"><?php _e('Search', 'foodieland'); ?></button>
        </form>
        <?php else : ?>
        <p><?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'foodieland'); ?></p>
        
        <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
            <input type="search" class="search-field" placeholder="<?php _e('Search...', 'foodieland'); ?>" value="" name="s" />
            <button type="submit" class="search-submit"><?php _e('Search', 'foodieland'); ?></button>
        </form>
        <?php endif; ?>
    </div>
</article>
