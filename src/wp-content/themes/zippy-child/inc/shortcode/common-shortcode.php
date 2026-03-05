<?php

/**
 * Shortcode for WooCommerce Breadcrumbs
 */
if (! function_exists('zippy_woocommerce_breadcrumbs')) {
    function zippy_woocommerce_breadcrumbs()
    {
        if (function_exists('woocommerce_breadcrumb')) {
            ob_start();
            woocommerce_breadcrumb(array(
                'delimiter'   => ' <span class="divider">→</span> ',
                'wrap_before' => '<nav class="zippy-breadcrumb">',
                'wrap_after'  => '</nav>',
                'before'      => '',
                'after'       => '',
                'home'        => _x('Home', 'breadcrumb', 'woocommerce'),
            ));
            return ob_get_clean();
        }
        return '';
    }

    // Register the shortcode
    add_shortcode('zippy_breadcrumbs', 'zippy_woocommerce_breadcrumbs');
}

/**
 * Shortcode for Page Header with Breadcrumbs: [zippy_page_header name="Page Title"]
 */
if (! function_exists('zippy_page_header_shortcode')) {
    function zippy_page_header_shortcode($atts)
    {
        $atts = shortcode_atts(array(
            'name' => get_the_title(),
        ), $atts, 'zippy_page_header');

        ob_start();
?>
        <div class="zippy-shop-header">
            <div class="container">
                <h1><?php echo esc_html($atts['name']); ?></h1>
                <div class="zippy-header-breadcrumbs">
                    <?php echo do_shortcode('[zippy_breadcrumbs]'); ?>
                </div>
            </div>
        </div>
<?php
        return ob_get_clean();
    }
    add_shortcode('zippy_page_header', 'zippy_page_header_shortcode');
}
