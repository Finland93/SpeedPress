<?php get_header(); ?>

<main class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <?php
            while (have_posts()) :
                the_post();

                wc_get_template_part('content', 'single-product');

                // Display related products
                woocommerce_output_related_products();

                // Display up-sells products
                woocommerce_upsell_display();

            endwhile;
            ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
