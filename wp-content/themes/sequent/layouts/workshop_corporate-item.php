<?php
$post_image = get_field( 'page_image' );
$intro = get_field( 'intro' );
?>
<div class="workshop_item fs-cell fs-md-3 fs-lg-4" data-checkpoint-animation="fade-up" data-checkpoint-container=".workshop_list">
  <?php if ( ! empty( $post_image ) ) : ?>
  <?php sl_responsive_image( sl_image_workshop_list( $post_image['ID'] ), 'workshop_item_image' ); ?>
  <?php endif; ?>
  <div class="workshop_item_container">
    <h2 class="workshop_item_title"><?php the_title(); ?></h2>
    <div class="workshop_item_content">
      <p><?php echo $intro; ?></p>
    </div>
    <a href="<?php the_permalink(); ?>" class="workshop_item_button">Learn More</a>
  </div>
</div>
