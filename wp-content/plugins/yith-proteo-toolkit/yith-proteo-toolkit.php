<?php
/**
 * Plugin Name:         YITH Proteo Toolkit
 * Plugin URI:          https://yithemes.com
 * Description:         Add extra features and a setup wizard to YITH Proteo theme.
 * Version:             1.0.8
 * Author:              YITH
 * Author URI:          https://yithemes.com/
 * Requires at least:   5.3
 * Tested up to:        5.7
 *
 * Text Domain: yith-proteo-toolkit
 *
 * @package YITH_Proteo_tookit
 * @author YITH
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check if plugin may be enabled
 */
function yith_proteo_toolkit_can_be_enabled() {
	return defined( 'YITH_PROTEO_VERSION' );
}

/**
 * Show admin notice when Proteo theme is not enabled
 *
 * @return void
 */
function install_yith_proteo_theme_admin_notice() {
	?>
	<div class="error">
		<?php /* translators: %1$1s: plugin name; %2$2s: theme name; */ ?>
		<p><?php echo sprintf( esc_html__( '%1$1s is meant to be used with %2$2s theme.', 'yith-proteo-toolkit' ), '<b>YITH Proteo Toolkit</b>', '<b>YITH Proteo</b>' ); ?></p>
	</div>
	<?php
}

if ( ! defined( 'YITH_PROTEO_TOOLKIT' ) ) {
	define( 'YITH_PROTEO_TOOLKIT', 'YITH_PROTEO_TOOLKIT' );
}

if ( ! defined( 'YITH_PROTEO_TOOLKIT_VERSION' ) ) {
	define( 'YITH_PROTEO_TOOLKIT_VERSION', '1.0.8' );
}

if ( ! defined( 'YITH_PROTEO_TOOLKIT_PATH' ) ) {
	define( 'YITH_PROTEO_TOOLKIT_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'YITH_PROTEO_TOOLKIT_URL' ) ) {
	define( 'YITH_PROTEO_TOOLKIT_URL', plugin_dir_url( __FILE__ ) );
}

require_once YITH_PROTEO_TOOLKIT_PATH . 'includes/yith-proteo-toolkit-utils.php';

require_once YITH_PROTEO_TOOLKIT_PATH . 'block-patterns/block-patterns.php';

/**
 * Load setup wizard
 *
 * @return void
 */
function yith_load_tookit_wizard() {

	if ( ! yith_proteo_toolkit_can_be_enabled() ) {
		add_action( 'admin_notices', 'install_yith_proteo_theme_admin_notice' );
		add_action( 'admin_init', 'yith_proteo_toolkit_disable' );
		return;
	}

	if ( ! class_exists( 'TGM_Plugin_Activation' ) ) {
		require_once YITH_PROTEO_TOOLKIT_PATH . 'includes/third-party/class-tgm-plugin-activation.php';
	}
	add_action( 'load-setup-wizard', 'set_current_scren' );

	require_once YITH_PROTEO_TOOLKIT_PATH . 'includes/third-party/importer/vendor/autoload.php';
	require_once YITH_PROTEO_TOOLKIT_PATH . 'includes/third-party/importer/class-yith-proteo-wizard.php';
	require_once YITH_PROTEO_TOOLKIT_PATH . 'includes/third-party/importer/importer-config.php';
}
add_action( 'init', 'yith_load_tookit_wizard' );

/**
 * Disable plugin
 *
 * @return void
 */
function yith_proteo_toolkit_disable() {
	deactivate_plugins( plugin_basename( __FILE__ ) );
}

/**
 * Add admin style for plugin panels
 *
 * @return void
 */
function yith_proteo_toolkit_add_admin_styles() {
	wp_enqueue_style( 'yith_toolkit_admin_wizard_css', YITH_PROTEO_TOOLKIT_URL . 'assets/css/admin.css', array(), YITH_PROTEO_TOOLKIT_VERSION );
}

add_action( 'admin_print_styles', 'yith_proteo_toolkit_add_admin_styles' );


/**
 * Add admin scripts for plugin panels
 *
 * @return void
 */
function yith_proteo_toolkit_add_admin_scripts() {
	wp_enqueue_script( 'yith_toolkit_admin_wizard_js', YITH_PROTEO_TOOLKIT_URL . 'assets/js/admin.js', array( 'jquery' ), YITH_PROTEO_TOOLKIT_VERSION, true );
}

add_action( 'admin_print_scripts', 'yith_proteo_toolkit_add_admin_scripts' );

/**
 * Check setup wizard status
 *
 * @return void
 */
function yith_proteo_toolkit_run_first_setup() {
	global $pagenow;

	if ( ! yith_proteo_toolkit_can_be_enabled() ) {
		return;
	}

	$current_query_string = isset( $_GET['page'] ) ? wp_unslash( $_GET['page'] ) : false; // phpcs:ignore

	if ( 'themes.php' === $pagenow && 'setup-wizard' === $current_query_string && ! get_option( 'yith_proteo_toolkit_first_setup_run' ) ) {
		update_option( 'yith_proteo_toolkit_first_setup_run', time() );
	}

	if ( get_option( 'yith_proteo_toolkit_first_setup_run' ) || ( 'themes.php' === $pagenow && 'setup-wizard' === $current_query_string ) ) {
		return;
	}

	update_option( 'yith_proteo_toolkit_run_setup', time() );

}

add_action( 'admin_init', 'yith_proteo_toolkit_run_first_setup', 5 );

add_action( 'admin_init', 'yith_proteo_toolkit_run_setup', 10 );

/**
 * Redirect to setup wizard on first run
 *
 * @return void
 */
function yith_proteo_toolkit_run_setup() {
	if ( get_option( 'yith_proteo_toolkit_run_setup' ) ) {
		delete_option( 'yith_proteo_toolkit_run_setup' );
		exit( esc_url( wp_safe_redirect( admin_url( 'themes.php?page=setup-wizard' ) ) ) );
	}
}

register_activation_hook( __FILE__, 'yith_proteo_toolkit_run_first_setup' );

add_filter( 'wizard_regenerate_thumbnails_in_content_import', '__return_false' );

add_action( 'get_template_part_wizard/assets/images/spinner', 'yith_proteo_toolkit_loading_spinner_icon_fix' );

add_action(
	'get_template_part_wizard/assets/images/spinner',
	function() {
		require_once 'includes/third-party/importer/assets/images/spinner.php';
	}
);

/**
 * Disable Elementor spash screen when activating
 *
 * @return void
 */
function theme_prefix_remove_elementor_splash() {
	if ( ! yith_proteo_toolkit_can_be_enabled() ) {
		delete_transient( 'elementor_activation_redirect' );
	}
}
add_action( 'init', 'theme_prefix_remove_elementor_splash' );

// Disable WooCommerce spash screen when activating.
add_filter( 'woocommerce_prevent_automatic_wizard_redirect', '__return_true' );
