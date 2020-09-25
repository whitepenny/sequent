<?php

$post_type = sl_get_cpt();
$page_id = sl_get_cpt_page( $post_type );

$page_title = get_field( 'page_title', $page_id );
$page_intro = get_field( 'page_intro', $page_id );
$page_image = get_field( 'page_image', $page_id );
$page_buttons = get_field( 'page_buttons', $page_id );

sl_template_part( 'layouts/partial-page_header', array(
  'page_title' => $page_title,
  'page_intro' => $page_intro,
  'page_image' => $page_image,
  'page_buttons' => $page_buttons,
  // 'page_class' => 'page_header_' . $post_type,
) );
