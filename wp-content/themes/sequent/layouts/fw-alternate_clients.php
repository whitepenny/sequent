<?php
$title = get_sub_field('client_list_title');
$group1 = get_sub_field( 'client_list_column_one' );
$group2 = get_sub_field( 'client_list_column_two' );
$group3 = get_sub_field( 'client_list_column_three' );
?>
<div class="client_list section_padded">
  <div class="fs-row padded_row" data-checkpoint-animation="fade-up">
    <div class="fs-cell">
      <h2 class="client_list_title"><?php echo $title; ?></h2>
    </div>
  </div>
  <div class="fs-row padded_row" data-checkpoint-animation="fade-up">
    
    <div class="fs-cell fs-md-4 fs-lg-4 alternate-clients">
      
        <?php echo $group1; ?>
      
    </div>

    <div class="fs-cell fs-md-4 fs-lg-4 alternate-clients">
      
        <?php echo $group2; ?>
      
    </div>

    <div class="fs-cell fs-md-4 fs-lg-4 alternate-clients">
      
        <?php echo $group3; ?>
      
    </div>
    
  </div>
</div>
