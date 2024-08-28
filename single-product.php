<?php
get_header(); 

global $product;
if (!$product) {
    $product = wc_get_product(get_the_ID());
}

// Fetch product attributes
$attributes = $product->get_attributes();
?>

<main class="container mt-5">
    <div id="product-<?php the_ID(); ?>" <?php wc_product_class('product-container', $product); ?> itemscope itemtype="http://schema.org/Product">
        <meta itemprop="sku" content="<?php echo esc_attr($product->get_sku()); ?>">
        <meta itemprop="brand" content="<?php echo esc_attr(get_post_meta($product->get_id(), '_brand', true)); ?>">
        <meta itemprop="mpn" content="<?php echo esc_attr($product->get_meta('_mpn')); ?>">

        <div class="row">
            <!-- Product Images -->
            <div class="col-md-6">
                <?php
                $attachment_ids = $product->get_gallery_image_ids();
                if ($attachment_ids) :
                    $main_image_id = $product->get_image_id();
                    $main_image_url = wp_get_attachment_image_url($main_image_id, 'full');
                    $main_image_alt = get_post_meta($main_image_id, '_wp_attachment_image_alt', true);
                ?>
                    <!-- Main Product Image with Modal -->
                    <div class="main-product-image">
                        <img id="main-product-image" src="<?php echo esc_url($main_image_url); ?>" itemprop="image" alt="<?php echo esc_attr($main_image_alt); ?>" class="img-fluid mb-3" data-bs-toggle="modal" data-bs-target="#image-modal">
                    </div>

                    <!-- Carousel with thumbnails -->
                    <div id="product-thumbnails-carousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php
                            $chunks = array_chunk($attachment_ids, 4); // Divide images into chunks of 4
                            foreach ($chunks as $index => $chunk) : ?>
                                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                    <div class="row">
                                        <?php foreach ($chunk as $attachment_id) :
                                            $thumbnail_url = wp_get_attachment_image_url($attachment_id, 'thumbnail');
                                            $full_image_url = wp_get_attachment_image_url($attachment_id, 'full');
                                            $thumbnail_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
                                        ?>
                                            <div class="col-3">
                                                <img src="<?php echo esc_url($thumbnail_url); ?>" data-full="<?php echo esc_url($full_image_url); ?>" alt="<?php echo esc_attr($thumbnail_alt); ?>" class="img-thumbnail cursor-pointer">
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Carousel controls -->
                        <a class="carousel-control-prev" href="#product-thumbnails-carousel" role="button" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden"><?php esc_html_e('Previous', 'woocommerce'); ?></span>
                        </a>
                        <a class="carousel-control-next" href="#product-thumbnails-carousel" role="button" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden"><?php esc_html_e('Next', 'woocommerce'); ?></span>
                        </a>
                    </div>
                <?php
                endif;
                ?>
            </div>

            <!-- Product Summary -->
            <div class="col-md-6">
                <h1 class="product_title entry-title" itemprop="name"><?php the_title(); ?></h1>

                <div class="woocommerce-product-short-description">
                    <?php
                    if (function_exists('woocommerce_template_single_excerpt')) {
                        woocommerce_template_single_excerpt();
                    }
                    ?>
                </div>                

                <div class="woocommerce-product-rating">
                    <?php
                    if ($rating_count = $product->get_rating_count()) : ?>
                        <div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
                            <meta itemprop="ratingValue" content="<?php echo esc_attr($product->get_average_rating()); ?>">
                            <meta itemprop="reviewCount" content="<?php echo esc_attr($product->get_review_count()); ?>">
                        </div>
                    <?php endif;

                    if (function_exists('woocommerce_template_single_rating')) {
                        woocommerce_template_single_rating();
                    }
                    ?>
                </div>

                <div class="woocommerce-product-price">
                    <span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                        <meta itemprop="priceCurrency" content="<?php echo esc_attr(get_woocommerce_currency()); ?>">
                        <link itemprop="url" href="<?php the_permalink(); ?>">
                        <span itemprop="price" content="<?php echo esc_attr($product->get_price()); ?>"><?php echo wp_kses_post($product->get_price_html()); ?></span>
                        <?php
                        $availability = $product->is_in_stock() ? 'InStock' : 'OutOfStock';
                        ?>
                        <meta itemprop="availability" content="http://schema.org/<?php echo esc_attr($availability); ?>">
                    </span>
                </div>

                <div class="woocommerce-product-add-to-cart">
                    <?php
                    // Display the add-to-cart button
                    if (function_exists('woocommerce_template_single_add_to_cart')) {
                        woocommerce_template_single_add_to_cart();
                    }
                    ?>
                </div>

                <div class="woocommerce-product-meta">
                    <ul>
                        <?php if ($sku = $product->get_sku()) : ?>
                            <li><strong><?php esc_html_e('SKU:', 'woocommerce'); ?></strong> <?php echo esc_html($sku); ?></li>
                        <?php endif; ?>

                        <?php if ($brand = get_post_meta($product->get_id(), '_brand', true)) : ?>
                            <li><strong><?php esc_html_e('Brand:', 'woocommerce'); ?></strong> <?php echo esc_html($brand); ?></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>

