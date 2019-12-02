<?php
$videos = get_sub_field( 'videos' );
?>

  <div class="fs-row padded_row wistia-videos" data-checkpoint-animation="fade-up">
    <?php foreach ( $videos as $video ) : ?>
    <div class="fs-cell fs-md-6 fs-lg-6 wistia-video">
      
          <h2><?php echo $video['title']; ?></h2>
          <?php echo $video['video']; ?>
      
      
    </div>
    <?php endforeach; ?>

</div>
