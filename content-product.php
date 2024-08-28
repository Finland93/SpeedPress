<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

global $product;

?>

<div class="col-sm-6 col-md-4 col-lg-3 mb-4">
    <div class="card h-100 border-0 shadow-sm">
        <a href="<?php the_permalink(); ?>" class="text-decoration-none">
            <?php
            // Display product thumbnail
            if (has_post_thumbnail()) {
                the_post_thumbnail('woocommerce_thumbnail', array('class' => 'card-img-top'));
            } else {
                echo '<img src="' . wc_placeholder_img_src() . '" alt="' . esc_attr__('Placeholder', 'woocommerce') . '" class="card-img-top" />';
            }
            ?>
        </a>
        <div class="card-body d-flex flex-column">
            <h5 class="card-title text-center">
                <a href="<?php the_permalink(); ?>" class="text-dark text-decoration-none">
                    <?php the_title(); ?>
                </a>
            </h5>

            <div class="text-center mb-3">
                <span class="price text-success fs-5 fw-bold">
                    <?php echo $product->get_price_html(); ?>
                </span>
            </div>

            <div class="mt-auto">
                <a href="<?php echo esc_url($product->add_to_cart_url()); ?>" 
                   class="btn btn-primary btn-block text-uppercase add-to-cart-button">
                    <?php echo esc_html($product->add_to_cart_text()); ?>
                </a>
            </div>
        </div>
    </div>
</div>
