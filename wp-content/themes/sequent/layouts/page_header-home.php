<?php
$title = get_field( 'page_title' );
$intro = get_field( 'page_intro' );
$image = get_field( 'page_image' );
$buttons = get_field( 'page_buttons' );

$background_options = sl_image_background_page_header( $image['ID'] );
?>
<div class="split_content home_header js-background" data-background-options="<?php echo sl_json_options( $background_options ); ?>">
  <div class="fs-row padded_row split_content_row home_header_row">
    <div class="fs-cell fs-md-5 fs-lg-9 fs-xl-8 page_container split_content_container split_content_cell">
      <?php if ( ! empty( $title ) ) : ?>
      <h1 class="split_content_title"><?php echo sl_format_content( $title ); ?></h1>
      <?php endif; ?>
      <div class="page_content home_header_content">
        <p><?php echo $intro; ?></p>
      </div>
      <div class="home_header_buttons">
        <?php foreach ( $buttons as $button ) : ?>
        <a href="<?php echo $button['link']['url']; ?>" class="home_header_button <?php echo $button['color']; ?>"><?php echo $button['link']['title']; ?></a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>
