<?php

$items = get_posts( array(
  'post_type' => 'team',
  'numberposts' => -1,
  'orderby' => 'menu_order',
  'order' => 'ASC',
) );

if ( ! empty( $items ) ) :
?>
<div class="fs-row team_list">
  <?php
    foreach ( $items as $post ) :
      setup_postdata( $post );

      get_template_part( 'layouts/team_item' );
    endforeach;

    wp_reset_postdata();
  ?>
</div>
<?php
else:
?>
<p>Sorry, no team members found.</p>
<?php
endif;
