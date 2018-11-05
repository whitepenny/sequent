<?php
$label = get_sub_field( 'label' );
$title = get_sub_field( 'title' );
$content = get_sub_field( 'content' );
$steps = get_sub_field( 'steps' );
?>
<div class="step_content section_padded">
  <div class="fs-row padded_row fs-all-justify-center">
    <div class="fs-cell fs-md-5 fs-lg-8 step_content_header" data-checkpoint-animation="fade-up" data-checkpoint-container=".step_content">
      <?php if ( ! empty( $label ) ) : ?>
      <span class="step_content_label"><?php echo $label; ?></span>
      <?php endif; ?>
      <h2 class="step_content_title"><?php echo $title; ?></h2>
      <?php if ( ! empty( $content ) ) : ?>
      <div class="step_content_container">
        <p><?php echo $content; ?></p>
      </div>
      <?php endif; ?>
    </div>
  </div>
  <div class="fs-row padded_row step_content_items">
    <?php
      $i = 0;
      foreach ( $steps as $item ) :
        $i++;
    ?>
    <div class="fs-cell fs-xs-3 fs-sm-2 fs-md-2 fs-lg-4 step_item" data-checkpoint-animation="fade-up" data-checkpoint-container=".step_content">
      <span class="step_item_marker"><?php echo $i; ?><span></span></span>
      <div class="step_item_content">
        <p><?php echo $item['content']; ?></p>
      </div>
    </div>
    <?php
      endforeach;
    ?>
  </div>
</div>
