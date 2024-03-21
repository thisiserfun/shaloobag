<?php
/*
IMPORTER HamyarWP.COM THEMES
 by navid rostamnezhad
*/
function hamyarwp_import_files() {
	return array(
		array(
			'import_file_name'             => 'دموی اصلی',
			'local_import_file'            => trailingslashit( get_theme_file_path() ) . 'hwp_inc/import_files/content.xml',
			'local_import_widget_file'     => trailingslashit( get_theme_file_path() ) . 'hwp_inc/import_files/widget.wie',
			'local_import_customizer_file' => trailingslashit( get_theme_file_path() ) . 'hwp_inc/import_files/customizer.dat',
			'import_preview_image_url'     => '#',
			'import_notice'                => 'لطفا قبل درون ریزی افزونه های مورد نیاز را نصب کنید : ووکامرس , المنتور, Everest Forms',
			'preview_url'                  => '#',
		),
	);
}
add_filter( 'pt-ocdi/import_files', 'hamyarwp_import_files' );

function hamyarwp_after_import_setup() {
	// Assign menus to their locations.
	$primary_menu = get_term_by( 'name', 'Primary menu', 'nav_menu' );

	set_theme_mod( 'nav_menu_locations', array(
			'Primary Menu' => $primary_menu->term_id,
		)
	);

	

	// Assign front page and posts page (blog page).
	$front_page_id = get_page_by_title( 'خانه' );
	$blog_page_id  = get_page_by_title( 'وبلاگ' );
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $front_page_id->ID );
	update_option( 'page_for_posts', $blog_page_id->ID );
}
add_action( 'pt-ocdi/after_import', 'hamyarwp_after_import_setup' );
function ocdi_plugin_intro_text( $default_text ) {
	$default_text = '<div class="ocdi__intro-text"></div>';
	return $default_text;
}
add_filter( 'pt-ocdi/plugin_intro_text', 'ocdi_plugin_intro_text' );
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );
