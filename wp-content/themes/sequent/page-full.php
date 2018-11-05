<?php
/*
Template Name: Full Width
*/

get_header();

if ( have_posts() ) :
  while ( have_posts() ) :
    the_post();

    $content = sl_get_the_content();
?>
<?php get_template_part( 'layouts/page_header' ); ?>
<?php if ( ! empty( $content ) ) : ?>
<div class="fs-row fs-all-justify-center page_main">
  <div class="fs-cell fs-lg-11 fs-xl-10 page_container page_container_full">
    <div class="page_content">
      <?php the_content(); ?>
    </div>
  </div>
</div>
<?php endif; ?>
<?php get_template_part( 'layouts/blocks', 'full_width' ); ?>
<?php
  endwhile;
endif;

get_footer();
