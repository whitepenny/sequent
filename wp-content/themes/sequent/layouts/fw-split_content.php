<?php
$gravity = get_sub_field( 'gravity' );
$background = get_sub_field( 'background' );
$label = get_sub_field( 'label' );
$title = get_sub_field( 'title' );
$content = get_sub_field( 'content' );

if ( empty( $background ) ) {
  $background = 'white';
}
?>
<div class="split_content gravity_<?php echo $gravity; ?> section_padded bg_<?php echo $background; ?>" data-checkpoint-animation="fade-up">
  <div class="fs-row padded_row split_content_row">
    <?php
      if ( have_rows( 'sidebar' ) ) :
        while ( have_rows( 'sidebar' ) ) :
          the_row();

          get_template_part( 'layouts/fw-split_content_sidebar', get_row_layout() );
        endwhile;
      endif;
    ?>
    <div class="fs-cell fs-lg-8 page_container split_content_container split_content_cell">
      <?php if ( ! empty( $label ) ) : ?>
      <span class="split_content_label"><?php echo $label; ?></span>
      <?php endif; ?>
      <?php if ( ! empty( $title ) ) : ?>
      <h2 class="split_content_title"><?php echo $title; ?></h2>
      <?php endif; ?>
      <div class="page_content">
        <?php echo $content; ?>
      </div>
    </div>
  </div>
</div>
