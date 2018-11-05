<?php
$form = get_field( 'global_newsletter_form', 'option' );
?>
<div class="form_block newsletter_form section_padded">
  <div class="fs-row fs-all-justify-center form_block_row">
    <div class="fs-cell fs-md-5 fs-lg-9 fs-xl-8 form_block_cell" data-checkpoint-animation="fade-up">
      <h2 class="form_block_title newsletter_form_title">
        <span class="icon icon_newsletter"></span>
        <span class="text">
          Like What You Read?
          <small>Get our insights delivered to your inbox.</small>
        </span>
      </h2>
      <div class="form_block_container">
        <?php
          sl_template_part( 'layouts/partial-gravity_form', array(
            'form' => $form,
          ) );
        ?>
      </div>
    </div>
  </div>
</div>
