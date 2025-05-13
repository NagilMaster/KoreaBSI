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


/* Barba */
// require_once $_SERVER['DOCUMENT_ROOT'].'/wp-content/themes/blocksy-child/init/barba.php';

/* GSAP */
require_once $_SERVER['DOCUMENT_ROOT'].'/wp-content/themes/blocksy-child/init/gsap.php';


/* Shortcodes */
require_once $_SERVER['DOCUMENT_ROOT'].'/wp-content/themes/blocksy-child/shortcodes/main-slogan.php';
