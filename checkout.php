<?php get_header(); ?>

<main class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <h1 class="page-title mb-4"><?php esc_html_e('Checkout', 'woocommerce'); ?></h1>
            <?php
            do_action('woocommerce_before_checkout_form', $checkout);

            // If checkout registration is disabled and not logged in, the user cannot checkout
            if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
                echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));

                return;
            }

            ?>

            <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">
                <?php if ($checkout->get_checkout_fields()) : ?>

                    <?php do_action('woocommerce_checkout_before_customer_details'); ?>

                    <div class="row" id="customer_details">
                        <div class="col-md-6">
                            <?php do_action('woocommerce_checkout_billing'); ?>
                        </div>

                        <div class="col-md-6">
                            <?php do_action('woocommerce_checkout_shipping'); ?>
                        </div>
                    </div>

                    <?php do_action('woocommerce_checkout_after_customer_details'); ?>

                    <h3 id="order_review_heading"><?php esc_html_e('Your order', 'woocommerce'); ?></h3>

                <?php endif; ?>

                <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>

                <div id="order_review" class="woocommerce-checkout-review-order">
                    <?php do_action('woocommerce_checkout_order_review'); ?>
                </div>
            </form>

            <?php do_action('woocommerce_after_checkout_form', $checkout); ?>
        </div>

        <div class="col-md-4">
            <aside class="sidebar">
                <?php get_sidebar(); ?>
            </aside>
        </div>
    </div>
</main>

<?php get_footer(); ?>
