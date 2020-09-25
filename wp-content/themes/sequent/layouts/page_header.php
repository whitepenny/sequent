<?php

if ( is_home() ) {
  $page_id = get_option( 'page_for_posts' );
} else {
  $page_id = get_the_ID();
}

$page_type = get_field( 'page_header_type', $page_id );
$page_subtitle = get_field( 'page_subtitle', $page_id );
$page_title = get_field( 'page_title', $page_id );
$page_intro = get_field( 'page_intro', $page_id );
$page_image = get_field( 'page_image', $page_id );
$page_buttons = get_field( 'page_buttons', $page_id );
$page_form_title = get_field( 'page_form_title', $page_id );
$page_form = get_field( 'page_gravity_form', $page_id );

if ( empty( $page_title ) ) {
  $page_title = get_the_title( $page_id );
}

sl_template_part( 'layouts/partial-page_header', array(
  'page_type' => $page_type,
  'page_meta' => $page_subtitle,
  'page_title' => $page_title,
  'page_intro' => $page_intro,
  'page_image' => $page_image,
  'page_buttons' => $page_buttons,
  'page_form_title' => $page_form_title,
  'page_form' => $page_form,
) );
