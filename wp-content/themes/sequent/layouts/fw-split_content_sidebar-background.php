<?php
$image = get_sub_field( 'image' );

$background_options = sl_image_background_split_content_background( $image['ID'] );
?>
<div class="split_content_sidebar background split_content_sidebar_background js-background" data-background-options="<?php echo sl_json_options( $background_options ); ?>"></div>
