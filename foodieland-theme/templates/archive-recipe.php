<?php
/**
 * Recipe Archive Template
 */
if (!defined('ABSPATH')) exit;

get_header();
?>

<div class="recipe-archive-wrapper">
    <!-- Archive Header -->
    <section class="archive-header-section section-padding bg-light">
        <div class="container">
            <h1 class="archive-title">
                <?php 
                if (is_post_type_archive('recipe')) {
                    _e('All Recipes', 'foodieland');
                } elseif (is_tax()) {
                    single_term_title('', true);
                }
                ?>
            </h1>
            <?php 
            $archive_description = term_description() ?: get_post_type_archive('recipe', 'description');
            if ($archive_description) :
            ?>
            <p class="archive-description"><?php echo wp_kses_post($archive_description); ?></p>
            <?php endif; ?>
        </div>
    </section>
    
    <!-- Recipe Filters and Grid -->
    <section class="recipes-filter-section section-padding">
        <div class="container">
            <div class="recipes-filter-grid" data-alpine="recipeFilter">
                <!-- Sidebar Filters -->
                <aside class="recipes-sidebar">
                    <div class="filter-card card">
                        <h3><?php _e('Filters', 'foodieland'); ?></h3>
                        
                        <!-- Search -->
                        <div class="filter-group">
                            <label><?php _e('Search', 'foodieland'); ?></label>
                            <input type="text" x-model="searchQuery" placeholder="<?php _e('Search recipes...', 'foodieland'); ?>" class="filter-input" />
                        </div>
                        
                        <!-- Category Filter -->
                        <div class="filter-group">
                            <label><?php _e('Category', 'foodieland'); ?></label>
                            <select x-model="selectedCategory" class="filter-select">
                                <option value=""><?php _e('All Categories', 'foodieland'); ?></option>
                                <?php
                                $categories = get_terms(array(
                                    'taxonomy' => 'recipe_category',
                                    'hide_empty' => true,
                                ));
                                if ($categories && !is_wp_error($categories)) :
                                    foreach ($categories as $category) :
                                ?>
                                <option value="<?php echo esc_attr($category->slug); ?>"><?php echo esc_html($category->name); ?></option>
                                <?php 
                                    endforeach;
                                endif;
                                ?>
                            </select>
                        </div>
                        
                        <!-- Cuisine Filter -->
                        <div class="filter-group">
                            <label><?php _e('Cuisine', 'foodieland'); ?></label>
                            <select x-model="selectedCuisine" class="filter-select">
                                <option value=""><?php _e('All Cuisines', 'foodieland'); ?></option>
                                <?php
                                $cuisines = get_terms(array(
                                    'taxonomy' => 'cuisine',
                                    'hide_empty' => true,
                                ));
                                if ($cuisines && !is_wp_error($cuisines)) :
                                    foreach ($cuisines as $cuisine) :
                                ?>
                                <option value="<?php echo esc_attr($cuisine->slug); ?>"><?php echo esc_html($cuisine->name); ?></option>
                                <?php 
                                    endforeach;
                                endif;
                                ?>
                            </select>
                        </div>
                        
                        <!-- Difficulty Filter -->
                        <div class="filter-group">
                            <label><?php _e('Difficulty', 'foodieland'); ?></label>
                            <select x-model="selectedDifficulty" class="filter-select">
                                <option value=""><?php _e('All Difficulties', 'foodieland'); ?></option>
                                <?php
                                $difficulties = get_terms(array(
                                    'taxonomy' => 'difficulty',
                                    'hide_empty' => true,
                                ));
                                if ($difficulties && !is_wp_error($difficulties)) :
                                    foreach ($difficulties as $difficulty) :
                                ?>
                                <option value="<?php echo esc_attr($difficulty->slug); ?>"><?php echo esc_html($difficulty->name); ?></option>
                                <?php 
                                    endforeach;
                                endif;
                                ?>
                            </select>
                        </div>
                        
                        <!-- Meal Type Filter -->
                        <div class="filter-group">
                            <label><?php _e('Meal Type', 'foodieland'); ?></label>
                            <select x-model="selectedMealType" class="filter-select">
                                <option value=""><?php _e('All Meal Types', 'foodieland'); ?></option>
                                <?php
                                $meal_types = get_terms(array(
                                    'taxonomy' => 'meal_type',
                                    'hide_empty' => true,
                                ));
                                if ($meal_types && !is_wp_error($meal_types)) :
                                    foreach ($meal_types as $meal_type) :
                                ?>
                                <option value="<?php echo esc_attr($meal_type->slug); ?>"><?php echo esc_html($meal_type->name); ?></option>
                                <?php 
                                    endforeach;
                                endif;
                                ?>
                            </select>
                        </div>
                        
                        <!-- Diet Filter -->
                        <div class="filter-group">
                            <label><?php _e('Diet', 'foodieland'); ?></label>
                            <select x-model="selectedDiet" class="filter-select">
                                <option value=""><?php _e('All Diets', 'foodieland'); ?></option>
                                <?php
                                $diets = get_terms(array(
                                    'taxonomy' => 'diet',
                                    'hide_empty' => true,
                                ));
                                if ($diets && !is_wp_error($diets)) :
                                    foreach ($diets as $diet) :
                                ?>
                                <option value="<?php echo esc_attr($diet->slug); ?>"><?php echo esc_html($diet->name); ?></option>
                                <?php 
                                    endforeach;
                                endif;
                                ?>
                            </select>
                        </div>
                        
                        <!-- Time Filter -->
                        <div class="filter-group">
                            <label><?php _e('Max Time (minutes)', 'foodieland'); ?></label>
                            <input type="range" x-model="maxTime" min="0" max="180" step="15" class="filter-range" />
                            <span x-text="maxTime + ' min'"></span>
                        </div>
                        
                        <!-- Reset Button -->
                        <button @click="resetFilters()" class="btn btn-outline btn-block">
                            <?php _e('Reset Filters', 'foodieland'); ?>
                        </button>
                    </div>
                    
                    <!-- Popular Tags -->
                    <div class="tags-card card mt-2">
                        <h3><?php _e('Popular Tags', 'foodieland'); ?></h3>
                        <div class="tags-cloud">
                            <?php
                            $tags = get_terms(array(
                                'taxonomy' => 'ingredient',
                                'hide_empty' => true,
                                'number' => 20,
                            ));
                            if ($tags && !is_wp_error($tags)) :
                                foreach ($tags as $tag) :
                            ?>
                            <a href="<?php echo esc_url(get_term_link($tag)); ?>" class="tag-link"><?php echo esc_html($tag->name); ?></a>
                            <?php 
                                endforeach;
                            endif;
                            ?>
                        </div>
                    </div>
                </aside>
                
                <!-- Recipe Grid -->
                <div class="recipes-main-content">
                    <!-- Toolbar -->
                    <div class="recipes-toolbar">
                        <div class="recipes-count">
                            <span x-text="recipeCount"></span> <?php _e('recipes found', 'foodieland'); ?>
                        </div>
                        <div class="recipes-view-toggle">
                            <button @click="viewMode = 'grid'" :class="{ active: viewMode === 'grid' }">
                                <i class="icon-grid"></i>
                            </button>
                            <button @click="viewMode = 'list'" :class="{ active: viewMode === 'list' }">
                                <i class="icon-list"></i>
                            </button>
                        </div>
                        <div class="recipes-sort">
                            <select x-model="sortBy" class="sort-select">
                                <option value="date"><?php _e('Newest', 'foodieland'); ?></option>
                                <option value="rating"><?php _e('Highest Rated', 'foodieland'); ?></option>
                                <option value="views"><?php _e('Most Viewed', 'foodieland'); ?></option>
                                <option value="time_asc"><?php _e('Quickest', 'foodieland'); ?></option>
                                <option value="time_desc"><?php _e('Longest', 'foodieland'); ?></option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Loading State -->
                    <div x-show="loading" class="recipes-loading">
                        <div class="skeleton-card"></div>
                        <div class="skeleton-card"></div>
                        <div class="skeleton-card"></div>
                        <div class="skeleton-card"></div>
                        <div class="skeleton-card"></div>
                        <div class="skeleton-card"></div>
                    </div>
                    
                    <!-- Recipe Grid -->
                    <div x-show="!loading" :class="['recipes-grid', 'grid', 'grid-3', viewMode === 'list' ? 'list-view' : '']">
                        <template x-for="recipe in filteredRecipes" :key="recipe.id">
                            <div class="recipe-card card" :class="viewMode === 'list' ? 'list-card' : ''">
                                <div class="recipe-card-image">
                                    <a :href="recipe.url">
                                        <img :src="recipe.image" :alt="recipe.title" loading="lazy" />
                                    </a>
                                    <button class="favorite-btn" @click="toggleFavorite(recipe.id)" :class="{ active: isFavorite(recipe.id) }">
                                        <i class="icon-heart"></i>
                                    </button>
                                    <span class="recipe-badge" x-text="recipe.difficulty"></span>
                                </div>
                                <div class="recipe-card-content">
                                    <div class="recipe-card-category" x-text="recipe.category"></div>
                                    <h3 class="recipe-card-title">
                                        <a :href="recipe.url" x-text="recipe.title"></a>
                                    </h3>
                                    <div class="recipe-card-meta">
                                        <span><i class="icon-time"></i> <span x-text="recipe.time"></span></span>
                                        <span><i class="icon-star"></i> <span x-text="recipe.rating"></span></span>
                                        <span><i class="icon-fire"></i> <span x-text="recipe.calories + ' kcal'"></span></span>
                                    </div>
                                    <p class="recipe-card-excerpt" x-show="viewMode === 'list'" x-text="recipe.excerpt"></p>
                                    <a :href="recipe.url" class="btn btn-primary btn-sm"><?php _e('View Recipe', 'foodieland'); ?></a>
                                </div>
                            </div>
                        </template>
                    </div>
                    
                    <!-- Empty State -->
                    <div x-show="!loading && filteredRecipes.length === 0" class="recipes-empty text-center">
                        <i class="icon-recipe-empty"></i>
                        <h3><?php _e('No recipes found', 'foodieland'); ?></h3>
                        <p><?php _e('Try adjusting your filters or search query.', 'foodieland'); ?></p>
                        <button @click="resetFilters()" class="btn btn-primary"><?php _e('Reset Filters', 'foodieland'); ?></button>
                    </div>
                    
                    <!-- Pagination -->
                    <div x-show="!loading && filteredRecipes.length > 0" class="recipes-pagination">
                        <?php
                        the_posts_pagination(array(
                            'mid_size' => 2,
                            'prev_text' => __('Previous', 'foodieland'),
                            'next_text' => __('Next', 'foodieland'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
get_footer();
