<?php
$navigation_options = array(
  'label'    => false,
  'maxWidth' => '980px',
);

$social_links = get_field( 'global_social', 'option' );
?>
<div class="subnav_container">
  <button type="button" class="subnav_handle js-sub_nav_handle"><span></span>In This Section</button>
  <div class="subnav js-navigation" data-navigation-options="<?php echo sl_json_options( $navigation_options ); ?>" data-navigation-handle=".js-sub_nav_handle">
    <strong class="subnav_heading">Categories</strong>
    <ul>
      <?php wp_list_categories( array( 'depth' => 1, 'title_li' => '' ) ); ?>
    </ul>
  </div>
</div>
<div class="sidebar_social">
  <span class="sidebar_social_label">Follow Us</span>
  <?php foreach ( $social_links as $social_link ) : ?>
  <a href="<?php echo $social_link['link']; ?>" class="sidebar_social_link" target="_blank">
    <span class="screenreader"><?php echo $social_link['title']; ?></span>
    <span class="icon social_<?php echo strtolower( $social_link['service'] ); ?>_white"></span>
  </a>
  <?php endforeach; ?>
</div>
