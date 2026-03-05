<?php

/**
 * Register Custom Post Type: Service
 */
add_action('init', 'zippy_register_service_cpt');

function zippy_register_service_cpt()
{
    $labels = array(
        'name'               => __('Services', 'zippy'),
        'singular_name'      => __('Service', 'zippy'),
        'menu_name'          => __('Services', 'zippy'),
        'add_new'            => __('Add New', 'zippy'),
        'add_new_item'       => __('Add New Service', 'zippy'),
        'edit_item'          => __('Edit Service', 'zippy'),
        'new_item'           => __('New Service', 'zippy'),
        'view_item'          => __('View Service', 'zippy'),
        'search_items'       => __('Search Services', 'zippy'),
        'not_found'          => __('No services found', 'zippy'),
        'not_found_in_trash' => __('No services found in Trash', 'zippy'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'services'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-clipboard',
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest'       => true,
    );

    register_post_type('service', $args);
}


/**
 * Register ACF Field Group for Service CPT
 * Fields:
 *  - service_icon       (image)       — Icon image
 *  - service_subtitle   (text)        — Short tagline below title
 *  - service_features   (repeater)    — List of bullet features
 *  - service_note       (textarea)    — Italic note text (e.g. *Each item…*)
 *  - service_cta_label  (text)        — CTA button label
 *  - service_cta_url    (url)         — CTA button URL
 */
add_action('acf/init', 'zippy_register_service_acf_fields');

function zippy_register_service_acf_fields()
{
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group(array(
        'key'      => 'group_service_fields',
        'title'    => 'Service Details',
        'fields'   => array(

            // Icon image
            array(
                'key'           => 'field_service_icon',
                'label'         => 'Service Icon',
                'name'          => 'service_icon',
                'type'          => 'image',
                'return_format' => 'url',
                'preview_size'  => 'thumbnail',
                'instructions'  => 'Upload an icon or small image for this service.',
            ),

            // Subtitle / tagline
            array(
                'key'   => 'field_service_subtitle',
                'label' => 'Subtitle',
                'name'  => 'service_subtitle',
                'type'  => 'text',
                'instructions' => 'Short tagline shown below the title (e.g. "Professional garment care beyond basic washing.")',
            ),

            // Feature list (repeater)
            array(
                'key'     => 'field_service_features',
                'label'   => 'Features List',
                'name'    => 'service_features',
                'type'    => 'repeater',
                'layout'  => 'table',
                'button_label' => 'Add Feature',
                'instructions' => 'Bullet points shown inside the card.',
                'sub_fields' => array(
                    array(
                        'key'   => 'field_service_feature_item',
                        'label' => 'Feature',
                        'name'  => 'feature_item',
                        'type'  => 'text',
                    ),
                ),
            ),

            // Note / italic
            array(
                'key'   => 'field_service_note',
                'label' => 'Note',
                'name'  => 'service_note',
                'type'  => 'textarea',
                'rows'  => 2,
                'instructions' => 'Optional italic note displayed after features (e.g. *Each item is inspected…*)',
            ),

            // CTA button label
            array(
                'key'   => 'field_service_cta_label',
                'label' => 'CTA Button Label',
                'name'  => 'service_cta_label',
                'type'  => 'text',
                'default_value' => 'Learn More',
            ),

            // CTA button URL
            array(
                'key'   => 'field_service_cta_url',
                'label' => 'CTA Button URL',
                'name'  => 'service_cta_url',
                'type'  => 'url',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'service',
                ),
            ),
        ),
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'active'                => true,
    ));
}
