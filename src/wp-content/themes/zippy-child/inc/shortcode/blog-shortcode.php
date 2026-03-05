<?php

/**
 * Shortcode: [zippy_blog_layout]
 */
if (! function_exists('zippy_blog_layout_shortcode')) {
    function zippy_blog_layout_shortcode($atts)
    {
        $atts = shortcode_atts(array(
            'limit' => 6,
            'category' => '',
        ), $atts, 'zippy_blog_layout');

        $args = array(
            'post_type'      => 'post',
            'posts_per_page' => intval($atts['limit']),
            'post_status'    => 'publish',
        );

        if (!empty($atts['category'])) {
            $args['category_name'] = $atts['category'];
        }

        $query = new WP_Query($args);
        $posts = $query->posts;

        if (empty($posts)) {
            return '<p>No posts found.</p>';
        }

        $featured_post = array_shift($posts);

        ob_start();
?>
        <div class="zippy-blog-layout">
            <!-- Left: Featured Post -->
            <div class="zippy-blog-featured">
                <div class="featured-card">
                    <a href="<?php echo get_permalink($featured_post->ID); ?>">
                        <?php if (has_post_thumbnail($featured_post->ID)) : ?>
                            <?php echo get_the_post_thumbnail($featured_post->ID, 'large'); ?>
                        <?php else : ?>
                            <div style="width:100%; height:100%; background:#eee;"></div>
                        <?php endif; ?>
                    </a>
                    <div class="featured-content">
                        <div class="meta">
                            <span><?php echo get_the_date('', $featured_post->ID); ?></span>
                            <span><?php echo get_the_author_meta('display_name', $featured_post->post_author); ?></span>
                        </div>
                        <h2><a href="<?php echo get_permalink($featured_post->ID); ?>"><?php echo get_the_title($featured_post->ID); ?></a></h2>
                    </div>
                </div>
            </div>

            <!-- Right: Scrollable List -->
            <div class="zippy-blog-list-scroll">
                <?php foreach ($posts as $post) : ?>
                    <a href="<?php echo get_permalink($post->ID); ?>" class="blog-item-mini">
                        <div class="mini-thumb">
                            <?php if (has_post_thumbnail($post->ID)) : ?>
                                <?php echo get_the_post_thumbnail($post->ID, 'thumbnail'); ?>
                            <?php else : ?>
                                <div style="width:100%; height:100%; background:#eee;"></div>
                            <?php endif; ?>
                        </div>
                        <div class="mini-content">
                            <h3><?php echo get_the_title($post->ID); ?></h3>
                            <span class="date"><?php echo get_the_date('', $post->ID); ?></span>
                        </div>
                    </a>
                <?php endforeach; ?>

                <?php if (count($posts) < 3) : ?>
                    <!-- Adding fallback items if not enough posts to show scroll -->
                    <?php for ($i = 1; $i <= 3; $i++) : ?>
                        <div class="blog-item-mini" style="opacity: 0.5;">
                            <div class="mini-thumb"></div>
                            <div class="mini-content">
                                <h3>Example Post Item #<?php echo $i; ?> (To demonstrate scroll)</h3>
                                <span class="date">March 5, 2026</span>
                            </div>
                        </div>
                    <?php endfor; ?>
                <?php endif; ?>
            </div>
        </div>
<?php
        wp_reset_postdata();
        return ob_get_clean();
    }
    add_shortcode('zippy_blog_layout', 'zippy_blog_layout_shortcode');
}
