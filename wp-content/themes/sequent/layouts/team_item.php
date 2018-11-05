<?php
$image = get_field( 'image' );
$position = get_field( 'position' );
$intro = get_field( 'intro' );
$social_links = get_field( 'social' );
$link = get_the_permalink();
?>
<div class="team_item fs-cell fs-md-half fs-lg-third" data-checkpoint-animation="fade-up" data-checkpoint-container=".team_list">
  <?php if ( ! empty( $image ) ) : ?>
  <a href="<?php echo $link; ?>">
    <?php sl_responsive_image( sl_image_team_list( $image['ID'] ), 'team_item_image' ); ?>
  </a>
  <?php endif; ?>
  <div class="team_item_container">
    <h2 class="team_item_title">
      <a href="<?php echo $link; ?>"><?php the_title(); ?></a>
    </h2>
    <h3 class="team_position"><?php echo $position; ?></h3>
    <p class="team_intro"><?php echo $intro; ?></p>
    <a href="<?php echo $link; ?>" class="team_link">Read Bio</a>
    <?php if ( ! empty( $social_links ) ) : ?>
    <div class="team_social">
      <?php
        foreach ( $social_links as $social_link ) :
          if ( $social_link['service'] == 'Email' ) {
            $link = 'mailto:'.$social_link['link'];
            $target = '';
          } else {
            $link = $social_link['link'];
            $target = 'target="_blank"';
          }
      ?>
      <a href="<?php echo $link; ?>" class="team_social_link" <?php echo $target; ?>>
        <span class="post_social_link_icon">
          <span class="icon social_<?php echo strtolower( $social_link['service'] ); ?>_white"></span>
          <span class="screenreader"><?php echo $social_link['service']; ?></span>
        </a>
      </a>
      <?php
        endforeach;
      ?>
    </div>
    <?php endif; ?>
  </div>
</div>
