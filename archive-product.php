<?php get_header(); ?>

<main class="container mt-5" itemscope itemtype="http://schema.org/ItemList">
    <!-- Main Page Title -->
    <meta itemprop="name" content="<?php echo esc_attr(woocommerce_page_title(false)); ?>">

    <div class="row">
        <div class="col-md-8">
            <!-- Page Title and Description -->
            <header class="page-header mb-4">
                <h1 class="page-title" itemprop="name">
                    <?php echo esc_html(woocommerce_page_title()); ?>
                </h1>
                <?php do_action('woocommerce_archive_description'); ?>
            </header>

            <!-- Breadcrumbs and Sorting Options -->
            <div class="sorting-breadcrumbs-wrapper mb-4 d-flex justify-content-between align-items-center">
                <div class="breadcrumb-wrapper">
                    <?php woocommerce_breadcrumb(); ?>
                </div>
                <div class="sorting-wrapper">
                    <?php woocommerce_catalog_ordering(); ?>
                </div>
            </div>

            <!-- Products Grid or Categories -->
            <div class="row">
                <?php if (is_shop()) : ?>
                    <!-- Display Categories on Shop Page -->
                    <?php
                    // Display categories
                    $args = array(
                        'taxonomy'   => 'product_cat',
                        'hide_empty' => false, // Show empty categories
                    );
                    $product_categories = get_terms($args);

                    if (!empty($product_categories) && !is_wp_error($product_categories)) {
                        foreach ($product_categories as $category) {
                            $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                            $image_url = wp_get_attachment_url($thumbnail_id);
                            ?>
                            <div class="col-md-4 mb-4" itemscope itemtype="http://schema.org/Category">
                                <div class="card">
                                    <a href="<?php echo get_term_link($category); ?>">
                                        <?php if ($image_url) : ?>
                                            <img src="<?php echo esc_url($image_url); ?>" class="card-img-top" alt="<?php echo esc_attr($category->name); ?>">
                                        <?php else : ?>
                                            <img src="<?php echo wc_placeholder_img_src(); ?>" class="card-img-top" alt="<?php echo esc_attr($category->name); ?>">
                                        <?php endif; ?>
                                    </a>
                                    <div class="card-body text-center">
                                        <h2 class="card-title">
                                            <a href="<?php echo get_term_link($category); ?>" class="text-dark">
                                                <?php echo esc_html($category->name); ?>
                                            </a>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                <?php elseif (is_product_category()) : ?>
                    <!-- Display Products in the Category and Subcategories -->
                    <?php if (woocommerce_product_loop()) : ?>
                        <div class="row">
                            <?php while (have_posts()) : ?>
                                <?php the_post(); ?>
                                <?php
                                $product = wc_get_product(get_the_ID());
                                $is_in_stock = $product->is_in_stock() ? 'InStock' : 'OutOfStock';
                                $average_rating = $product->get_average_rating();
                                $review_count = $product->get_review_count();
                                ?>
                                <div class="col-md-4 mb-4" itemscope itemtype="http://schema.org/Product">
                                    <div class="card">
                                        <div class="position-relative">
                                            <a href="<?php the_permalink(); ?>" itemprop="url">
                                                <?php if (has_post_thumbnail()) : ?>
                                                    <img src="<?php the_post_thumbnail_url('medium'); ?>" class="card-img-top" alt="<?php the_title_attribute(); ?>" itemprop="image">
                                                <?php else : ?>
                                                    <img src="<?php echo wc_placeholder_img_src(); ?>" alt="<?php the_title_attribute(); ?>" class="card-img-top">
                                                <?php endif; ?>
                                            </a>
                                        </div>

                                        <div class="card-body text-center">
                                            <h2 class="card-title" itemprop="name">
                                                <a href="<?php the_permalink(); ?>" class="text-dark">
                                                    <?php the_title(); ?>
                                                </a>
                                            </h2>

                                            <div class="card-text" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                                <?php echo wc_get_product(get_the_ID())->get_price_html(); ?>
                                                <meta itemprop="price" content="<?php echo esc_attr($product->get_price()); ?>">
                                                <meta itemprop="priceCurrency" content="<?php echo esc_attr(get_woocommerce_currency()); ?>">
                                                <meta itemprop="availability" content="http://schema.org/<?php echo esc_attr($is_in_stock); ?>">
                                            </div>
                                            <meta itemprop="description" content="<?php echo esc_attr(get_the_excerpt()); ?>" style="display: none;">
                                            <?php if ($average_rating > 0) : ?>
                                                <div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating" style="display: none;">
                                                    <meta itemprop="ratingValue" content="<?php echo esc_attr($average_rating); ?>">
                                                    <meta itemprop="reviewCount" content="<?php echo esc_attr($review_count); ?>">
                                                </div>
                                            <?php endif; ?>

                                            <div class="mt-3">
                                                <?php woocommerce_template_loop_add_to_cart(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                
                    <?php
                    // Pagination
                    the_posts_pagination(array(
                        'prev_text' => '&laquo; ' . esc_html__('Previous', 'speedpress'),
                        'next_text' => esc_html__('Next', 'speedpress') . ' &raquo;',
                    ));
                    ?>
                <?php else : ?>
                    <p><?php esc_html_e('No products found in this category.', 'speedpress'); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-md-4">
            <div class="sidebar">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
