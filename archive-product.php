<?php get_header(); ?>

<main class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <!-- Page Title and Description -->
            <header class="page-header mb-4">
                <h1 class="page-title">
                    <?php woocommerce_page_title(); ?>
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

            <!-- Products Grid -->
            <div class="row">
                <?php if (woocommerce_product_loop()) : ?>
                    <?php woocommerce_product_loop_start(); ?>
                    <?php while (have_posts()) : ?>
                        <?php the_post(); ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="position-relative">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <img src="<?php the_post_thumbnail_url('medium'); ?>" class="card-img-top" alt="<?php the_title_attribute(); ?>">
                                        <?php else : ?>
                                            <img src="<?php echo wc_placeholder_img_src(); ?>" alt="<?php the_title_attribute(); ?>" class="card-img-top">
                                        <?php endif; ?>
                                    </a>
                                </div>

                                <div class="card-body text-center">
                                    <h2 class="card-title">
                                        <a href="<?php the_permalink(); ?>" class="text-dark">
                                            <?php the_title(); ?>
                                        </a>
                                    </h2>

                                    <div class="card-text">
                                        <?php echo wc_get_product(get_the_ID())->get_price_html(); ?>
                                    </div>

                                    <div class="mt-3">
                                        <?php woocommerce_template_loop_add_to_cart(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    <?php woocommerce_product_loop_end(); ?>

                    <?php
                    // Pagination
                    the_posts_pagination(array(
                        'prev_text' => '&laquo; ' . esc_html__('Previous', 'speedpress'),
                        'next_text' => esc_html__('Next', 'speedpress') . ' &raquo;',
                    ));
                    ?>
                <?php else : ?>
                    <p><?php esc_html_e('Sorry, no products matched your criteria.', 'speedpress'); ?></p>
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
