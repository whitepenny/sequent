<?php
/*
Template Name: Contact
*/

get_header();

if ( have_posts() ) :
  while ( have_posts() ) :
    the_post();

    $page_title = get_field( 'page_title', $page_id );
    $page_intro = get_field( 'page_intro', $page_id );
    $page_image = get_field( 'page_image', $page_id );

    if ( empty( $page_title ) ) {
      $page_title = get_the_title( $page_id );
    }

    sl_template_part( 'layouts/partial-page_header', array(
      'page_class' => 'contact_page',
      'page_title' => $page_title,
      'page_intro' => $page_intro,
      'page_image' => $page_image,
    ) );

    $address_title = get_field( 'address_title' );
    $content = get_field( 'content' );
    $image = get_field( 'image' );
    $form_title = get_field( 'form_title' );
    $form = get_field( 'gravity_form' );

    $background_options = sl_image_background_contact( $image['ID'] );
?>
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
<div class="address_block section_padded">
  <div class="address_block_background js-background" data-background-options="<?php echo sl_json_options( $background_options ); ?>"></div>
  <div class="fs-row padded_row address_block_row" data-checkpoint-animation="fade-up">
    <div class="fs-cell fs-md-3 fs-lg-5 fs-lg-push-1 fs-xl-4 fs-xl-push-2 address_block_cell">
      <h2 class="address_block_title"><?php echo $address_title; ?></h2>
      <div class="address_block_content page_content">
        <?php echo $content; ?>
      </div>
    </div>
  </div>
</div>

<?php
  endwhile;
endif;

get_footer();
