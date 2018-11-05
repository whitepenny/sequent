<?php
$label = get_sub_field( 'label' );
$title = get_sub_field( 'title' );
$content = get_sub_field( 'content' );
$button = get_sub_field( 'button' );
$image = get_sub_field( 'image' );

$background_options = sl_image_background_page_header( $image['ID'] );
?>
<div class="split_content image_block gravity_left js-background" data-background-options="<?php echo sl_json_options( $background_options ); ?>">
  <div class="section_padded">
    <div class="fs-row padded_row split_content_row image_block_row" data-checkpoint-animation="fade-up">
      <div class="fs-cell fs-lg-7 page_container split_content_container split_content_cell">
        <?php if ( ! empty( $label ) ) : ?>
        <span class="split_content_label image_block_label"><?php echo $label; ?></span>
        <?php endif; ?>
        <?php if ( ! empty( $title ) ) : ?>
        <h2 class="split_content_title image_block_title"><?php echo $title; ?></h2>
        <?php endif; ?>
        <div class="page_content image_block_content">
          <?php echo $content; ?>
        </div>
        <?php if ( ! empty( $button ) ) : ?>
        <a href="<?php echo $button['link']; ?>" class="image_block_button"><?php echo $button['title']; ?></a>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <?php sl_template_part( 'layouts/partial-home_block_footer', array( 'theme' => 'dark' ) ); ?>
</div>
