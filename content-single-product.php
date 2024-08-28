<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

global $product;

?>

<article id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>
    <div class="row">
        <div class="col-md-6">
            <?php
            // Display the product gallery
            woocommerce_show_product_images();
            ?>
        </div>

        <div class="col-md-6">
            <h1 class="product_title entry-title"><?php the_title(); ?></h1>

            <div class="woocommerce-product-rating">
                <?php woocommerce_template_single_rating(); ?>
            </div>

            <div class="woocommerce-product-price">
                <?php woocommerce_template_single_price(); ?>
            </div>

            <div class="woocommerce-product-description">
                <?php woocommerce_template_single_excerpt(); ?>
            </div>

            <div class="woocommerce-product-add-to-cart">
                <?php woocommerce_template_single_add_to_cart(); ?>
            </div>

            <div class="woocommerce-product-meta">
                <?php woocommerce_template_single_meta(); ?>
            </div>
        </div>
    </div>
</article>
