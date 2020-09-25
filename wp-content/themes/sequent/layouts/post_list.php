<?php
$categories = get_categories( array(
  'hide_empty' => false,
) );

if ( is_category() ) {
  $active_category = get_queried_object_ID();
}

if ( have_posts() ) :
?>
<div class="fs-row post_list">
  <div class="fs-cell">
    <select class="post_list_select js-jump_select">
      <option value="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>">All Posts</option>
      <?php foreach ( $categories as $category ) : ?>
      <option value="<?php echo get_category_link( $category->term_id ); ?>" <?php if ( $active_category == $category->term_id ) echo 'selected="selected"'?>><?php echo $category->name; ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <?php
    while ( have_posts() ) :
      the_post();
      get_template_part( 'layouts/post_item' );
    endwhile;
  ?>
  <div class="post_pagination fs-cell" data-checkpoint-animation="fade-up" data-checkpoint-container=".post_list">
    <?php sl_pagination(); ?>
  </div>
</div>
<?php
else:
?>
<p>Sorry, no posts found.</p>
<?php
endif;
