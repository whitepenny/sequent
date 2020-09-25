<?php

$header_transparent = false;

require_once 'includes/config.php';
require_once 'includes/post-types.php';
require_once 'includes/utils.php';
require_once 'includes/utils-admin.php';
require_once 'includes/utils-images.php';
require_once 'includes/utils-image-sizes.php';

// Hide ACF on production

// if ( ! SL_DEV ) {
//   add_filter( 'acf/settings/show_admin', '__return_false' );
// }

// Init

function sl_init() {
  add_theme_support( 'title-tag' );

  $theme_dir = get_template_directory();
  $theme_uri = get_template_directory_uri();

  define( 'SL_THEME_DIR', $theme_dir );
  define( 'SL_THEME_URI', $theme_uri );

  // Disable rando feeds

  remove_action( 'wp_head', 'rsd_link' );
  remove_action( 'wp_head', 'wlwmanifest_link' );
  remove_action( 'wp_head', 'wp_shortlink_wp_head' );
  remove_action( 'wp_head', 'wp_generator');
  remove_action( 'wp_head', 'rest_output_link_wp_head' );
  remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
  remove_action( 'wp_head', 'wp_oembed_add_host_js' );
  remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );
  remove_action( 'wp_head', 'feed_links_extra', 3);

  // Menus
  register_nav_menu( 'main-navigation', __( 'Main Navigation' ) );
  register_nav_menu( 'footer-navigation', __( 'Footer Navigation' ) );

  // Options Page
  if ( function_exists( 'acf_add_options_page' ) ) {
    $option_page = acf_add_options_page( array(
      'page_title' => 'Theme Settings',
      'menu_title' => 'Theme Settings',
      'menu_slug'  => 'theme-settings',
      'capability' => 'list_users',
      'redirect'   => false,
    ) );
  }
}
add_action( 'init', 'sl_init', 0 );

function sl_acf_init() {
	acf_update_setting( 'google_api_key', 'xxx' );
}
add_action( 'acf/init', 'sl_acf_init' );

function sl_enqueue_resources() {
  global $wp_styles, $wp_scripts;

  // Styles
  wp_enqueue_style( 'gl-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700', array(), null, 'all' );
  wp_enqueue_style( 'gl-site', SL_THEME_URI . '/public/css/site.css', array(), SL_VERSION, 'all' );

  // // Scripts - Head
  wp_enqueue_script( 'gl-modernizr', SL_THEME_URI . '/public/js/modernizr.js', array(), SL_VERSION, false );

  // Move jQuery to footer
  // wp_deregister_script( 'jquery' );
  // wp_register_script( 'jquery', includes_url( '/js/jquery/jquery.js' ), false, null, true );
  // wp_enqueue_script( 'jquery' );
  wp_register_script( 'jquery', includes_url( '/js/jquery/jquery.js' ), false, null, false );

  // Scripts - Foot
  wp_enqueue_script( 'gl-site', SL_THEME_URI . '/public/js/site.js', array( 'jquery' ), SL_VERSION, true );
}

add_action( 'wp_enqueue_scripts', 'sl_enqueue_resources' );


// Remove random Boilerplate

function disable_emojicons_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
    return array();
  }
}

function sl_disable_wp_emojicons() {
  // remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  // remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  // remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

  add_filter( 'emoji_svg_url', '__return_false' );
  // add_filter( 'tiny_mce_plugins', 'sl_disable_emojicons_tinymce' );
}
add_action( 'init', 'sl_disable_wp_emojicons' );


// Favicons

function sl_favicons() {
  $file = SL_THEME_DIR . '/assets/faviconData.json';

  if ( file_exists( $file ) ) {
    $json = json_decode( file_get_contents( $file ) , true);
    echo str_ireplace( 'public/', SL_THEME_URI . '/public/', $json['favicon']['html_code'] );
  }
}


// Remove Gravity Forms Styles/Scripts

function sl_deregister_gravity_forms_resources() {
  wp_deregister_style( 'gforms_formsmain_css' );
  wp_deregister_style( 'gforms_reset_css' );
  wp_deregister_style( 'gforms_ready_class_css' );
  wp_deregister_style( 'gforms_browsers_css' );

  wp_deregister_script( 'gforms_conditional_logic_lib' );
  wp_deregister_script( 'gforms_ui_datepicker' );
  wp_deregister_script( 'gforms_gravityforms' );
  wp_deregister_script( 'gforms_character_counter' );
  wp_deregister_script( 'gforms_json' );
  //wp_deregister_script("jquery");
}
add_action( 'gform_enqueue_scripts', 'sl_deregister_gravity_forms_resources' );

add_filter( 'gform_confirmation_anchor', '__return_true' );
add_filter( 'gform_init_scripts_footer', '__return_true' );
add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );


// Gravity Forms button
function sl_gform_submit_button( $button, $form ) {
  return '<button class="button" id="gform_submit_button_' . $form['id'] . '"><span>Submit</span></button>';
}
add_filter( 'gform_submit_button', 'sl_gform_submit_button', 10, 2 );

function sl_gform_submit_button_consultation( $button, $form ) {
  return '<button class="button" id="gform_submit_button_' . $form['id'] . '"><span>Schedule a Consultation</span></button>';
}

add_filter( 'gform_submit_button_12', 'sl_gform_submit_button_consultation', 10, 2 );

// Pagination

function sl_pagination( $echo = true ) {
	global $wp_query;

	$big = 999999999; // need an unlikely integer

	$pages = paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, get_query_var('paged') ),
		'total' => $wp_query->max_num_pages,
		'type'  => 'array',
		'prev_next'   => true,
		'prev_text'    => __('<span class="icon arrow_link_left"></span> Previous'),
		'next_text'    => __('Next <span class="icon arrow_link_right"></span>'),
	) );

	if( is_array( $pages ) ) {
		$paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
		$pagination = '<div class="pagination">';
		foreach ( $pages as $page ) {
			$pagination .= "$page";
		}
		$pagination .= '</div>';

		if ( $echo ) {
			echo $pagination;
		} else {
			return $pagination;
		}
	}
}


// Excerpt More

function sl_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'sl_excerpt_more' );


//  Pullquote Shortcode

function sl_shortcode_pullquote( $attributes, $quote = '' ) {
  extract( shortcode_atts( array(
    'author' => '',
    'image' => '',
  ), $attributes ) );

  ob_start();
  ?>
  <div class="breakout_full">
    <blockquote class="pullquote">
      <p class="pullquote_quote"><?php echo $quote; ?></p>
    </blockquote>
  </div>
  <?php
  $html = ob_get_clean();

  return $html;
}
add_shortcode( 'pullquote', 'sl_shortcode_pullquote' );
