<?php
class Smarty_Lab_Shortcodes
{
    public function __construct()
    {
        add_action('init', [$this, 'init_shortcodes']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue']);
        add_action('wp_ajax_show_real_estate',[$this, 'show_real_estate']);
        add_action('wp_ajax_nopriv_show_real_estate', [$this, 'show_real_estate']);
    }

    public function enqueue ()
    {

        wp_enqueue_style( 'smarty-lab-style',  plugins_url('smarty-lab/assets/css/front/app-style.css'));

        wp_enqueue_script(
            'smarty-lab-ajax',
            plugins_url('smarty-lab/assets/js/front/app-ajax.js'),
            ['jquery'],
            '0.1',
            true
        );

        wp_localize_script('smarty-lab-ajax', 
                            'smartyLabAjaxData',
                            [
                                'ajaxurl' => admin_url('admin-ajax.php'),
                                'nonce' => wp_create_nonce('ajax-nonce')
                            ]
                        );
    }

    public function show_real_estate():void
    {
        $form_data = [];

        if ( ! empty($_POST['form-data']) ) {
            parse_str($_POST['form-data'], $form_data);
        }
        
        $args = [
            'post_type' => 'real-estate',
            'posts_per_archive_page' => 3,
            'paged' => !empty($_POST['paged']) ? $_POST['paged'] : 1,
            'meta_query' => [
                    'relation' => 'AND',
            ],
        ];
        
        if ( !empty($form_data['smarty-location']) ) {
            $args['tax_query'] = [
                                    [
                                        'taxonomy' => 'location',
                                        'terms' => $form_data['smarty-location'],
                                    ]
							];
        }
        
        if ( !empty($form_data['type_building']) ) {
            $args['meta_query'][] =  [
                    'key' => 'type_building',
                     'value' => $form_data['type_building'],
                ];
        }
        
        if ( !empty($form_data['smarty-lab-name']) ) {
            $args['meta_query'][] =  [
                        'key' => 'name',
                        'value' => $form_data['smarty-lab-name'],
                        'compare' => 'LIKE',
           ];
        }
			
			if ( !empty($form_data['smarty-lab-name']) ) {
				$args['meta_query'][] =  [
								'key' => 'name',
								'value' => $form_data['smarty-lab-name'],
								'compare' => 'LIKE',
				];
			}
			
			if ( !empty($form_data['smarty-lab-coords']) ) {
				$args['meta_query'][] =  [
								'key' => 'coords',
								'value' => $form_data['smarty-lab-coords'],
				            ];
			}
			
			if ( !empty($form_data['min-floor']) && !empty($form_data['max-floor']) ) {
				$args['meta_query'][] = [
                            'key' => 'floor',
                            'value' => [
                                    $form_data['min-floor'],
                                    $form_data['max-floor'],
                            ],
                            'type' => 'numeric',
                            'compare' => 'BETWEEN',
						];
			}
        
        global $custom_query;
        $custom_query= new WP_Query($args);
    ?>
         <div class="real-estate__cards">
      
         <?php while ( $custom_query->have_posts() ) : ?>
           
           <?php $custom_query->the_post(); ?>
            
             <article class="card-real-estate">
                <header>
                    <h2><?= get_the_title(); ?></h2>
                </header>
                 <div>
                     <div>Location: <?php echo get_the_terms(get_the_ID(), 'location')[0]->name; ?></div>
                     <div>Name: <?php echo get_post_meta(get_the_ID(), 'name', true); ?></div>
                     <div>Coords: <?php echo get_post_meta(get_the_ID(), 'coords', true); ?></div>
                     <div>Floor: <?php echo get_post_meta(get_the_ID(), 'floor', true); ?></div>
                     <div>Type Building: <?php echo get_post_meta(get_the_ID(), 'type_building', true); ?></div>
                 </div>
                <a href="<?= get_the_permalink(); ?>"><?php esc_attr_e("More...", "smarty-lab");?></a>
             </article>
       
        <?php endwhile; ?>
       
        </div>
       
        <?php
        $big = 999999999;
        echo paginate_links( array(
        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format' => '?paged=%#%',
        'current' => $args['paged'],
        'total' => $custom_query->max_num_pages
    ) );
        
        wp_reset_postdata();
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

        $output = '<sectin id="real-filter" class="filter">';
        $output .= '<h2>' . esc_html__('Filter Real Estates', 'smarty-lab') . '</h2>';
        $output .= '<form id="filter-form" method="post" class="filter-form" action="' .
            get_post_type_archive_link("real-estate") . '">';

//        $output .= '<input type="hidden" name="action" value="show_real_estate">';

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
        $output = '<div class="form__count-foor">';
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
        $output = '<select name="type_building" style="display: block">';
        $output .= '<option value="">Choose type building</option>';
        $output .= '<option value="Panel">Panel</option>';
        $output .= '<option value="Brick">Brick</option>';
        $output .= '<option value="Foam Block">Foam Block</option>';
        $output .= '</select>';
        return $output;
    }
}
