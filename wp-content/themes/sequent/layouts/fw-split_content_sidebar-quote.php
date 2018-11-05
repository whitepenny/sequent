<?php
$quote = get_sub_field( 'quote' );
$image = get_sub_field( 'image' );

$background_options = sl_image_background_split_content_quote( $image['ID'] );
?>
<div class="fs-cell fs-lg-4 split_content_sidebar quote page_sidebar">
  <div class="split_content_sidebar_quote">
    <blockquote class="split_content_sidebar_blockquote">
      <p><?php echo $quote; ?></p>
    </blockquote>
    <span class="slant_side"></span>
    <span class="slant_bottom">
      <span class="background js-background" data-background-options="<?php echo sl_json_options( $background_options ); ?>"></span>
    </span>
  </div>
</div>
