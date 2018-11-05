<?php
if ( empty( $theme ) ) {
  $theme = 'light';
}

$footer_label = get_sub_field( 'footer_label' );
$footer_posts = get_sub_field( 'footer_posts' );
?>
<?php if ( ! empty( $footer_label ) && ! empty( $footer_posts ) ) : ?>
<div class="home_block_footer theme_<?php echo $theme; ?>">
  <h4 class="home_block_footer_label"><?php echo $footer_label; ?></h4>
  <?php
    foreach ( $footer_posts as $footer_post ) :
  ?>
  <a href="<?php echo get_the_permalink( $footer_post->ID ); ?>" class="home_block_footer_link"><?php echo get_the_title( $footer_post->ID ); ?></a>
  <?php
    endforeach;
  ?>
</div>
<?php endif; ?>
