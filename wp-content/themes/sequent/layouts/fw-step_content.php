<?php
$background = get_sub_field( 'background' );
$label = get_sub_field( 'label' );
$title = get_sub_field( 'title' );
$content = get_sub_field( 'content' );
$steps = get_sub_field( 'steps' );

if ( empty( $background ) ) {
  $background = 'gray';
}
?>
<div class="step_content section_padded bg_<?php echo $background; ?>">
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
        <?php if ( ! empty( $item['label'] ) ) : ?>
        <h3 class="step_item_label"><?php echo $item['label']; ?></h3>
        <?php endif; ?>
        <p><?php echo $item['content']; ?></p>
        <?php if ( ! empty( $item['link'] ) ) : ?>
        <a href="<?php echo $item['link']['url']; ?>" class="step_item_link"><?php echo $item['link']['title']; ?></a>
        <?php endif; ?>
      </div>
    </div>
    <?php
      endforeach;
    ?>
  </div>
</div>
