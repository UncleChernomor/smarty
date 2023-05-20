<?php
class Smarty_Lab_Custom
{
    public function init():void
    {
        add_action('init', [$this, 'custom_post_type']);
        add_action('init', [$this, 'custom_post_taxonomy']);
    }

    public function custom_post_type():void
    {
        register_post_type(
            'real-estate',
            [
                'public' => true,
                'has_archive' => true,
                'rewrite' => ['slug' => 'real-estates'],
                'label' => esc_html__('Real Estate','smarty-lab'),
                'supports' => ['title', 'editor', 'thumbnail'],
            ]
        );
    }

    public function custom_post_taxonomy():void
    {
        $labels = [
            'name'              => esc_html_x( 'Locations', 'taxonomy general name', 'smarty-lab' ),
            'singular_name'     => esc_html_x( 'Location', 'taxonomy singular name', 'smarty-lab' ),
            'search_items'      => esc_html__( 'Search Locations', 'smarty-lab' ),
            'all_items'         => esc_html__( 'All Locations', 'smarty-lab' ),
            'parent_item'       => esc_html__( 'Parent Location', 'smarty-lab' ),
            'parent_item_colon' => esc_html__( 'Parent Location:', 'smarty-lab' ),
            'edit_item'         => esc_html__( 'Edit Location', 'smarty-lab' ),
            'update_item'       => esc_html__( 'Update Location', 'smarty-lab' ),
            'add_new_item'      => esc_html__( 'Add New Location', 'smarty-lab' ),
            'new_item_name'     => esc_html__( 'New Location Name', 'smarty-lab' ),
            'menu_name'         => esc_html__( 'Location', 'smarty-lab' ),
        ];

        $args = [
            'hierarchical' => false,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => [
                'slug' => 'real-estates/location'
            ],
            'labels' => $labels,
        ];

        register_taxonomy('location', 'real-estate', $args);
    }
}