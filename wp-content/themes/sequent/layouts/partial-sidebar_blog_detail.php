<?php
$navigation_options = array(
  'label'    => false,
  'maxWidth' => '980px',
);

$social_links = get_field( 'global_social', 'option' );

$posts = get_posts( array(
  'posts_per_page' => 5,
) );
?>
<div class="subnav_container">
  <button type="button" class="subnav_handle js-sub_nav_handle"><span></span>In This Section</button>
  <div class="subnav js-navigation" data-navigation-options="<?php echo sl_json_options( $navigation_options ); ?>" data-navigation-handle=".js-sub_nav_handle">
    <strong class="subnav_heading">Recent Posts</strong>
    <ul>
      <?php foreach ( $posts as $post ) : ?>
      <li>
        <a href="<?php echo get_the_permalink( $post->ID ); ?>"><?php echo $post->post_title; ?></a>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>
<div class="sidebar_social">
  <span class="sidebar_social_label">Follow Us</span>
  <?php foreach ( $social_links as $social_link ) : ?>
  <a href="<?php echo $social_link['link']; ?>" class="sidebar_social_link" target="_blank">
    <span class="screenreader"><?php echo $social_link['service']; ?></span>
    <span class="icon social_<?php echo strtolower( $social_link['service'] ); ?>_white"></span>
  </a>
  <?php endforeach; ?>
</div>
