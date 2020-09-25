<?php

$items = get_posts( array(
  'post_type' => 'public_workshop',
  'numberposts' => -1,
  'orderby' => 'menu_order',
  'order' => 'ASC',
  'meta_query' => array(
    'relation' => 'OR',
		array(
			'key'     => 'hide_in_list',
			'value'   => 'on',
			'compare' => 'NOT LIKE'
		),
    array(
			'key'     => 'hide_in_list',
			'value'   => 'on',
			'compare' => 'NOT EXISTS'
		),
	),
) );

if ( ! empty( $items ) ) :
?>
<div class="fs-row fs-all-justify-center workshop_list workshop_grid bg_white">
  <?php
    foreach ( $items as $post ) :
      setup_postdata( $post );

      get_template_part( 'layouts/workshop_public-item' );
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
