<?php
/*
Template Name: Vertical
*/

get_header();



if ( have_posts() ) :
  while ( have_posts() ) :
    the_post();
?>

<div class="page_main vertical_main">
<div class="fs-row fs-lg-justify-between">
  <div class="fs-cell fs-lg-7">
    
    <div class="vertical_intro">
      
      <h1>
        <?php the_field('prehead'); ?>
        <span>
          <?php the_field('heading'); ?>
        </span>
      </h1>

    </div>

    <div class="vertical_content">
      <?php the_content(); ?>
    

    </div>
  </div>

  <div class="fs-cell fs-lg-4">
    <div class="sticky vertical_sidebar">
      <div class="vertical_sidebar--header">
        <i class="icon icon_calendar"></i> Schedule a Consultation
      </div>

      <?php $form_id = get_field('form_id'); ?>

      <?php echo do_shortcode( '[gravityform id="' . $form_id . '" title="false" description="false" ajax="true" tabindex="49" field_values="check=First Choice,Second Choice"]' ); ?>
    </div>
  </div>
</div>
</div>



<?php
  endwhile;
endif;

get_footer();
