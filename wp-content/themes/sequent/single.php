<?php
get_header();

if ( have_posts() ) :
  while ( have_posts() ) :
    the_post();

    $post_title = get_the_title();
    $post_image = get_field( 'post_image' );
    $post_author = get_the_author();
    $categories = get_the_category_list( ', ' );

    $meta_parts = array();
    if ( ! empty( $categories ) ) {
      $meta_parts[] = $categories;
    }
    if ( ! empty( $post_author ) ) {
      $meta_parts[] = '<span>By</span> ' . get_the_author_posts_link();
    }

    sl_template_part( 'layouts/partial-page_header', array(
      'page_class' => 'post_detail',
      'page_meta' => implode( ' &nbsp;|&nbsp; ', $meta_parts ),
      'page_title' => $post_title,
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

      <div class="post_social addthis_toolbox">
        <div class="post_social_label">
          <span>Share This</span>
        </div>
        <a class="post_social_link facebook addthis_button_facebook">
          <span class="post_social_link_icon">
            <span class="icon social_facebook_white"></span>
          </span>
          <span class="screenreader">Facebook</span>
        </a>
        <a class="post_social_link twitter addthis_button_twitter">
          <span class="post_social_link_icon">
            <span class="icon social_twitter_white"></span>
          </span>
          <span class="screenreader">Twitter</span>
        </a>
        <a class="post_social_link linkedin addthis_button_linkedin">
          <span class="post_social_link_icon">
            <span class="icon social_linkedin_white"></span>
          </span>
          <span class="screenreader">LinkedIn</span>
        </a>
        <a class="post_social_link email addthis_button_email">
          <span class="post_social_link_icon">
            <span class="icon social_email_white"></span>
          </span>
          <span class="screenreader">Email</span>
        </a>
      </div>
      <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid="></script>
    </div>
  </div>
</div>
<?php
  get_template_part( 'layouts/partial-newsletter_form' );

  endwhile;
endif;

get_footer();
