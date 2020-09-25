<?php
$type = get_sub_field( 'type' );
$format = get_sub_field( 'format' );
$layout = get_sub_field( 'layout' );

$tax_query = array();

if ( ! empty( $type ) ) {
  $tax_query[] = array(
    'taxonomy' => 'class_type',
    'field' => 'term_id',
    'terms' => array( $type->term_id ),
  );
}

if ( ! empty( $format ) ) {
  $tax_query[] = array(
    'taxonomy' => 'class_format',
    'field' => 'term_id',
    'terms' => array( $format->term_id ),
  );
}

$items = get_posts( array(
  'post_type' => 'class',
  'posts_per_page' => -1,
  'post_type' => 'class',
  'orderby' => 'menu_order',
  'order' => 'ASC',
  'tax_query' => $tax_query,
) );

if ( ! empty( $items ) ) :
  if ( $layout == 'list' ) :
?>
<div class="class_list list">
  <?php
    foreach ( $items as $item ) :
      $permalink = get_the_permalink( $item->ID );
      $title = get_the_title( $item->ID );
      $intro = get_field( 'intro', $item->ID );
      $register_link = get_field( 'register_link', $item->ID );
  ?>
  <div class="fs-row class_item" data-checkpoint-animation="fade-up" data-checkpoint-container=".class_list">
    <div class="fs-cell fs-md-2 fs-lg-6 class_item_header">
      <h2 class="class_item_title"><?php echo $title; ?></h2>
    </div>
    <div class="fs-cell fs-md-4 fs-lg-6 class_item_body">
      <div class="class_item_content">
        <p><?php echo $intro; ?></p>
      </div>
      <div class="class_item_buttons">
        <a href="<?php echo $permalink; ?>" class="class_item_button blue_lighter">View Class Details</a>
        <?php if ( ! empty( $register_link ) ) : ?>
        <a href="<?php echo $register_link['url']; ?>" class="class_item_button blue_light" target="<?php echo $register_link['target']; ?>"><?php echo $register_link['title']; ?></a>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <?php
    endforeach;
  ?>
</div>
<?php
    else:
?>
<div class="class_list grid section_padded">
  <div class="fs-row class_list_row" data-checkpoint-animation="fade-up" data-checkpoint-container=".class_list">

    <?php
      foreach ( $items as $item ) :
        $permalink = get_the_permalink( $item->ID );
        $title = get_the_title( $item->ID );
        $image = get_field( 'post_image', $item->ID );
        $intro = get_field( 'intro', $item->ID );
        $register_link = get_field( 'register_link', $item->ID );
    ?>
    <div class="fs-cell fs-md-3 fs-lg-4 class_item">
      <?php if ( ! empty( $image ) ) : ?>
      <a href="<?php echo $link; ?>">
        <?php sl_responsive_image( sl_image_post_list( $image['ID'] ), 'class_item_image' ); ?>
      </a>
      <?php endif; ?>
      <h2 class="class_item_title"><?php echo $title; ?></h2>
      <div class="class_item_content">
        <p><?php echo $intro; ?></p>
      </div>
      <div class="class_item_buttons">
        <a href="<?php echo $permalink; ?>" class="class_item_button blue_lighter">Learn More</a>
        <?php if ( ! empty( $register_link ) ) : ?>
        <a href="<?php echo $register_link['url']; ?>" class="class_item_button blue_light" target="<?php echo $register_link['target']; ?>"><?php echo $register_link['title']; ?></a>
        <?php endif; ?>
      </div>
    </div>
    <?php
      endforeach;
    ?>

  </div>
</div>
<?php
  endif;
endif;