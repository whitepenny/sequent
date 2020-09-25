<?php

get_header();

$term_id = get_queried_object_id();

$post_title = single_cat_title( '', false );
$post_intro = category_description( $term_id );

sl_template_part( 'layouts/partial-page_header', array(
  'page_class' => 'team_list',
  'page_title' => $post_title,
  'page_intro' => $post_intro,
) );

?>
<div class="fs-row page_main">
  <div class="fs-cell">
    <?php get_template_part( 'layouts/team_list' ); ?>
  </div>
</div>
<?php

get_footer();
