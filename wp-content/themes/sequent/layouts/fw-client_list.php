<?php
$title = get_sub_field( 'title' );
$groups = get_sub_field( 'groups' );
?>
<div class="client_list section_padded">
  <div class="fs-row padded_row" data-checkpoint-animation="fade-up">
    <div class="fs-cell">
      <h2 class="client_list_title"><?php echo $title; ?></h2>
    </div>
  </div>
  <div class="fs-row padded_row client_list_groups" data-checkpoint-animation="fade-up">
    <?php foreach ( $groups as $group ) : ?>
    <div class="fs-cell fs-md-3 fs-lg-4 client_list_group">
      <h3 class="client_list_label"><?php echo $group['label']; ?></h3>
      <ul class="client_list_items">
        <?php foreach ( $group['items'] as $item ) : ?>
        <li class="client_list_item"><?php echo $item['name']; ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endforeach; ?>
  </div>
</div>
