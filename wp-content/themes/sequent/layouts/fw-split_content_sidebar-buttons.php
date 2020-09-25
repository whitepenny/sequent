<?php
$buttons = get_sub_field( 'buttons' );
?>
<div class="fs-cell fs-lg-4 split_content_sidebar buttons page_sidebar">
  <div class="split_content_sidebar_buttons">
    <?php foreach ( $buttons as $button ) : ?>
    <a href="<?php echo $button['link']['url']; ?>" class="split_content_sidebar_button <?php echo $button['color']; ?>"><?php echo $button['link']['title']; ?></a>
    <?php endforeach; ?>
  </div>
</div>
