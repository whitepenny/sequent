<?php

$page_title = 'Insights';
if ( is_home() ) {
  $page_id = get_option( 'page_for_posts' );
} else {
  $page_id = get_the_ID();
}
$page_image = get_field( 'page_image', $page_id );
$background_options = sl_image_background_page_header( $page_image['ID'] );

if ( ! is_paged() && ! is_category() ) :
  if ( is_author() ) {
    $author_id = get_queried_object_id();
    $page_title = get_the_author_meta( 'display_name' );
    $post_image = get_field( 'image', 'user_' . $author_id );
    $post_intro = get_the_author_meta( 'description', $author_id );
  } 
  $background_options = sl_image_background_page_header( $post_image['ID'] );
?>

<?php 
sl_template_part( 'layouts/partial-page_header', array(
    'page_title' => $page_title,
    'page_image' => $page_image,
  ) ); ?>

<?php
else:
  if ( is_category() ) {
    $page_title = single_cat_title( '' , false );
    $page_for_posts = get_option( 'page_for_posts' );
    $page_image = get_field( 'page_image', $page_for_posts );
  }

  sl_template_part( 'layouts/partial-page_header', array(
    'page_title' => $page_title,
    'page_image' => $page_image,
    // 'page_intro' => $page_intro,
    // 'page_image' => $page_image,
  ) );
endif;