<!-- Tabs for Description and Additional Details -->
<div role="tablist" aria-label="Product Information Tabs" class="mt-4">
    <ul class="nav nav-tabs" id="product-tabs">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="description-tab" data-bs-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true"><?php esc_html_e('Description', 'woocommerce'); ?></a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="additional-details-tab" data-bs-toggle="tab" href="#additional-details" role="tab" aria-controls="additional-details" aria-selected="false"><?php esc_html_e('Additional Details', 'woocommerce'); ?></a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="attributes-tab" data-bs-toggle="tab" href="#attributes" role="tab" aria-controls="attributes" aria-selected="false"><?php esc_html_e('Attributes', 'woocommerce'); ?></a>
        </li>
    </ul>
</div>

<div class="tab-content mt-3" id="product-tabs-content">
    <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
         <?php echo apply_filters('the_content', $product->get_description()); ?>
    </div>
    
    <div class="tab-pane fade" id="additional-details" role="tabpanel" aria-labelledby="additional-details-tab">
        <table class="PR-table mt-3">
            <tr>
                <th><?php esc_html_e('Price:', 'woocommerce'); ?></th>
                <td><?php echo wp_kses_post($product->get_price_html()); ?></td>
            </tr>
            <tr>
                <th><?php esc_html_e('Sale Price:', 'woocommerce'); ?></th>
                <td><?php echo $product->is_on_sale() ? wp_kses_post($product->get_sale_price()) : '&mdash;'; ?></td>
            </tr>
            <tr>
                <th><?php esc_html_e('Weight:', 'woocommerce'); ?></th>
                <td><?php echo $product->get_weight() ? esc_html($product->get_weight()) . ' ' . get_option('woocommerce_weight_unit') : '&mdash;'; ?></td>
            </tr>
            <tr>
                <th><?php esc_html_e('SKU:', 'woocommerce'); ?></th>
                <td><?php echo esc_html($product->get_sku()); ?></td>
            </tr>
            <tr>
                <th><?php esc_html_e('Dimensions:', 'woocommerce'); ?></th>
                <td><?php 
                    $dimensions = $product->get_dimensions(false);
                    echo $dimensions ? esc_html($dimensions) : '&mdash;';
                ?></td>
            </tr>
        </table>
    </div>

    <div class="tab-pane fade" id="attributes" role="tabpanel" aria-labelledby="attributes-tab">
        <?php if ($attributes) : ?>
            <table class="PR-table mt-3">
                <?php foreach ($attributes as $attribute) : ?>
                    <?php
                    // Skip variation attributes
                    if ($attribute->get_variation()) continue;
                    // Get attribute name and value
                    $attribute_name = wc_attribute_label($attribute->get_name());
                    $attribute_value = $product->get_attribute($attribute->get_name());

                    // Ensure attribute value is valid
                    $attribute_value = is_string($attribute_value) ? wp_kses_post($attribute_value) : '&mdash;';
                    ?>
                    <tr>
                        <th><?php echo esc_html($attribute_name); ?></th>
                        <td><?php echo $attribute_value; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else : ?>
            <p><?php esc_html_e('No attributes available.', 'woocommerce'); ?></p>
        <?php endif; ?>
    </div>
</div>

        <!-- Upsell Products -->
        <?php
        $upsell_ids = $product->get_upsell_ids();
        if (!empty($upsell_ids)) : ?>
            <div class="mt-5">
                <h2><?php esc_html_e('You may also like...', 'woocommerce'); ?></h2>
                <?php
                woocommerce_upsell_display(4, 4); 
                ?>
            </div>
        <?php endif; ?>

        <!-- Related Products -->
        <div class="mt-5">
            <h2><?php esc_html_e('Related products', 'woocommerce'); ?></h2>
            <?php
            woocommerce_output_related_products(array(
                'posts_per_page' => 4,
                'columns' => 4,       
            ));
            ?>
        </div>
    </div>
</main>

<!-- Modal for Main Product Image -->
<div class="modal fade" id="image-modal" tabindex="-1" aria-labelledby="image-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="image-modal-label"><?php esc_html_e('Product Image', 'woocommerce'); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php esc_attr_e('Close', 'woocommerce'); ?>"></button>
            </div>
            <div class="modal-body">
                <img src="<?php echo esc_url($main_image_url); ?>" class="img-fluid" alt="<?php echo esc_attr($main_image_alt); ?>" id="modal-image">
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>

<!-- JavaScript for image swap -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    var thumbnails = document.querySelectorAll('.img-thumbnail');
    var mainImage = document.getElementById('main-product-image');
    var modalImage = document.getElementById('modal-image');

    thumbnails.forEach(function(thumbnail) {
        thumbnail.addEventListener('click', function() {
            var newImageUrl = this.getAttribute('data-full');
            mainImage.setAttribute('src', newImageUrl);
            modalImage.setAttribute('src', newImageUrl);
        });
    });
});
</script>
