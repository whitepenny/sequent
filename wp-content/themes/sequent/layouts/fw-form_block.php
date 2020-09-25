<?php
$title = get_sub_field( 'title' );
$form = get_sub_field( 'gravity_form' );
?>
<div class="form_block section_padded" id="form">
  <div class="fs-row fs-all-justify-center form_block_row">
    <div class="fs-cell fs-md-5 fs-lg-9 fs-xl-8 form_block_cell" data-checkpoint-animation="fade-up">
      <h2 class="form_block_title"><?php echo sl_format_content( $title ); ?></h2>
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
