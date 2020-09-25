<?php
$title = get_sub_field( 'title' );
$buttons = get_sub_field( 'buttons' );
?>
<div class="promo_block section_padded" id="form">
  <div class="fs-row fs-all-justify-center promo_block_row">
    <div class="fs-cell fs-md-5 fs-lg-9 fs-xl-8 promo_block_cell" data-checkpoint-animation="fade-up">
      <h2 class="promo_block_title"><?php echo sl_format_content( $title ); ?></h2>
      <div class="promo_block_buttons">
        <?php foreach ( $buttons as $button ) : ?>
        <a href="<?php echo $button['link']['url']; ?>" class="promo_block_button <?php echo $button['color']; ?>"><?php echo $button['link']['title']; ?></a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>
