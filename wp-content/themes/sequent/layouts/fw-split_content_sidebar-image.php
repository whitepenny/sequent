<?php
$image = get_sub_field( 'image' );
?>
<div class="fs-cell fs-lg-4 split_content_sidebar image page_sidebar">
  <div class="split_content_sidebar_image">
    <?php echo sl_responsive_image( sl_image_split_content_sidebar( $image['ID'] ) ); ?>
  </div>
</div>
