<?php
get_header();

if ( have_posts() ) :
  while ( have_posts() ) :
    the_post();

    $content = sl_get_the_content();
?>
<?php get_template_part( 'layouts/page_header' ); ?>
<?php // if ( ! empty( $content ) ) : ?>
<div class="fs-row padded_row page_main">
  <div class="fs-cell fs-lg-last fs-lg-justify-end fs-lg-4 page_sidebar">
    <?php get_template_part( 'layouts/partial', 'sidebar' ); ?>
  </div>
  <div class="fs-cell fs-lg-8 page_container">
    <div class="page_content">
      <?php the_content(); ?>
    </div>
  </div>
</div>
<?php // endif; ?>
<?php get_template_part( 'layouts/blocks', 'full_width' ); ?>
<?php
  endwhile;
endif;

get_footer();
