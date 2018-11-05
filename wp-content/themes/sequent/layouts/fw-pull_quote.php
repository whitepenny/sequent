<?php
$quote = get_sub_field( 'quote' );
?>
<div class="pull_quote section_padded" data-checkpoint-animation="fade-up">
  <div class="fs-row fs-all-justify-center padded_row">
    <div class="fs-cell fs-lg-5 fs-lg-9">
      <blockquote class="pull_quote_blockquote">
        <p><?php echo sl_format_content( $quote ); ?></p>
      </blockquote>
    </div>
  </div>
</div>
