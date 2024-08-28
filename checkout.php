<?php
get_header(); ?>

<main class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h1 class="wc-page-title mb-4"><?php esc_html_e('Checkout', 'woocommerce'); ?></h1>

            <!-- Cart Overview Section -->
            <section class="wc-cart-overview mb-5 bg-light p-4 rounded shadow-sm">
                <?php
                // Ensure cart is initialized
                if (WC()->cart) {
                    $cart = WC()->cart->get_cart();
                    if (!empty($cart)) : ?>
                        <form action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th><?php esc_html_e('Image', 'woocommerce'); ?></th>
                                        <th><?php esc_html_e('Product', 'woocommerce'); ?></th>
                                        <th><?php esc_html_e('Price', 'woocommerce'); ?></th>
                                        <th><?php esc_html_e('Quantity', 'woocommerce'); ?></th>
                                        <th><?php esc_html_e('Total', 'woocommerce'); ?></th>
                                        <th><?php esc_html_e('Remove', 'woocommerce'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cart as $cart_item_key => $cart_item) :
                                        $product = wc_get_product($cart_item['product_id']);
                                        if ($product) {
                                            $product_name = $product->get_name();
                                            $product_price = wc_price($product->get_price());
                                            $product_quantity = $cart_item['quantity'];
                                            $product_total = wc_price($cart_item['line_total']);
                                            $remove_url = wc_get_cart_remove_url($cart_item_key);
                                            $product_url = get_permalink($product->get_id());
                                            $product_image_url = wp_get_attachment_image_src($product->get_image_id(), 'thumbnail')[0];
                                    ?>
                                        <tr>
                                            <td>
                                                <?php if ($product_image_url) : ?>
                                                    <a href="<?php echo esc_url($product_url); ?>">
                                                        <img src="<?php echo esc_url($product_image_url); ?>" class="product-image" alt="<?php echo esc_attr($product_name); ?>">
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?php echo esc_url($product_url); ?>" class="product-link">
                                                    <?php echo esc_html($product_name); ?>
                                                </a>
                                            </td>
                                            <td><?php echo $product_price; ?></td>
                                            <td>
                                                <input type="number" name="cart[<?php echo esc_attr($cart_item_key); ?>][qty]" value="<?php echo esc_attr($product_quantity); ?>" class="form-control form-control-sm" min="1">
                                            </td>
                                            <td><?php echo $product_total; ?></td>
                                            <td>
                                                <a href="<?php echo esc_url($remove_url); ?>" class="btn btn-danger btn-sm"><?php esc_html_e('Remove', 'woocommerce'); ?></a>
                                            </td>
                                        </tr>
                                    <?php
                                        }
                                    endforeach; ?>
                                </tbody>
                            </table>
                        </form>
                        <div class="cart-totals mt-4 bg-white p-3 border rounded shadow-sm">
                            <strong><?php esc_html_e('Total:', 'woocommerce'); ?></strong> <?php echo WC()->cart->get_cart_total(); ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info"><?php esc_html_e('Your cart is currently empty.', 'woocommerce'); ?></div>
                    <?php endif;
                } else {
                    echo '<div class="alert alert-warning">' . esc_html__('Cart is not initialized.', 'woocommerce') . '</div>';
                }
                ?>
            </section>


            <!-- Checkout Form -->
            <section class="checkout-form bg-light p-4 rounded shadow-sm">
                <?php
                // If checkout registration is disabled and not logged in, the user cannot checkout
                if (!WC()->checkout->is_registration_enabled() && WC()->checkout->is_registration_required() && !is_user_logged_in()) {
                    echo '<div class="alert alert-warning">' . esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce'))) . '</div>';
                    return;
                }
                ?>

                <form name="checkout" method="post" class="checkout woocommerce-checkout needs-validation" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data" novalidate>
                    <?php if (WC()->checkout->get_checkout_fields()) : ?>

                        <div class="row mb-4" id="customer_details">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php do_action('woocommerce_checkout_billing'); ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php do_action('woocommerce_checkout_shipping'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="order-review-section mt-4 p-4 border rounded bg-white shadow-sm">
                            <h3 id="order_review_heading" class="h4"><?php esc_html_e('Your order', 'woocommerce'); ?></h3>
                            <div id="order_review" class="woocommerce-checkout-review-order">
                                <?php do_action('woocommerce_checkout_order_review'); ?>
                            </div>
                        </div>

                    <?php endif; ?>

                    <div class="form-group mt-4">
                        <?php do_action('woocommerce_checkout_after_order_review'); ?>
                    </div>
                </form>

                <?php do_action('woocommerce_after_checkout_form'); ?>
            </section>
        </div>
    </div>
</main>

<?php get_footer(); ?>
