<?php
$label = get_sub_field( 'label' );
$title = get_sub_field( 'title' );
$content = get_sub_field( 'content' );
$steps = get_sub_field( 'steps' );
$buttons = get_sub_field( 'buttons' );
?>
<div class="step_content step_block feature_block home_block">
  <div class="section_padded">
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
    <div class="fs-row fs-all-justify-center padded_row step_content_items">
      <?php
        $i = 0;
        foreach ( $steps as $item ) :
          $i++;
      ?>
      <div class="fs-cell fs-md-2 fs-lg-fifth step_item step_item_alt" data-checkpoint-animation="fade-up" data-checkpoint-container=".step_content">
        <span class="step_item_marker"><?php echo $i; ?><span></span></span>
        <span class="step_item_arrow"></span>
        <div class="step_item_content">
          <?php if ( ! empty( $item['title'] ) ) : ?>
          <h3 class="step_item_label"><?php echo $item['title']; ?></h3>
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
    <?php if ( ! empty( $buttons ) ) : ?>
    <div class="fs-row padded_row">
      <div class="fs-cell feature_block_buttons">
        <?php foreach ( $buttons as $button ) : ?>
        <a href="<?php echo $button['link']['url']; ?>" class="feature_block_button <?php echo $button['color']; ?>"><?php echo $button['link']['title']; ?></a>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>
  </div>
  <?php // get_template_part( 'layouts/partial-home_block_footer' ); ?>
</div>