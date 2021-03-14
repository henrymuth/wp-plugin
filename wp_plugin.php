<?php
/*
Plugin Name: Stars Plugin
Plugin URI: http://server.my-homeip.de/wp
Description: Dieses Plugin zeigt in einer Tabelle einige unbekannte Stars. Beim
klick auf dessen Spalte, öffnet sich ein Fenster, welches mehr Daten über diesen
Star enthält.
Author: Henry Muth
Author URI: http://server.my-homeip.de/wp
Version: 1.0.0
*/

define('PLUGIN_NAME', 'wp-plugin');
define('PLUGIN_URI', 'star-overview');

if( file_exists(plugin_dir_path(__FILE__) . 'include/plugin-functions.php') ) {
	require_once plugin_dir_path(__FILE__) . 'include/plugin-functions.php';
}

if( file_exists(plugin_dir_path(__FILE__) . 'include/plugin-getData.php') ) {
	require_once plugin_dir_path(__FILE__) . 'include/plugin-getData.php';
}

add_action('wp_enqueue_scripts', 'add_css_file');

// CSS Datei einbinden
function add_css_file()
{
	wp_enqueue_style('plugin_style', plugin_dir_url(__FILE__) . 'assets/css/plugin-style.css');
}

// JQuery und Javascript einbinden
add_action('wp_enqueue_scripts', 'add_js_file');

function add_js_file()
{
	//wp_deregister_script('jquery');
  	//wp_enqueue_script( 'jquery', plugin_dir_url( __FILE__ ) . 'assets/js/jquery-1.12.4.js');
  
  
	wp_enqueue_script('mein-plugin', plugin_dir_url(__FILE__) . 'assets/js/mein-plugin.js');
}
