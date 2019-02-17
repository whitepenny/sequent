<?php
$title = get_sub_field( 'title' );
$image = get_sub_field( 'image' );

$background_options = sl_image_background_split_content_quote( $image['ID'] );
?>
<div class="fs-cell fs-lg-4 split_content_sidebar heading page_sidebar">
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
