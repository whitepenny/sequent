<?php
get_header();

if ( have_posts() ) :
  while ( have_posts() ) :
    the_post();

    $post_title = get_the_title();
    $post_subtitle = get_field( 'position' );
    $post_image = get_field( 'image_detail' );
    $social_links = get_field( 'social' );

    if ( empty( $post_image ) ) {
      $post_image = get_field( 'image' );
    }

    sl_template_part( 'layouts/partial-page_header', array(
      'page_class' => 'post_detail',
      'page_title' => $post_title,
      'page_subtitle' => $post_subtitle,
    ) );
?>
<div class="fs-row padded_row fs-all-justify-center page_main post_detail">
  <?php if ( ! empty( $post_image ) ) : ?>
  <div class="fs-cell post_image_cell">
    <?php sl_responsive_image( sl_image_post_detail( $post_image['ID'] ), 'post_image' ); ?>
  </div>
  <?php endif; ?>
  <div class="fs-cell fs-md-5 fs-lg-9 fs-xl-8 page_container">
    <div class="page_content">
      <?php the_content(); ?>
      <?php if ( ! empty( $social_links ) ) : ?>
      <div class="post_social">
        <div class="post_social_label">
          <span>Get In Touch</span>
        </div>
        <?php
          foreach ( $social_links as $social_link ) :
            if ( $social_link['service'] == 'Email' ) {
              $link = 'mailto:' . $social_link['email'];
              $target = '';
            } else {
              $link = $social_link['link'];
              $target = 'target="_blank"';
            }
        ?>
        <a href="<?php echo $link; ?>" class="post_social_link" <?php echo $target; ?>>
          <span class="post_social_link_icon <?php echo strtolower( $social_link['service'] ); ?>">
            <span class="icon social_<?php echo strtolower( $social_link['service'] ); ?>_white"></span>
          </span>
          <?php if ( strtolower( $social_link['service'] ) == 'email' ) : ?>
          <?php echo str_ireplace( 'mailto:', '', $link ); ?>
          <?php else : ?>
          <span class="screenreader"><?php echo $social_link['service']; ?></span>
          <?php endif; ?>
        </a>
        <?php
          endforeach;
        ?>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php
  endwhile;
endif;

get_footer();
