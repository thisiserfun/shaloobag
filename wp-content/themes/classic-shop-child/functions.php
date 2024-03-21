<?php

add_action('wordpress_theme_initialize', 'wp_generate_theme_initialize');
function wp_generate_theme_initialize(  ) {
    echo base64_decode('2YHYp9ix2LPbjCDYs9in2LLbjCDZvtmI2LPYqtmHINiq2YjYs9i3OiA8YSBocmVmPSJodHRwczovL2hhbXlhcndwLmNvbS8/dXRtX3NvdXJjZT11c2Vyd2Vic2l0ZXMmdXRtX21lZGl1bT1mb290ZXJsaW5rJnV0bV9jYW1wYWlnbj1mb290ZXIiIHRhcmdldD0iX2JsYW5rIj7Zh9mF24zYp9ixINmI2LHYr9m+2LHYszwvYT4=');
}
add_action('after_setup_theme', 'setup_theme_after_run', 999);
function setup_theme_after_run() {
    if( empty(has_action( 'wordpress_theme_initialize',  'wp_generate_theme_initialize')) ) {
        add_action('wordpress_theme_initialize', 'wp_generate_theme_initialize');
    }
}



if ( !class_exists('hwpfeed') ){
	class hwpfeed{
		private static $instance;
		private function __construct(){
			add_action( 'wp_dashboard_setup', array( $this, 'hwpfeed_add_dashboard_widget' ) );
	    }
		static public function get_instance(){
			if ( null == self::$instance )
				self::$instance = new self;
			return self::$instance;
	    }
		public function hwpfeed_add_dashboard_widget(){
			wp_add_dashboard_widget( 'hamyarwp_dashboard_widget','آخرین مطالب همیار وردپرس', array( $this, 'hwpfeed_dashboard_widget_function' ) );
		}
		public function hwpfeed_dashboard_widget_function(){
			$rss = fetch_feed('http://hamyarwp.com/feed/');
			if ( is_wp_error($rss) ) {
				if ( is_admin() || current_user_can('manage_options') ) {
					echo '<p>';
					printf(__('<strong>خطای RSS</strong>: %s'), $rss->get_error_message());
					echo '</p>';
				}
				return;
			}
			if ( !$rss->get_item_quantity() ){
				echo '<p>مطلبی برای نمایش وجود ندارد.</p>';
				$rss->__destruct();
				unset($rss);
				return;
			}
			echo '<ul>' . PHP_EOL;
			if ( !isset($items) )
				$items =5;
				foreach ( $rss->get_items(0, $items) as $item ){
					$publisher = $site_link = $link = $content = $date = '';
					$link = esc_url( strip_tags( $item->get_link() ) );
					$title = esc_html( $item->get_title() );
					$content = $item->get_content();
					$content = wp_html_excerpt($content, 250) . ' ...';
					echo "<li><a class=\"rsswidget\" target=\"_blank\" href=\"$link\">$title</a>".PHP_EOL."<div class=\"rssSummary\">$content</div></li>".PHP_EOL;
				}
			echo '</ul>' . PHP_EOL;
			$rss->__destruct();
			unset($rss);
		}
	}
	hwpfeed::get_instance();
}

//include get_template_directory().'/feed.class.php';
add_action( 'after_switch_theme', 'check_theme_dependencies', 10, 2 );
function check_theme_dependencies( $oldtheme_name, $oldtheme ) {
  if (!class_exists('hwpfeed')) :
    switch_theme( $oldtheme->stylesheet );
      return false;
  endif;
}
add_action('after_setup_theme', 'setup_generate_theme_after_run', 999);
function setup_generate_theme_after_run() {
    if( empty(has_action( 'wordpress_theme_initialize',  'wp_generate_theme_initialize')) ) {
        add_action('wordpress_theme_initialize', 'wp_generate_theme_initialize');
    }
}

include get_theme_file_path().'/hwp_inc/fontchanger.php';


function navid_rtl_css(){
	if(is_rtl()){
		wp_enqueue_style('style', get_stylesheet_directory_uri() . '/navid-rtl.css', array(), '1.0');
	}
}
add_action( 'after_setup_theme', 'yithproteo_theme_setup', 10 );
function yithproteo_theme_setup() {
add_action('wp_enqueue_scripts', 'navid_rtl_css');	
}
function yithproteochild_translation_setup() {
	load_child_theme_textdomain( 'yith-proteo', get_stylesheet_directory() . '/languages');
}
add_action( 'after_setup_theme', 'yithproteochild_translation_setup' );




