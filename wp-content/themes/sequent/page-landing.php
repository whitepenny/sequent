<?php
/*
Template Name: Landing
*/

get_header();



if ( have_posts() ) :
  while ( have_posts() ) :
    the_post();

        $form_title = get_field( 'form_title' );
        $form = get_field( 'gravity_form' );
?>
<?php get_template_part( 'layouts/blocks', 'full_width' ); ?>

<div class="form_block section_padded">
  <div class="fs-row fs-all-justify-center form_block_row">
    <div class="fs-cell fs-md-5 fs-lg-9 fs-xl-8 form_block_cell" data-checkpoint-animation="fade-up">
      <h2 class="form_block_title"><?php echo sl_format_content( $form_title ); ?></h2>
      <div class="form_block_container">
        <?php
          sl_template_part( 'layouts/partial-gravity_form', array(
            'form' => $form,
          ) );
        ?>
      </div>
    </div>
  </div>
</div>

<?php
  endwhile;
endif;

get_footer();
