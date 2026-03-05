<?php

/**
 * Shortcode: [zippy_shop_layout]
 */
if (! function_exists('zippy_shop_layout_shortcode')) {
    function zippy_shop_layout_shortcode($atts)
    {
        $atts = shortcode_atts(array(
            'limit' => 12,
            'category' => '',
            'title' => 'Shop'
        ), $atts, 'zippy_shop_layout');

        // Get sorting param
        $orderby_param = isset($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : 'date';

        // Product query args
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => intval($atts['limit']),
            'post_status'    => 'publish',
        );

        // Handle sorting logic
        switch ($orderby_param) {
            case 'price':
                $args['orderby']  = 'meta_value_num';
                $args['meta_key'] = '_price';
                $args['order']    = 'ASC';
                break;
            case 'price-desc':
                $args['orderby']  = 'meta_value_num';
                $args['meta_key'] = '_price';
                $args['order']    = 'DESC';
                break;
            case 'date':
                $args['orderby']  = 'date';
                $args['order']    = 'DESC';
                break;
            case 'menu_order':
                $args['orderby']  = 'menu_order title';
                $args['order']    = 'ASC';
                break;
            default:
                $args['orderby']  = 'date';
                $args['order']    = 'DESC';
                break;
        }

        if (!empty($atts['category'])) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    => $atts['category'],
                ),
            );
        }

        $query = new WP_Query($args);

        // Sidebar categories
        $categories = get_terms(array(
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
        ));

        ob_start();
?>
        <?php echo do_shortcode('[zippy_page_header name="' . $atts['title'] . '"]'); ?>

        <div class="zippy-shop-container">
            <div class="zippy-shop-layout">
                <!-- Sidebar -->
                <aside class="zippy-shop-sidebar">
                    <div class="zippy-shop-widget">
                        <h3>LEFT SIDEBAR FILTERS</h3>

                        <div style="margin-top: 20px;">
                            <strong style="display: block; font-size: 14px; margin-bottom: 10px; color: #000;">CATEGORIES</strong>
                            <ul>
                                <?php if (!is_wp_error($categories) && !empty($categories)) : ?>
                                    <?php foreach ($categories as $cat) : ?>
                                        <li>
                                            <a href="<?php echo esc_url(get_term_link($cat)); ?>">
                                                <?php echo esc_html($cat->name); ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <li><a href="#">Laundry Care</a></li>
                                    <li><a href="#">Corporate Solutions</a></li>
                                    <li><a href="#">Cleaning Services</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>

                        <div style="margin-top: 30px;">
                            <strong style="display: block; font-size: 14px; margin-bottom: 10px; color: #000;">PRICE FILTER</strong>
                            <div class="price-filter-mock">
                                <div style="height: 4px; background: #eee; border-radius: 2px; position: relative; margin: 15px 0;">
                                    <div style="position: absolute; left: 10%; right: 40%; top: 0; bottom: 0; background: #b4105f;"></div>
                                    <div style="position: absolute; left: 10%; top: 50%; transform: translate(-50%, -50%); width: 14px; height: 14px; background: #fff; border: 2px solid #b4105f; border-radius: 50%;"></div>
                                    <div style="position: absolute; right: 40%; top: 50%; transform: translate(50%, -50%); width: 14px; height: 14px; background: #fff; border: 2px solid #b4105f; border-radius: 50%;"></div>
                                </div>
                                <div style="font-size: 13px; color: #666;">Price: $10 — $100</div>
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- Main Content -->
                <main class="zippy-shop-main">
                    <div class="zippy-shop-toolbar">
                        <div class="zippy-shop-result-count">
                            TOP FILTER BAR — Showing <?php echo $query->post_count; ?> of <?php echo $query->found_posts; ?> results
                        </div>
                        <div class="zippy-shop-ordering">
                            <form method="get" id="zippy-shop-sort-form">
                                <select name="orderby" onchange="this.form.submit()">
                                    <option value="menu_order" <?php selected($orderby_param, 'menu_order'); ?>>Default sorting</option>
                                    <option value="date" <?php selected($orderby_param, 'date'); ?>>Sort by latest</option>
                                    <option value="price" <?php selected($orderby_param, 'price'); ?>>Sort by price: low to high</option>
                                    <option value="price-desc" <?php selected($orderby_param, 'price-desc'); ?>>Sort by price: high to low</option>
                                </select>
                                <?php
                                // Keep other GET params if any (like search)
                                foreach ($_GET as $key => $value) {
                                    if ($key !== 'orderby') {
                                        echo '<input type="hidden" name="' . esc_attr($key) . '" value="' . esc_attr($value) . '">';
                                    }
                                }
                                ?>
                            </form>
                        </div>
                    </div>

                    <div class="zippy-product-grid">
                        <?php if ($query->have_posts()) : ?>
                            <?php while ($query->have_posts()) : $query->the_post();
                                $product = function_exists('wc_get_product') ? wc_get_product(get_the_ID()) : null;
                            ?>
                                <div class="zippy-product-card">
                                    <div class="zippy-product-image">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php if (has_post_thumbnail()) : ?>
                                                <?php the_post_thumbnail('medium'); ?>
                                            <?php else : ?>
                                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #f0f0f0; color: #ccc; font-weight: 700; font-size: 12px; text-transform: uppercase;">Example Image</div>
                                            <?php endif; ?>
                                        </a>
                                    </div>
                                    <h3 class="zippy-product-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    <div class="zippy-product-price">
                                        <?php echo $product ? $product->get_price_html() : '$25.00'; ?>
                                    </div>
                                    <div class="zippy-product-actions">
                                        <a href="<?php echo $product ? esc_url($product->add_to_cart_url()) : '#'; ?>" class="button">ADD TO CART</a>
                                    </div>
                                </div>
                            <?php endwhile;
                            wp_reset_postdata(); ?>
                        <?php else : ?>
                            <!-- Fallback Mockup if no products -->
                            <?php for ($i = 1; $i <= 6; $i++) : ?>
                                <div class="zippy-product-card">
                                    <div class="zippy-product-image">
                                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: #f5f5f5; color: #ee4d2d; font-style: italic; font-size: 14px;">EXAMPLE</div>
                                    </div>
                                    <h3 class="zippy-product-title">
                                        <a href="#">10-Piece Laundry Package (Example)</a>
                                    </h3>
                                    <div class="zippy-product-price">
                                        $45.00
                                    </div>
                                    <div class="zippy-product-actions">
                                        <a href="#" class="button">ADD TO CART</a>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        <?php endif; ?>
                    </div>
                </main>
            </div>
        </div>
<?php
        return ob_get_clean();
    }
    add_shortcode('zippy_shop_layout', 'zippy_shop_layout_shortcode');
}