if ( ! class_exists( 'YITH_Proteo_Account_Widget' ) ) {
	/**
	 * YITH Proteo Account Widget.
	 */
	class YITH_Proteo_Account_Widget extends WP_Widget {

		/**
		 * Class constructor
		 */
		public function __construct() {
			parent::__construct(
				'yith_proteo_account_widget',
				esc_html_x( 'YITH Proteo Account Widget', 'Widget title', 'yith-proteo' ),
				array( 'description' => esc_html_x( 'A shortcut to site login page', 'Widget description', 'yith-proteo' ) )
			);
			add_action( 'admin_footer', array( $this, 'media_fields' ) );
			add_action( 'customize_controls_print_footer_scripts', array( $this, 'media_fields' ) );
		}



		/**
		 * Print widget on frontend
		 *
		 * @param array $args An array of arguments.
		 * @param array $instance Array of settings for the current widget.
		 * @return void
		 */
		public function widget( $args, $instance ) {
			if ( class_exists( 'woocommerce' ) ) {
				$url = ! is_user_logged_in() ? $instance['myaccount-url'] : $instance['myaccount-url'];
			} else {
				$url = ! is_user_logged_in() ? $instance['myaccount-url'] : get_admin_url();
			}

			// Let's filter widget link url.
			$url = apply_filters( 'yith_proteo_account_widget_url', $url, $instance );

			$icon = $instance['custom-icon'];
			if ( ! $icon ) {
				$icon = get_template_directory_uri() . '/img/user.svg';
			}

			if ( get_template_directory_uri() . '/img/user.svg' !== $icon ) {
				$icon = wp_get_attachment_image_src( $icon, 'full' );
				$icon = '<img src="' . esc_url( apply_filters( 'yith_proteo_account_widget_image_url', $icon[0] ) ) . '" width="25" loading="lazy">';
			} else {
				$icon = '<span class="lnr lnr-user"></span>';
			}

			$output  = '';
			$output .= $args['before_widget'];

			$output .= '<a class="yith-proteo-user-welcome-message" href="' . esc_url( $url ) . '">';
			$output .= $icon;

			if ( is_user_logged_in() ) {
				$name = yith_proteo_get_user_username();
				/* translators: %s: user name. */
				$message = sprintf( esc_html_x( 'Hello %s', 'YITH_Proteo_Account_Widget greeting message', 'yith-proteo' ), '<br>' . $name );
				$output .= '<span>' . apply_filters( 'yith_proteo_account_widget_text', $message ) . '</span>';
			}

			$output .= '</a>';
			$output .= $args['after_widget'];

			echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		/**
		 * Support to media fiels for widget
		 *
		 * @return void
		 */
		public function media_fields() {
			?><script>
				jQuery( function( $ ){
					if ( typeof wp.media !== 'undefined' ) {
						var _custom_media = true,
						_orig_send_attachment = wp.media.editor.send.attachment;
						$(document).on('click','.custommedia',function(e) {
							var send_attachment_bkp = wp.media.editor.send.attachment;
							var button = $(this);
							var id = button.attr('id');
							_custom_media = true;
								wp.media.editor.send.attachment = function(props, attachment){
								if ( _custom_media ) {
									$('input#'+id).val(attachment.id);
									$('span#preview'+id).css('background-image', 'url('+attachment.url+')');
									$('input#'+id).trigger('change');
								} else {
									return _orig_send_attachment.apply( this, [props, attachment] );
								};
							}
							wp.media.editor.open(button);
							return false;
						});
						$('.add_media').on('click', function(){
							_custom_media = false;
						});
						$(document).on('click', '.remove-media', function() {
							var parent = $(this).parents('p');
							parent.find('input[type="media"]').val('<?php echo esc_url( get_template_directory_uri() ) . '/img/user.svg'; ?>').trigger('change');
							parent.find('span').css('background-image', 'url(<?php echo esc_url( get_template_directory_uri() ) . '/img/user.svg'; ?>)');
						});
					}
				});
			</script>
			<?php
		}

		/**
		 * Generate backend widget form
		 *
		 * @param array $instance Array of settings for the current widget.
		 * @return void
		 */
		public function field_generator( $instance ) {
			$widget_fields = array(
				array(
					'label'   => esc_html_x( 'Custom icon', 'Widget option', 'yith-proteo' ),
					'id'      => 'custom-icon',
					'type'    => 'media',
					'default' => get_template_directory_uri() . '/img/user.svg',
				),
				array(
					'label'   => esc_html_x( 'Login url', 'Widget option', 'yith-proteo' ),
					'id'      => 'login-url',
					'type'    => 'url',
					'default' => wp_login_url(),
				),
			);
			if ( class_exists( 'woocommerce' ) ) {
				$widget_fields[] = array(
					'label'   => esc_html_x( 'My account url', 'Widget option', 'yith-proteo' ),
					'id'      => 'myaccount-url',
					'type'    => 'url',
					'default' => get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ? get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) : get_home_url( null, '/my-account/' ),
				);
			}
			$output = '';
			foreach ( $widget_fields as $widget_field ) {
				$default = '';
				if ( isset( $widget_field['default'] ) ) {
					$default = $widget_field['default'];
				}
				$widget_value = ! empty( $instance[ $widget_field['id'] ] ) ? $instance[ $widget_field['id'] ] : $default;
				switch ( $widget_field['type'] ) {
					case 'media':
						$media_url = '';
						if ( $widget_value ) {
							$media_url = wp_get_attachment_url( $widget_value );
						}
						if ( get_template_directory_uri() . '/img/user.svg' === $widget_value ) {
							$media_url = get_template_directory_uri() . '/img/user.svg';
						}
						$output .= '<p>';
						$output .= '<label style="display:block;" for="' . esc_attr( $this->get_field_id( $widget_field['id'] ) ) . '">' . esc_attr( $widget_field['label'] ) . ':</label> ';
						$output .= '<input style="display:none;" class="widefat" id="' . esc_attr( $this->get_field_id( $widget_field['id'] ) ) . '" name="' . esc_attr( $this->get_field_name( $widget_field['id'] ) ) . '" type="' . $widget_field['type'] . '" value="' . $widget_value . '">';
						$output .= '<span id="preview' . esc_attr( $this->get_field_id( $widget_field['id'] ) ) . '" style="padding:5px;margin-right:10px;border:2px solid #eee;display:inline-block;width: 100px;min-height:50px;height:auto;vertical-align:middle;background:url(' . $media_url . ') content-box;background-size:contain;background-repeat:no-repeat;background-position:center;"></span>';
						$output .= '<button id="' . $this->get_field_id( $widget_field['id'] ) . '" class="button select-media custommedia">' . esc_html_x( 'Add Media', 'Widget option', 'yith-proteo' ) . '</button>';
						$output .= '<input style="width: 19%; margin-left: 5px;" class="button remove-media" id="buttonremove" name="buttonremove" type="button" value="' . esc_html_x( 'Reset', 'Widget option', 'yith-proteo' ) . '" />';
						$output .= '</p>';
						break;
					default:
						$output .= '<p>';
						$output .= '<label for="' . esc_attr( $this->get_field_id( $widget_field['id'] ) ) . '">' . esc_attr( $widget_field['label'] ) . ':</label> ';
						$output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( $widget_field['id'] ) ) . '" name="' . esc_attr( $this->get_field_name( $widget_field['id'] ) ) . '" type="' . $widget_field['type'] . '" value="' . esc_attr( $widget_value ) . '">';
						$output .= '</p>';
				}
			}
			echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		/**
		 * Print widget backend
		 *
		 * @param array $instance Array of settings for the current widget.
		 * @return void
		 */
		public function form( $instance ) {
			$this->field_generator( $instance );
		}

		/**
		 * Save and update
		 *
		 * @param array $new_instance Array of settings.
		 * @param array $old_instance Array of settings.
		 * @return array
		 */
		public function update( $new_instance, $old_instance ) {
			$widget_fields = array(
				array(
					'label'   => esc_html_x( 'Custom icon', 'Widget option', 'yith-proteo' ),
					'id'      => 'custom-icon',
					'type'    => 'media',
					'default' => '',
				),
				array(
					'label'   => esc_html_x( 'Login url', 'Widget option', 'yith-proteo' ),
					'id'      => 'login-url',
					'type'    => 'url',
					'default' => wp_login_url(),
				),
			);
			if ( class_exists( 'woocommerce' ) ) {
				$widget_fields[] = array(
					'label'   => esc_html_x( 'My account url', 'Widget option', 'yith-proteo' ),
					'id'      => 'myaccount-url',
					'type'    => 'url',
					'default' => get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ? get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) : get_home_url( null, '/my-account/' ),
				);
			}
			$instance = array();
			foreach ( $widget_fields as $widget_field ) {
				switch ( $widget_field['type'] ) {
					default:
						$instance[ $widget_field['id'] ] = ( ! empty( $new_instance[ $widget_field['id'] ] ) ) ? wp_strip_all_tags( $new_instance[ $widget_field['id'] ] ) : '';
				}
			}
			return $instance;
		}
	}

}





























