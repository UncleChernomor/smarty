<?php

class Smarty_Lab_Shortcodes
{
    public function __construct()
    {
        add_action('init', [$this, 'init_shortcodes']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue']);
        add_action('wp_ajax_show_real_estate',[$this, 'show_real_estate']);
        add_action('wp_ajax_nopriv_show_real_estate', 'show_real_estate');
    }

    public function enqueue ()
    {
        wp_enqueue_script('smarty-lab-ajax', plugins_url('smarty-test/assets/js/front/app-ajax.js'));
        wp_localize_script('smarty-lab-ajax', 
                            'smarty_lab_ajax_data',
                            [
                                'ajaxurl' => admin_url('admin-ajax.php'),
                                'nonce' => wp_create_nonce('ajax-nonce')
                            ]
                        );
    }

    public function show_real_estate():void
    {
        echo "<h2>hello Ajax</h2>";

        wp_die();
    }

    public function init_shortcodes():void
    {
        add_shortcode('smarty-lab', [$this, 'show_filter_shortcode']);
    }

    public function show_filter_shortcode ($atts = []): string {
        extract(shortcode_atts(
            [
                'location' => '1',
                'name' => '1',
                'coords' => '1',
                'floor' => '1',
                'type_building' => '1',
            ],
            $atts
        ));

        $output = '<div class="filter">';
        $output .= '<form id="filter-form" method="post" class="filter-form" action="' .
            get_post_type_archive_link("real-estate") . '">';

        if ( isset($location) && $location === '1' ) {
            $output .= $this -> show_filter_location();
        }

        if ( isset($name) && $name === '1' ) {
            $output .= $this -> show_filter_name();
        }

        if ( isset($coords) && $coords === '1' ) {
            $output .= $this -> show_filter_coords();
        }

        if ( isset($floor) && $floor === '1' ) {
            $output .= $this -> show_filter_floor();
        }

        if ( isset($type_building) && $type_building === '1' ) {
            $output .= $this -> show_filter_type_building();
        }


        $output .= '<input type="submit" name="submit-filter" value="' .
            esc_html__("Filter", 'smarty-lab') . '">';
        $output .= '</form>';
        $output .= '</div>';
        return $output;
    }

    public function show_filter_location():string
    {
        $output = '<select name="smarty-location">';
        $output .= '<option value="">' . esc_html__("Select location") . '</option>';

        $taxonomy = 'location';
        $terms = get_terms(['taxonomy' => $taxonomy, 'hide_empty' => false ]);

        foreach ($terms as $current_term) {
            $output .= '<option value="' . esc_attr($current_term->term_id) . '" ';
            $output .= isset($_POST['smarty-lab-location']) &&
                (int)$_POST['smarty-lab-location'] === $current_term->term_id ?
                'selected>' : '>';
            $output .= esc_html__($current_term->name, "smarty-lab") . '</option>';

        }
        $output .= '</select>';
        return $output;
    }

    public function show_filter_name():string
    {
        return '<input 
                    type="text"
                    name="smarty-lab-name"
                    placeholder="input name"
                 >';
    }

    public function show_filter_coords():string
    {
        return '<input 
                    type="text"
                    name="smarty-lab-coords"
                    placeholder="input soords"
                 >';
    }

    public function show_filter_floor():string
    {
        $output = '<div style="background-color: lightgrey; padding: 20px; width: 50%;">';
        $output .= '<h3>Choose count floor</h3>';
        $output .= '<select name="min-floor">';
        $output .= '<option value="">Choose min floor</option>';
        for ($i = 1; $i <= 20; $i++) {
            $output .= '<option value="'. $i .'">';
            $output .= $i;
            $output .= '</option>';
        }
        $output .= '</select>';

        $output .= '<select name="max-floor">';
        $output .= '<option value="">Choose max floor</option>';
        for ($i = 1; $i <= 20; $i++) {
            $output .= '<option value="'. $i .'">';
            $output .= $i;
            $output .= '</option>';
        }
        $output .= '</select></div>';

        return $output;
    }

    public function show_filter_type_building():string
    {
        $output = '<select name="type-building" style="display: block">';
        $output .= '<option value="">Choose type building</option>';
        $output .= '<option value="panel">Panel</option>';
        $output .= '<option value="briks">Bricks</option>';
        $output .= '<option value="foam-block">Foam blocks</option>';
        $output .= '</select>';
        return $output;
    }

}
