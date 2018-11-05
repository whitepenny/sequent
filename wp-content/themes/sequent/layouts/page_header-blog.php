<?php

$page_title = 'Insights';

if ( ! is_paged() && ! is_category() ) :
  if ( is_author() ) {
    $author_id = get_queried_object_id();

    $page_title = get_the_author_meta( 'display_name' );

    $post_image = get_field( 'image', 'user_' . $author_id );
    $post_intro = get_the_author_meta( 'description', $author_id );
  } else {
    $featured_posts = get_posts( array(
      'posts_per_page' => 1,
      'meta_query' => array(
        array(
          'key' => 'featured',
          'compare' => 'LIKE',
          'value' => 'on',
        ),
      ),
    ) );

    if ( ! empty( $featured_posts ) ) {
      $post = $featured_posts[0];

      $post_image = get_field( 'post_image', $post->ID );
      $post_title = get_the_title( $post->ID );
      $post_intro = strip_tags( sl_get_the_content( $post->ID ) );
      $post_intro = sl_trim_length( $post_intro, 200 );
      $post_link = get_the_permalink( $post->ID );
      $categories = get_the_category_list( ', ', $post->ID );

      $meta_parts = array();
      if ( ! empty( $categories ) ) {
        $meta_parts[] = $categories;
      }
    }
  }

  $background_options = sl_image_background_page_header( $post_image['ID'] );
?>
<div class="page_header post_list_header">
  <div class="post_list_header_image js-background" data-background-options="<?php echo sl_json_options( $background_options ); ?>"></div>
  <div class="fs-row padded_row fs-all-justify-end page_header_row" data-checkpoint-animation="fade-up">
    <div class="fs-cell fs-md-3 fs-lg-6 page_header_cell">
      <h1 class="page_title"><?php echo sl_format_content( $page_title ); ?></h1>
      <div class="post_item_container">
        <?php if ( ! empty( $meta_parts ) ) : ?>
        <div class="post_item_meta">
          <?php echo implode( ' &nbsp;|&nbsp; ', $meta_parts ); ?>
        </div>
        <?php endif; ?>
        <?php if ( ! empty( $post_title ) ) : ?>
        <h2 class="post_item_title"><?php echo $post_title; ?></h2>
        <?php endif; ?>
        <?php if ( ! empty( $post_intro ) ) : ?>
        <div class="post_item_content">
          <p><?php echo $post_intro; ?></p>
        </div>
        <?php endif; ?>
        <?php if ( ! empty( $post_link ) ) : ?>
        <a href="<?php echo $post_link; ?>" class="post_item_link">Read More</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php
else:
  if ( is_category() ) {
    $page_title = single_cat_title( '' , false );
  }

  sl_template_part( 'layouts/partial-page_header', array(
    'page_class' => 'post_detail',
    'page_title' => $page_title,
    // 'page_intro' => $page_intro,
    // 'page_image' => $page_image,
  ) );
endif;
