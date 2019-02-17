<?php
$gravity = 'left';
$background = 'gray';
$image = get_sub_field( 'image' );
$title = get_sub_field( 'title' );
$content = get_sub_field( 'content' );

$background_options = sl_image_background_split_content_quote( $image['ID'] );
?>
<div class="cube_callout split_content gravity_<?php echo $gravity; ?> section_padded bg_<?php echo $background; ?>" data-checkpoint-animation="fade-up">
  <div class="fs-row padded_row split_content_row">
    <div class="fs-cell fs-lg-5 split_content_sidebar heading page_sidebar">
      <div class="split_content_sidebar_quote">
        <h2 class="split_content_sidebar_heading">
          <span><?php echo $title; ?></span>
        </h2>
        <span class="slant_side"></span>
        <span class="slant_bottom">
          <span class="background js-background" data-background-options="<?php echo sl_json_options( $background_options ); ?>"></span>
        </span>
      </div>
    </div>
    <div class="fs-cell fs-lg-6 page_container split_content_container split_content_cell">
      <div class="page_content">
        <?php echo $content; ?>
      </div>
    </div>
  </div>
</div>
