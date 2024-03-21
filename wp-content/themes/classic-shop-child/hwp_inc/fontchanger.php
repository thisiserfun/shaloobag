<?php
/*
FONT CHANGER HamyarWP.com THEMES
AUTHOR : Reza Akbari
edited by Shayan Farhang Pazhooh
*/
add_action('admin_menu', 'add_font_changer_submenu');
function add_font_changer_submenu(){
	add_submenu_page(
		'options-general.php',
		'تغییر فونت',
		'تغییر فونت',
		'manage_options',
		'hwp_font_changer',
		'hwp_font_changer_callback'
	);
}
function hwp_font_changer_callback() {
		if ( isset( $_POST['submit'] ) ) {
			$font_name = $_POST['font-name'];
			if ( $font_name == "shabnam" ) {
				update_option('hwp_font', 'shabnam');
			} elseif ( $font_name == "sahel" ) {
				update_option('hwp_font', 'sahel');
			} else {
				echo "یکی از فونت ها را انتخاب کنید.";
			}
		}
		if ( is_admin() ) {
			if ( $font_name = get_option( 'hwp_font' ) ) {
				if ( $font_name == 'shabnam' ) {
					$shf = 'checked="checked"';
				} elseif ( $font_name == 'sahel' ) {
					$mif = 'checked="checked"';
				}
			}
			echo
				'
				<div class="wrap">
				<h2>انتخاب فونت قالب</h2>
				<p>
					فونت مدنظرتان برای سایت را انتخاب کنید.
				</p>
				<form method="post">
		<div style="text-align: right;padding: 20px 0;border-radius: 3px;color: #333;">
			<input id="shabnam" name="font-name" type="radio"' . $shf . 'value="shabnam">
			<label for="shabnam">شبنم</label>
			<input id="sahel" name="font-name" type="radio"' . $mif . 'value="sahel" style="margin-right: 30px;">
			<label for="sahel">ساحل</label>
		</div>
		<br>
		<input type="submit" name="submit" value="تغییر فونت"
			   style="cursor: pointer;border: none;outline: none;background: #DF3550;padding: 8px 30px;display: inline-block;color: #fff;font-size: 16px;border-radius: 3px;">
	</form>
	</div>';
	}
}
if ( is_rtl() && ! is_admin() ) {

	if ( $font_name = get_option( 'hwp_font' ) ) {
		if ( $font_name == 'shabnam' ) {
			function hwp_theme_rtl() {
				wp_enqueue_style( 'shbnam-rtl', get_stylesheet_directory_uri() . '/rtl-shabnam.css', array(), '1.0.0', 'all' );
			}
		} elseif ( $font_name == 'sahel' ) {
			function hwp_theme_rtl() {
				wp_enqueue_style( 'shbnam-rtl', get_stylesheet_directory_uri() . '/rtl-sahel.css', array(), '1.0.0', 'all' );
			}
		}
	} else {
		function hwp_theme_rtl() {
			wp_enqueue_style( 'shbnam-rtl', get_stylesheet_directory_uri() . '/rtl-shabnam.css', array(), '1.0.0', 'all' );
		}
	}
	add_action( 'wp_enqueue_scripts', 'hwp_theme_rtl', 99 );
}
