<?php
$post_image = get_field( 'post_image' );
$categories = get_the_category_list( ', ' );
$link = get_the_permalink();
?>
<div class="post_item fs-cell fs-md-half fs-lg-third" data-checkpoint-animation="fade-up" data-checkpoint-container=".post_list">
  <?php if ( ! empty( $post_image ) ) : ?>
  <a href="<?php echo $link; ?>">
    <?php sl_responsive_image( sl_image_post_list( $post_image['ID'] ), 'post_item_image' ); ?>
  </a>
  <?php endif; ?>
  <div class="post_item_container">
    <div class="post_item_meta">
      <?php echo $categories; ?>
    </div>
    <h2 class="post_item_title">
      <a href="<?php echo $link; ?>"><?php the_title(); ?></a>
    </h2>
    <div class="post_item_content">
      <p><?php echo sl_trim_length( strip_tags( get_the_excerpt() ), 200 ); ?></p>
    </div>
    <a href="<?php echo $link; ?>" class="post_item_link">Read More</a>
  </div>
</div>
