<?php
get_header();

if ( have_posts() ) :
  while ( have_posts() ) :
    the_post();

    $content = sl_get_the_content();
?>
<?php get_template_part( 'layouts/page_header-class' ); ?>
<?php get_template_part( 'layouts/blocks', 'full_width' ); ?>
<?php
  endwhile;
endif;

get_footer();
