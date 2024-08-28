<?php
get_header(); ?>

<main class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-title mb-4"><?php esc_html_e('Checkout', 'woocommerce'); ?></h1>

            <!-- Cart Overview Section -->
            <section class="cart-overview mb-5">
                <h2><?php esc_html_e('Your Cart', 'woocommerce'); ?></h2>
                <?php
                // Ensure cart is initialized
                if ( WC()->cart ) {
                    // Get cart contents
                    $cart = WC()->cart->get_cart();

                    if ( !empty( $cart ) ) : ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th><?php esc_html_e('Product', 'woocommerce'); ?></th>
                                    <th><?php esc_html_e('Price', 'woocommerce'); ?></th>
                                    <th><?php esc_html_e('Quantity', 'woocommerce'); ?></th>
                                    <th><?php esc_html_e('Total', 'woocommerce'); ?></th>
                                    <th><?php esc_html_e('Remove', 'woocommerce'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ( $cart as $cart_item_key => $cart_item ) :
                                    $product = wc_get_product( $cart_item['product_id'] );
                                    $product_name = $product->get_name();
                                    $product_price = wc_price( $product->get_price() );
                                    $product_quantity = $cart_item['quantity'];
                                    $product_total = wc_price( $cart_item['line_total'] );
                                    $remove_url = wc_get_cart_remove_url( $cart_item_key );
                                ?>
                                    <tr>
                                        <td><?php echo esc_html( $product_name ); ?></td>
                                        <td><?php echo $product_price; ?></td>
                                        <td><?php echo esc_html( $product_quantity ); ?></td>
                                        <td><?php echo $product_total; ?></td>
                                        <td><a href="<?php echo esc_url( $remove_url ); ?>" class="remove"><?php esc_html_e('Remove', 'woocommerce'); ?></a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <div class="cart-totals">
                            <strong><?php esc_html_e('Total:', 'woocommerce'); ?></strong> <?php echo WC()->cart->get_cart_total(); ?>
                        </div>
                    <?php else: ?>
                        <p><?php esc_html_e('Your cart is currently empty.', 'woocommerce'); ?></p>
                    <?php endif;
                }
                ?>
            </section>

            <!-- Checkout Form -->
            <section class="checkout-form">
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
            </section>
        </div>
    </div>
</main>

<?php get_footer(); ?>
