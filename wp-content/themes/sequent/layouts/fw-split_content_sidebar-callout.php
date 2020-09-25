<?php
$title = get_sub_field( 'title' );
$content = get_sub_field( 'content' );
?>
<div class="fs-cell fs-lg-4 split_content_sidebar callout page_sidebar">
  <div class="split_content_sidebar_callout">
    <h3 class="split_content_sidebar_callout_title"><?php echo $title; ?></h3>
    <div class="split_content_sidebar_callout_content">
      <p><?php echo $content; ?></p>
    </div>
  </div>
</div>
