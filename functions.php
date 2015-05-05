<?php
/**
 * Child theme demo for #wcnc2015
 * Enqueue parent styles and load options and customizer demos.
 */
/**
 * Load parent stylesheet instead of this child theme's styleshet
 */
function enqueue_parent_theme_style() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_parent_theme_style' );


// Load
require_once get_stylesheet_directory() . '/options.php';
require_once get_stylesheet_directory() . '/customizer.php';