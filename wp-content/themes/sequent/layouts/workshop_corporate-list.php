<?php

$items = get_posts( array(
  'post_type' => 'corporate_workshop',
  'numberposts' => -1,
  'orderby' => 'menu_order',
  'order' => 'ASC',
) );

if ( ! empty( $items ) ) :
?>
<div class="fs-row workshop_list">
  <?php
    foreach ( $items as $post ) :
      setup_postdata( $post );

      get_template_part( 'layouts/workshop_corporate-item' );
    endforeach;

    wp_reset_postdata();
  ?>
</div>
<?php
else:
?>
<p>Sorry, no workshops found.</p>
<?php
endif;
