<?php
/*
 * Plugin Name:  Smarty Lab TEST
 * License:      GPL v2 or later
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:  smarty-lab
 */
if ( !function_exists('add_action') ) {
    exit;
}

require_once (plugin_dir_path(__FILE__) . 'inc/class-smarty-lab-custom.php');
require_once (plugin_dir_path(__FILE__) . 'inc/class-smarty-lab-shortcodes.php');
require_once (plugin_dir_path(__FILE__) . 'inc/class-smarty-lab-widget.php');

if ( !class_exists('Smarty_Lab_Test') ) {
    class Smarty_Lab_Test
    {
        public function init(): void
        {
            add_action('widgets_init', [$this, 'register_widgets']);

        }
        public function register_widgets() 
        {
            register_widget('Smarty_Lab_Widget');
        }

        static function activation():void {
            flush_rewrite_rules();
        }
        static function deactivation():void {
            flush_rewrite_rules();
        }
    }
}

if ( class_exists('Smarty_Lab_Test') ) {

    $app = new Smarty_Lab_Test();
    $app->init();

    register_activation_hook(__FILE__ , [$app, 'activation']);
    register_deactivation_hook(__FILE__, [$app, 'deactivation']);

    if ( class_exists('Smarty_Lab_Custom') ) {
        $customPost = new Smarty_Lab_Custom();
        $customPost->init();
    }

    if ( class_exists('Smarty_Lab_Shortcodes') ) {
        $smartyShortCode = new Smarty_Lab_Shortcodes();
    }
}