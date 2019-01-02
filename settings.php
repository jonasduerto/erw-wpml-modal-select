<?php
/**
 * settings
 * @package erw-wpml-sl
 */


if ( is_admin() ) {
	add_action( 'admin_menu','function_to_add_setting', 30);
	add_action( 'admin_init','function_to_register_setting', 30);
} else {
}

// queue up the necessary js
add_action('admin_enqueue_scripts', function () {
	add_thickbox();
	wp_enqueue_media();
});

add_action('wp_footer','slider_option', 60);
add_action( 'wp_enqueue_scripts', 'erw_erwlangselect_scripts', 90);
