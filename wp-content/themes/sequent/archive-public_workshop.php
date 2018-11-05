<?php

get_header();

get_template_part( 'layouts/page_header', 'schedule' );

?>
<div class="fs-row padded_row page_main">
  <div class="fs-cell">
    <?php get_template_part( 'layouts/workshop_public-list' ); ?>
  </div>
</div>
<?php get_template_part( 'layouts/fw-workshop_public_schedule' ); ?>
<?php

get_footer();
