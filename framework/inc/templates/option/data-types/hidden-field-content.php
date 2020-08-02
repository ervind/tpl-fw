<div class="tpl-datatype-container">

	<input <?php $option->print_form_ref(); ?>
		type="hidden"
		value="<?php echo esc_attr( $option->get_form_field_value() ); ?>">

</div>
