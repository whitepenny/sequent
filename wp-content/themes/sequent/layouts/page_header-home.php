<?php
$title = get_field( 'page_title' );
$intro = get_field( 'page_intro' );
$image = get_field( 'page_image' );

$background_options = sl_image_background_split_content_background( $image['ID'] );
?>
<div class="split_content home_header gravity_right section_padded bg_white" data-checkpoint-animation="fade-up">
  <div class="fs-row padded_row split_content_row">
    <div class="fs-cell fs-md-4 fs-lg-9 fs-xl-8 page_container split_content_container split_content_cell">
      <?php if ( ! empty( $title ) ) : ?>
      <h1 class="split_content_title"><?php echo sl_format_content( $title ); ?></h1>
      <?php endif; ?>
      <div class="page_content home_header_content">
        <?php echo $intro; ?>
      </div>
    </div>
    <div class="split_content_sidebar background split_content_sidebar_background js-background" data-background-options="<?php echo sl_json_options( $background_options ); ?>"></div>
  </div>
</div>
