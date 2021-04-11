<?php
/**
 * @package Hightlights_Gallery
 * @version 0.1
 */
/*
Plugin Name: Highlights Gallery
Plugin URI: https://github.com/sourcevortex/highlights-gallery
Description: A highlight gallery (carousel) widget
Author: Carlos H.
Version: 0.1
Author URI: https://www.linkedin.com/in/chsjr1996/
*/

// Define constants
define( 'HG_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'HG_PLUGIN_DIR_PATH', __DIR__ );
define( 'HG_DEFAULT_CATEGORY', 'destaques');

// Load all plugin parts
require_once __DIR__ . '/widget/highlights-gallery-widget.php';

// Load Widget
function hgw_load_widget() {
    register_widget( 'hgw_widget' );
}
add_action( 'widgets_init', 'hgw_load_widget' );