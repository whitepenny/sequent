<?php

// ADMIN

function sl_admin_init() {
  add_editor_style( 'style-admin.css' );
}
add_action( 'admin_init', 'sl_admin_init' );

function sl_admin_head() {
  $screen = get_current_screen();

  // Callouts
  $post_types = array(
    'callout',
  );

  if ( is_object( $screen ) && in_array( $screen->post_type, $post_types) ) {
    ?>
    <style>
      #titlewrap { height: 0px !important; overflow: hidden !important; }
      #post-body-content { margin-bottom: 1px !important; }
    </style>
    <?php
  }

  // ACF Content Editor
  ?>
  <script>
    (function($) {
      $(document).ready(function() {
        var fields = [
          ".acf-field-5adba8b1f0c91",
        ];
        var $postContent = $( fields.join(", ") );

        if ( $postContent.length ) {
          $postContent.find(".acf-input").append( $("#postdivrich") );
        }

        $(".acf-field.readonly select").attr("tabindex", "-1");
      });
    })(jQuery);
  </script>
  <style type="text/css">
    .acf-field #wp-content-editor-tools {
      background: transparent;
      padding-top: 0;
    }

    .acf-field.readonly {
      pointer-events: none !important;
    }
    .acf-field.readonly .select2-selection {
      border: none !important;
    }
    .acf-field.readonly .select2-selection__arrow {
      display: none !important;
    }
  </style>
  <?php
}
add_action( 'admin_head', 'sl_admin_head' );


// Set menu order

function sl_admin_menu_order() {
  global $menu;

  $pages_position    = 0;
  $posts_position    = 0;
  $comments_position = 0;
  $media_position    = 0;
  $gf_position       = 0;
  $callouts_position = 0;

  foreach ( $menu as $position => $item ) {
    if ( $item[0] == 'Pages' ) {
      $pages_position = $position;
    }
    if ( $item[0] == 'Posts' ) {
      $posts_position = $position;
    }
    if ( $item[2] == 'edit-comments.php' ) {
      $comments_position = $position;
    }
    if ( $item[2] == 'upload.php' ) {
      $media_position = $position;
    }
    if ( $item[2] == 'gf_edit_forms' ) {
      $gf_position = $position;
    }
  }

  // Move Pages Up
  $menu[ $posts_position - 1 ] = $menu[ $pages_position ];
  unset( $menu[ $pages_position ] );

  // Remove Posts
  // unset( $menu[ $posts_position ] );
  // Rename Posts
  $menu[ $posts_position ][0] = 'Blog';

  // Remove Comments
  unset( $menu[ $comments_position ] );

  // Move Gravity Forms down
  $menu['39'] = $menu[ $gf_position ];
  unset( $menu[ $gf_position ] );

  // Move Media down
  $menu['40'] = $menu[ $media_position ];
  unset( $menu[ $media_position ] );
}
add_action( 'admin_menu', 'sl_admin_menu_order', 999 );


// TinyMCE Styles

function sl_mce_buttons( $buttons ) {
  $blocks = array_shift( $buttons );

  array_unshift( $buttons, 'styleselect' );
  array_unshift( $buttons, $blocks );

	return $buttons;
}
add_filter( 'mce_buttons', 'sl_mce_buttons' );

function sl_tiny_mce_before_init( $opts ) {
	$opts['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;Pre=pre';

	$style_formats = array(
		array(
			'title' => 'Intro Paragraph',
			'block' => 'p',
			'classes' => 'intro',
		),
    // array(
		// 	'title' => 'Highlight',
		// 	'inline' => 'span',
		// 	'classes' => 'highlight',
		// ),
    // array(
		// 	'title' => 'Label',
		// 	'block' => 'h4',
		// 	'classes' => 'label',
		// ),
    array(
			'title' => 'Button - Blue',
			'inline' => 'a',
			'classes' => 'button_blue',
		),
    array(
			'title' => 'Button - Light Blue',
			'inline' => 'a',
			'classes' => 'button_blue_light',
		),
    array(
			'title' => 'Button - Sky Blue',
			'inline' => 'a',
			'classes' => 'button_blue_lighter',
		),
	);

	$opts['style_formats'] = json_encode( $style_formats );

	return $opts;
}
add_filter( 'tiny_mce_before_init', 'sl_tiny_mce_before_init' );


// Modify ACF JSON directory

function sl_acf_json_save_directory( $path ) {
  $path = get_stylesheet_directory() . '/fields';

  return $path;
}
add_filter( 'acf/settings/save_json', 'sl_acf_json_save_directory' );

function sl_acf_json_load_directory( $paths ) {
    unset($paths[0]);
    $paths[] = get_stylesheet_directory() . '/fields';

    return $paths;
}
add_filter( 'acf/settings/load_json', 'sl_acf_json_load_directory' );


// Populate gravity forms in ACF

function sl_populate_gravity_forms_select( $field ) {
  $field['choices'] = array();

  if ( class_exists( 'GFAPI' ) ) {
    $forms = GFAPI::get_forms();

    foreach ( $forms as $form ) {
      $field['choices'][ $form['id'] ] = $form['title'];
    }
  }

  return $field;
}
add_filter( 'acf/load_field/name=gravity_form', 'sl_populate_gravity_forms_select' );
add_filter( 'acf/load_field/name=global_newsletter_form', 'sl_populate_gravity_forms_select' );
add_filter( 'acf/load_field/name=footer_gravity_form', 'sl_populate_gravity_forms_select' );


// Pre Load Workshop Session Links

function sl_load_value_session_workshops( $value, $post_id, $field ) {
  if ( empty( $value ) ) {
    $value = array();
  }

  $parsed = array();

  $workshops = get_posts( array(
    'post_type' => 'public_workshop',
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC',
  ) );

  foreach ( $workshops as $workshop ) {
    $existing = false;

    foreach ( $value as $v ) {
      if ( ! empty( $v['field_5bb8ef24aaf5b'] ) && $v['field_5bb8ef24aaf5b'] == $workshop->ID ) {
        $existing = $v;
        break;
      }
    }

    if ( ! empty( $existing ) ) {
      $parsed[] = $existing;
    } else {
      $parsed[] = array(
        'field_5bb8ef24aaf5b' => $workshop->ID,
        'field_5bb8ef3daaf5c' => '',
      );
    }
  }

  return $parsed;
}
add_filter( 'acf/load_value/name=session_workshops', 'sl_load_value_session_workshops', 10, 3 );


// Populate color in ACF

// function sl_populate_color_select( $field ) {
//   $field['choices'] = array(
//     'red' => 'Red',
//     'blue' => 'Blue',
//   );
//
//   return $field;
// }
// add_filter( 'acf/load_field/name=color', 'sl_populate_color_select' );



function sl_populate_image_dimensions( $field ) {
  if ( ! empty( $field['min_width'] ) && ! empty( $field['min_height'] ) ) {
    // if ( ! empty( $field['instructions'] ) ) {
    //   $field['instructions'] .= ' ';
    // }
    $field['instructions'] = '';

    $field['instructions'] .= 'Min ' . $field['min_width'] . 'x' . $field['min_height'] . 'px';
  }

  return $field;
}
add_filter( 'acf/load_field/type=image', 'sl_populate_image_dimensions' );
