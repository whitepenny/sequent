<?php
$navigation_options = array(
  'label'    => false,
  'maxWidth' => '980px',
);
?>
<div class="subnav_container">
  <button type="button" class="subnav_handle js-sub_nav_handle"><span></span>In This Section</button>
  <div class="subnav js-navigation" data-navigation-options="<?php echo sl_json_options( $navigation_options ); ?>" data-navigation-handle=".js-sub_nav_handle">
    <?php sl_sub_navigation( 99 ); ?>
  </div>
</div>
