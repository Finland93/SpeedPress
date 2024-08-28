<?php get_header(); ?>

<main class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <?php if (woocommerce_product_loop()) : ?>

                <div class="woocommerce-products-header">
                    <?php woocommerce_breadcrumb(); ?>
                    <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
                        <h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
                    <?php endif; ?>
                    <?php do_action('woocommerce_archive_description'); ?>
                </div>

                <div class="row">
                    <?php woocommerce_product_loop_start(); ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <?php wc_get_template_part('content', 'product'); ?>
                    <?php endwhile; ?>
                    <?php woocommerce_product_loop_end(); ?>
                </div>

                <?php do_action('woocommerce_after_shop_loop'); ?>

            <?php else : ?>
                <?php do_action('woocommerce_no_products_found'); ?>
            <?php endif; ?>
        </div>

        <div class="col-md-4">
            <aside class="sidebar">
                <?php woocommerce_get_sidebar(); ?>
            </aside>
        </div>
    </div>
</main>

<?php get_footer(); ?>
