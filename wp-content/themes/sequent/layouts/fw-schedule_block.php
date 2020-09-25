<?php
$label = get_sub_field( 'label' );
$title = get_sub_field( 'title' );
$content = get_sub_field( 'content' );
$image = get_sub_field( 'image' );
$schedule_label = get_sub_field( 'schedule_label' );

$sessions = get_posts( array(
  'post_type' => 'public_session',
  'posts_per_page' => 3,
  'meta_query' => array(
    array(
      'key' => 'end_date',
      'value' => date('Y-m-d'),
      'compare' => '>=',
      'type' => 'DATE',
    ),
  ),
) );

$background_options = sl_image_background_page_header( $image['ID'] );
?>
<div class="schedule_block">
  <div class="schedule_block_image js-background" data-background-options="<?php echo sl_json_options( $background_options ); ?>"></div>
  <div class="schedule_block_container">
    <div class="fs-row padded_row fs-all-align-end schedule_block_row" data-checkpoint-animation="fade-up">
      <div class="fs-cell fs-lg-6 schedule_block_header">
        <?php if ( ! empty( $label ) ) : ?>
        <span class="schedule_block_label"><?php echo $label; ?></span>
        <?php endif; ?>
        <?php if ( ! empty( $title ) ) : ?>
        <h2 class="schedule_block_title"><?php echo sl_format_content( $title ); ?></h2>
        <?php endif; ?>
        <div class="schedule_block_content">
          <p><?php echo $content; ?></p>
        </div>
      </div>
      <?php if ( ! empty( $schedule_label ) && ! empty( $sessions ) ) : ?>
      <div class="fs-cell fs-xs-3 fs-sm-2 fs-md-4 fs-lg-6">
        <span class="schedule_list_label"><?php echo $schedule_label; ?></span>
      </div>
      <?php endif; ?>
    </div>
    <?php if ( ! empty( $sessions ) ) : ?>
    <div class="fs-row padded_row schedule_list_items">
      <?php
        $link = sl_get_cpt_link( 'public_workshop' ) . '#schedule';

        foreach ( $sessions as $session ) :
          $location = get_field( 'location', $session->ID );
          $date = get_the_title( $session->ID );
      ?>
      <div class="fs-cell fs-md-2 fs-lg-4 schedule_item" data-checkpoint-animation="fade-up" data-checkpoint-container=".schedule_block_container">
        <a href="<?php echo $link; ?>" class="schedule_item_link">
          <h4 class="schedule_item_title"><?php echo $location; ?></h4>
          <span class="schedule_item_date"><?php echo $date; ?></span>
        </a>
      </div>
      <?php
        endforeach;
      ?>
    </div>
    <?php endif; ?>
  </div>
  <?php sl_template_part( 'layouts/partial-home_block_footer', array( 'theme' => 'dark' ) ); ?>
</div>
