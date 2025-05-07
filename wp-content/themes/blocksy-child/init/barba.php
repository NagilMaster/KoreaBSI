<?php
function barba_script(){
	wp_enqueue_script( 'barba-js', 'https://unpkg.com/@barba/core', array(), false, true );
	wp_enqueue_script( 'barba-default', get_stylesheet_directory_uri() . '/assets/js/barba-default.js', array('barba-js'), false, true );
}
add_action('wp_enqueue_scripts','barba_script');