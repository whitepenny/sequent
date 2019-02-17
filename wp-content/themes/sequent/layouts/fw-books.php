<?php
$title = get_sub_field( 'title' );
$subtitle = get_sub_field( 'subtitle' );
$button = get_sub_field( 'button' );
$books = get_sub_field( 'books' );
?>
<div class="books_bar home_block">
  <div class="section_padded">
    <div class="fs-row padded_row books_bar_row">
      <div class="fs-cell fs-md-3 fs-lg-6 fs-md-last fs-lg-last books_bar_items_cell" data-checkpoint-animation="fade-up" data-checkpoint-container=".books_bar">
        <div class="books_bar_items">
          <?php
            foreach ( $books as $book ) :
              $image = sl_get_image( $book['image']['ID'], 'scaled-small' );
          ?>
          <figure class="books_bar_item">
            <img src="<?php echo $image['src']; ?>" alt="">
          </figure>
          <?php
            endforeach;
          ?>
        </div>
      </div>
      <div class="fs-cell fs-md-3 fs-lg-6" data-checkpoint-animation="fade-up" data-checkpoint-container=".books_bar">
        <h2 class="books_bar_title"><?php echo $title; ?></h2>
        <?php if ( ! empty( $subtitle ) ) : ?>
        <h3 class="books_bar_subtitle"><?php echo $subtitle; ?></h3>
        <?php endif; ?>
        <a href="<?php echo $button['url']; ?>" class="books_bar_button"><?php echo $button['title']; ?></a>
      </div>
    </div>
  </div>
</div>
