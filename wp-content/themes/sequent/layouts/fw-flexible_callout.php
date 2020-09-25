<?php
$gravity = get_sub_field( 'gravity' );
$image = get_sub_field( 'image' );
$title = get_sub_field( 'title' );
$content = get_sub_field( 'content' );
$button = get_sub_field( 'button' );

$media_class = ( $gravity == 'right' ) ? 'fs-md-last fs-lg-last' : '';
?>
<div class="flexible_callout gravity_<?php echo $gravity; ?>" data-checkpoint-animation="fade-up">
  <div class="fs-row flexible_callout_row">
    <div class="fs-cell fs-md-2 fs-lg-5 flexible_callout_media <?php echo $media_class; ?>">
      <?php if ( ! empty( $image ) ) : ?>
      <?php sl_responsive_image( sl_image_flexible_callout( $image['ID'] ), 'flexible_callout_image' ); ?>
      <?php endif; ?>
    </div>
    <div class="fs-cell fs-md-4 fs-lg-7 fs-all-align-center flexible_callout_body">
      <div class="flexible_callout_container">
        <h2 class="flexible_callout_title"><?php echo $title; ?></h2>
        <?php if ( ! empty( $content ) ) : ?>
        <div class="flexible_callout_content">
          <p><?php echo $content; ?></p>
        </div>
        <?php endif; ?>
        <?php if ( ! empty( $button ) ) : ?>
        <a href="<?php echo $button['url']; ?>" class="flexible_callout_button" target="<?php echo $button['target']; ?>"><?php echo $button['title']; ?></a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
