<?php

if (! defined('WP_DEBUG')) {
	die( 'Direct access forbidden.' );
}

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
});

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style('blocksy-child-style', get_stylesheet_uri());
});

function korea_bsi_theme_setup() {
    load_theme_textdomain('korea-bsi', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'korea_bsi_theme_setup');

/* Barba */
// require_once $_SERVER['DOCUMENT_ROOT'].'/wp-content/themes/blocksy-child/init/barba.php';

/* GSAP */
require_once $_SERVER['DOCUMENT_ROOT'].'/wp-content/themes/blocksy-child/init/gsap.php';


/* Shortcodes */
require_once $_SERVER['DOCUMENT_ROOT'].'/wp-content/themes/blocksy-child/shortcodes/main-slogan.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/wp-content/themes/blocksy-child/shortcodes/intro-people.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/wp-content/themes/blocksy-child/shortcodes/thesis-list.php';
