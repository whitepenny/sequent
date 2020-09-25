<?php
if ( ! empty( $form ) && function_exists( 'gravity_form' ) ) :
?>
<div class="gravityform_block">
  <div class="gravityform_block_container gravityform_container" data-checkpoint-animation="fade-up">
    <?php gravity_form( $form, false, false ); ?>
  </div>
</div>
<?php
endif;
