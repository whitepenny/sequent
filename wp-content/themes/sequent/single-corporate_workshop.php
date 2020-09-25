<?php
get_header();

if ( have_posts() ) :
  while ( have_posts() ) :
    the_post();

    $content = sl_get_the_content();

    $page_title = get_the_title();
    $page_image = get_field( 'page_image' );

    sl_template_part( 'layouts/partial-page_header', array(
      'page_title' => $page_title,
      'page_image' => $page_image,
    ) );
?>
<?php get_template_part( 'layouts/blocks', 'full_width' ); ?>
<?php
  endwhile;
endif;

get_footer();
