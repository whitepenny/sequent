<?php

$page_id = get_the_ID();

$page_type = 'image';
$page_subtitle = '';
$page_title = get_the_title( $page_id );
$page_intro = get_field( 'intro', $page_id );
$page_image = get_field( 'post_image', $page_id );


$formats = get_the_terms( $page_id, 'class_format' );
if ( ! empty( $formats ) ) {
  $page_subtitle = $formats[0]->name;
}

sl_template_part( 'layouts/partial-page_header', array(
  'page_type' => $page_type,
  'page_meta' => $page_subtitle,
  'page_title' => $page_title,
  'page_intro' => $page_intro,
  'page_image' => $page_image,
) );