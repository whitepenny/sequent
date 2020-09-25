<?php

get_header();

get_template_part( 'layouts/page_header', 'blog' );

?>
<div class="fs-row padded_row page_main">
  <div class="fs-cell">
    <?php get_template_part( 'layouts/post_list' ); ?>
  </div>
</div>
<?php

get_footer();
