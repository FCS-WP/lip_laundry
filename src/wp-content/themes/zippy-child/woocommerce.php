<?php

/**
 * Custom WooCommerce Template catch-all
 */

get_header('shop');

if (is_shop() || is_product_category() || is_product_tag()) {
?>
    <div class="custom-shop-archive-wrapper">
        <?php echo do_shortcode('[zippy_shop_layout title="Our Shop"]'); ?>
    </div>
<?php
} else {
    // For single products or other WC pages, use default content
    woocommerce_content();
}

get_footer('shop');
