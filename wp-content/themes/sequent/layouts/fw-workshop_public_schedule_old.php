<?php

$hide_title = get_sub_field( 'hide_title' );
$hide_button = get_sub_field( 'hide_button' );
$button = get_sub_field( 'button' );

if ( is_post_type_archive( 'public_workshop' ) ) {
  $hide_button = array( 'on' );
}

$button_link = sl_get_cpt_link( 'public_workshop' );

$sessions = get_posts( array(
  'post_type' => 'public_session',
  'posts_per_page' => -1,
  'meta_query' => array(
    array(
      'key' => 'end_date',
      'value' => date('Y-m-d'),
      'compare' => '>=',
      'type' => 'DATE',
    ),
  ),
) );

$workshops = get_posts( array(
  'post_type' => 'public_workshop',
  'posts_per_page' => -1,
  'orderby' => 'menu_order',
  'order' => 'ASC',
) );

?>
<div class="public_schedule section_padded" data-checkpoint-animation="fade-up" id="schedule">
  <div class="fs-row">
    <div class="fs-cell">
      <?php if ( empty( $hide_title ) || $hide_title[0] != 'on' ) : ?>
      <h2 class="public_schedule_title">Public Workshops</h2>
      <?php endif; ?>
      <div class="schedule_table">
        <div class="schedule_table_header">
          <div class="schedule_table_handle"></div>
          <?php
            foreach ( $workshops as $workshop ) :
              $w_title = get_the_title( $workshop->ID );
              $w_label = get_field( 'label', $workshop->ID );
              $w_price = get_field( 'price', $workshop->ID );
          ?>
          <div class="schedule_table_workshop">
            <span class="label"><?php echo $w_label; ?></span>
            <span class="title"><?php echo $w_title; ?></span>
            <span class="price"><?php echo $w_price; ?></span>
          </div>
          <?php
            endforeach;
          ?>
        </div>
        <div class="schedule_table_rows">
          <?php
            $swap_options = array(
              'maxWidth' => '980px',
            );

            $i = 0;
            foreach ( $sessions as $session ) :
              $i++;

              $title = get_the_title( $session->ID );
              $location = get_field( 'location', $session->ID );
              $instances = get_field( 'session_workshops', $session->ID );
          ?>
          <div class="schedule_table_row schedule_swap_<?php echo $i; ?>">
            <div class="schedule_table_handle js-swap" data-swap-target=".schedule_swap_<?php echo $i; ?>" data-swap-options="<?php echo sl_json_options( $swap_options ); ?>">
              <h3 class="schedule_table_title"><?php echo $title; ?></h3>
              <span class="schedule_table_location"><?php echo $location; ?></span>
            </div>
            <?php
              foreach ( $workshops as $workshop ) :
                $active_instance = false;

                foreach ( $instances as $instance ) {
                  if ( $instance['session_workshop'] == $workshop->ID ) {
                    $active_instance = $instance;
                    break;
                  }
                }

                if ( ! empty( $active_instance ) ) :
                  $w_title = get_the_title( $workshop->ID );
                  $w_label = get_field( 'label', $workshop->ID );
                  $w_price = get_field( 'price', $workshop->ID );

                  $link = $active_instance['link'];
            ?>
            <div class="schedule_table_instance">
              <div class="schedule_table_workshop">
                <span class="label"><?php echo $w_label; ?></span>
                <span class="title"><?php echo $w_title; ?></span>
                <span class="price"><?php echo $w_price; ?></span>
              </div>
              <a href="<?php echo $link; ?>" class="schedule_table_button" target="_blank">Register</a>
            </div>
            <?php
                endif;
              endforeach;
            ?>
          </div>
          <?php
            endforeach;
          ?>
        </div>
      </div>
      <?php if ( empty( $hide_button ) || $hide_button[0] != 'on' ) : ?>
      <div class="public_schedule_footer">
        <?php if ( ! empty( $button ) ) : ?>
        <a href="<?php echo $button['url']; ?>" class="public_schedule_button" target="<?php echo $button['target']; ?>"><?php echo $button['title']; ?></a>
        <?php else: ?>
        <a href="<?php echo $button_link; ?>" class="public_schedule_button">Learn About Public Workshops</a>
        <?php endif; ?>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>
