<?php

/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template overrides the default WooCommerce archive-product.php to use our custom shortcode layout.
 *
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined('ABSPATH') || exit;

get_header('shop');

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20 (we've hidden this via CSS but good to keep hook)
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action('woocommerce_before_main_content');

?>

<div class="custom-shop-archive-wrapper">
    <?php echo do_shortcode('[zippy_shop_layout title="Our Shop"]'); ?>
</div>

<?php
/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('woocommerce_after_main_content');

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
// do_action( 'woocommerce_sidebar' ); // Commented out to prevent default sidebar

get_footer('shop');
