<?php
if ( empty( $page_image ) ) :
  $post_type = sl_get_cpt();
  $cell_class = 'fs-md-5 fs-lg-9 fs-xl-8';

  if ( $post_type == 'post' ) {
    $cell_class = 'fs-lg-10';
  }
?>
<div class="page_header page_header_simple <?php if ( ! empty( $page_class ) ) echo $page_class; ?>">
  <div class="fs-row padded_row fs-all-justify-center page_header_row" data-checkpoint-animation="fade-up">
    <div class="fs-cell <?php echo $cell_class; ?> page_header_cell">
      <?php if ( ! empty( $page_meta ) ) : ?>
      <div class="page_meta">
        <?php echo $page_meta; ?>
      </div>
      <?php endif; ?>
      <h1 class="page_title"><?php echo sl_format_content( $page_title ); ?></h1>
      <?php if ( ! empty( $page_subtitle ) ) : ?>
      <p class="page_subtitle"><?php echo sl_format_content( $page_subtitle ); ?></p>
      <?php endif; ?>
      <?php if ( ! empty( $page_intro ) ) : ?>
      <div class="page_intro">
        <p><?php echo sl_format_content( $page_intro ); ?></p>
      </div>
      <?php endif; ?>
      <?php if ( ! empty( $page_content ) ) : ?>
      <div class="page_header_content page_content">
        <?php echo $page_content; ?>
      </div>
      <?php endif; ?>
      <?php if ( ! empty( $page_buttons ) ) : ?>
      <div class="page_header_buttons">
        <?php
          foreach ( $page_buttons as $page_button ) :
        ?>
        <a href="<?php echo $page_button['link']['url']; ?>" class="page_header_button <?php echo $page_button['color']; ?>" <?php echo $page_button['link']['target']; ?>><?php echo $page_button['link']['title']; ?></a>
        <?php
          endforeach;
        ?>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php
else :
  $background_options = sl_image_background_page_header( $page_image['ID'] );
?>
<div class="page_header page_header_image <?php if ( ! empty( $page_class ) ) echo $page_class; ?>">
  <div class="page_header_background js-background" data-background-options="<?php echo sl_json_options( $background_options ); ?>"></div>
  <div class="fs-row padded_row page_header_row" data-checkpoint-animation="fade-up">
    <!-- <div class="fs-cell fs-md-5 fs-lg-8 fs-xl-7 page_header_cell"> -->
    <div class="fs-cell fs-lg-12 fs-xl-10 page_header_cell">
      <span class="slant">
        <img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" alt="">
      </span>
      <?php if ( ! empty( $page_meta ) ) : ?>
      <div class="page_meta">
        <?php echo $page_meta; ?>
      </div>
      <?php endif; ?>
      <h1 class="page_title">
        <?php echo sl_format_content( $page_title ); ?>
      </h1>
      <?php if ( ! empty( $page_subtitle ) ) : ?>
      <p class="page_subtitle"><?php echo sl_format_content( $page_subtitle ); ?></p>
      <?php endif; ?>
      <?php if ( ! empty( $page_intro ) ) : ?>
      <div class="page_intro">
        <p><?php echo sl_format_content( $page_intro ); ?></p>
      </div>
      <?php endif; ?>
      <?php if ( ! empty( $page_buttons ) ) : ?>
      <div class="page_header_buttons">
        <?php
          foreach ( $page_buttons as $page_button ) :
        ?>
        <a href="<?php echo $page_button['link']['url']; ?>" class="page_header_button <?php echo $page_button['color']; ?>" <?php echo $page_button['link']['target']; ?>><?php echo $page_button['link']['title']; ?></a>
        <?php
          endforeach;
        ?>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php
endif;
