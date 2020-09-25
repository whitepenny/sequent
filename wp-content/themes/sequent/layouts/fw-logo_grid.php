<?php
$title = get_sub_field( 'title' );
$content = get_sub_field( 'content' );
$label = get_sub_field( 'label' );
$logos = get_sub_field( 'logos' );
?>
<div class="split_content logo_grid gravity_right section_padded bg_white" data-checkpoint-animation="fade-up">
  <?php if ( ! empty( $title ) ) : ?>
  <div class="fs-row padded_row fs-lg-align-center split_content_row">
    <div class="fs-cell fs-lg-8 page_container split_content_cell">
      <h2 class="split_content_title"><?php echo $title; ?></h2>
    </div>
  </div>
  <?php endif; ?>
  <div class="fs-row padded_row split_content_row">
    <div class="fs-cell fs-lg-8 page_container split_content_container split_content_cell">
      <div class="page_content">
        <p class="intro"><?php echo $content; ?></p>
        <p><?php echo $label; ?></p>
      </div>
    </div>
  </div>
  <div class="fs-row padded_row logo_grid_items">
    <?php
      foreach ( $logos as $logo ) :
        $file = sl_get_image( $logo['image']['ID'], 'scaled-xxsmall' );
    ?>
    <div class="fs-cell fs-md-2 fs-lg-3 logo_grid_item">
      <img src="<?php echo $file['src']; ?>" alt="">
    </div>
    <?php
      endforeach;
    ?>
  </div>
</div>
