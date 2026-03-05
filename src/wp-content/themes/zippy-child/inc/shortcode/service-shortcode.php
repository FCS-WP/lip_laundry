<?php

/**
 * Shortcode: [zippy_services_slider]
 */
if (! function_exists('zippy_services_slider_shortcode')) {
    function zippy_services_slider_shortcode($atts)
    {
        $atts = shortcode_atts(array(
            'limit' => -1,
        ), $atts, 'zippy_services_slider');

        $query = new WP_Query(array(
            'post_type'      => 'service',
            'posts_per_page' => intval($atts['limit']),
            'post_status'    => 'publish',
            'orderby'        => 'menu_order date',
            'order'          => 'ASC',
        ));

        if (! $query->have_posts()) {
            return '';
        }

        ob_start();
?>
        <div class="zippy-service-slider-wrapper">
            <div class="zippy-service-slider" id="zippyServiceSlider">
                <?php while ($query->have_posts()) : $query->the_post();
                    $icon      = function_exists('get_field') ? get_field('service_icon')      : '';
                    $subtitle  = function_exists('get_field') ? get_field('service_subtitle')  : get_the_excerpt();
                    $features  = function_exists('get_field') ? get_field('service_features')  : array();
                    $note      = function_exists('get_field') ? get_field('service_note')       : '';
                    $cta_label = function_exists('get_field') ? get_field('service_cta_label') : 'Learn More';
                    $cta_url   = function_exists('get_field') ? get_field('service_cta_url')   : get_permalink();
                    if (! $cta_url)   $cta_url   = get_permalink();
                    if (! $cta_label) $cta_label = 'Learn More';
                    $post_content = get_the_content();
                ?>
                    <div class="zippy-service-card">
                        <div class="zippy-service-card__inner">

                            <div class="zippy-service-card__icon">
                                <?php if ($icon) : ?>
                                    <img src="<?php echo esc_url($icon); ?>" alt="<?php the_title_attribute(); ?>">
                                <?php else : ?>
                                    <span class="zippy-service-card__icon-placeholder">
                                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z" fill="currentColor" />
                                        </svg>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <h3 class="zippy-service-card__title"><?php the_title(); ?></h3>

                            <?php if ($subtitle) : ?>
                                <p class="zippy-service-card__subtitle"><?php echo esc_html($subtitle); ?></p>
                            <?php endif; ?>

                            <?php if (! empty($features)) : ?>
                                <ul class="zippy-service-card__features">
                                    <?php foreach ($features as $f) : ?>
                                        <li><?php echo esc_html($f['feature_item']); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>

                            <?php if ($note) : ?>
                                <p class="zippy-service-card__note"><em><?php echo esc_html($note); ?></em></p>
                            <?php endif; ?>

                            <?php if ($cta_url) : ?>
                                <a href="<?php echo esc_url($cta_url); ?>" class="zippy-service-card__cta">
                                    <?php echo esc_html($cta_label); ?> <span aria-hidden="true">→</span>
                                </a>
                            <?php endif; ?>

                            <!-- Description now inside the stretched box to ensure equal height -->
                            <?php if ($post_content) : ?>
                                <div class="zippy-service-card__description">
                                    <?php echo wp_kses_post(wpautop($post_content)); ?>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                <?php endwhile;
                wp_reset_postdata(); ?>
            </div>
        </div>
<?php
        return ob_get_clean();
    }
    add_shortcode('zippy_services_slider', 'zippy_services_slider_shortcode');
}
