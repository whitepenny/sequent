<?php
get_header();

if ( have_posts() ) :
  while ( have_posts() ) :
    the_post();

    $post_title = get_the_title();
    $post_image = get_field( 'post_image' );
    $post_author = get_the_author();
    $categories = get_the_term_list($post, 'resource_topic', '', ', ');

    $meta_parts = array();
    if ( ! empty( $categories ) ) {
      $meta_parts[] = $categories;
    }
    if ( ! empty( $post_author ) ) {
      $meta_parts[] = '<span>By</span> ' . get_the_author_posts_link();
    }

?>

<div class="fs-row padded_row fs-all-justify-between page_main post_detail">
  
  <div class="fs-cell fs-lg-8">
    <div class="resource_content">
      <h1><?php echo $post_title; ?></h1>
    </div>
  </div>
  <div class="fs-cell fs-md-5 fs-lg-8 page_container">
    <div class="page_content resource_content">


      
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
  <div class="fs-cell fs-lg-3">
    <div class="resource-sidebar">
    <h2>More Resources You Might Like</h2>
    <?php 
    $currentId = get_the_ID();
    $args = array(
      'post_type' => 'resource',
      'posts_per_page' => 4,
      'orderby' => 'menu_order',
      'order' => 'ASC',
      'post__not_in' => array($currentId),
    );

    $customQuery = new WP_Query( $args ); ?>



    <?php if($customQuery->have_posts()) : ?>

      <ul>
      <?php while($customQuery->have_posts()) : $customQuery->the_post(); ?>

      <li>
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
      </li>

      <?php endwhile; ?>
      </ul>
    <?php endif; ?>
    </div>
  </div>
</div>
<?php
  get_template_part( 'layouts/partial-newsletter_form' );

  endwhile;
endif;

get_footer();
