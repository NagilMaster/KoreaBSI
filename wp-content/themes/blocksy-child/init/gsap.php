<?php 

// wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );
function theme_gsap_script(){
    // The core GSAP library
    wp_enqueue_script( 'gsap-js', 'https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js', array(), false, true );
    // ScrollTrigger - with gsap.js passed as a dependency
    wp_enqueue_script( 'gsap-st', 'https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/ScrollTrigger.min.js', array('gsap-js'), false, true );
	wp_enqueue_script( 'gsap-app', get_stylesheet_directory_uri() . '/assets/js/gsap.js', array('gsap-js'), false, true );
}

add_action( 'wp_enqueue_scripts', 'theme_gsap_script' );