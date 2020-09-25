<?php
$title = get_sub_field( 'title' );
$videos = get_sub_field( 'videos' );
?>
<div class="video_row section_padded">
  <div class="fs-row padded_row fs-all-justify-center" data-checkpoint-animation="fade-up">
    <div class="fs-cell">
      <h2 class="video_row_title"><?php echo $title; ?></h2>
    </div>
    <?php foreach ( $videos as $video ) : ?>
    <div class="fs-cell fs-md-4 fs-lg-4 video_row_item">
      <div class="video_row_media">
        <div class="video_wrapper">
          <?php echo $video['embed']; ?>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>
