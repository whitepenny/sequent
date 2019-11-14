<?php 
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$args = array(
  'post_type' => 'resource',
  'posts_per_page' => -1,
  'orderby' => 'menu_order',
  'order' => 'ASC',
  'paged' => $paged,
);

$customQuery = new WP_Query( $args ); ?>



<?php if($customQuery->have_posts()) : ?>
<div class="fs-row">
    
  
    <?php while($customQuery->have_posts()) : $customQuery->the_post(); ?>

      <?php get_template_part( 'layouts/resource_item' ); ?>

    <?php endwhile; 
      
    ?>    
    
    <div class="post_pagination fs-cell" data-checkpoint-animation="fade-up" data-checkpoint-container=".post_list">
      <?php 

        $big = 999999999; // need an unlikely integer
        $pages = paginate_links( array(
          'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
          'format' => '?paged=%#%',
          'current' => max( 1, get_query_var('paged') ),
          'total' => $customQuery->max_num_pages,
          'type'  => 'array',
          'prev_next'   => true,
          'prev_text'    => __('<span class="icon arrow_link_left"></span> Previous'),
          'next_text'    => __('Next <span class="icon arrow_link_right"></span>'),
        ) );

        if( is_array( $pages ) ) {
          $pagination = '<div class="pagination">';
          foreach ( $pages as $page ) {
            $pagination .= "$page";
          }
          $pagination .= '</div>';

        
            echo $pagination;

        }
      ?>
    </div>

    <?php wp_reset_postdata(); ?>


</div>

<?php
else:
?>
<p>Sorry, no resources found.</p>
<?php
endif;
