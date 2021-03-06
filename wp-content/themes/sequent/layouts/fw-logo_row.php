<?php
$title = get_sub_field( 'title' );
$logos = get_sub_field( 'logos' );
?>
<div class="logo_row" data-checkpoint-animation="fade-up">
  <div class="fs-row">
    <div class="fs-cell logo_row_cell">
      <?php if ( ! empty( $title ) ) : ?>
      <h2 class="logo_row_title"><?php echo $title; ?></h2>
      <?php endif; ?>
      <div class="logo_row_items">
        <?php
          foreach ( $logos as $logo ) :
            $file = sl_get_image( $logo['image']['ID'], 'scaled-xxsmall' );
        ?>
        <div class="logo_row_item">
          <img src="<?php echo $file['src']; ?>" alt="">
        </div>
        <?php
          endforeach;
        ?>
      </div>
    </div>
  </div>
</div>
