<div class="tpl-datatype-container">

	<input <?php $option->print_form_ref(); ?>
		class="tpl-color-field"
		type="text"
		value="<?php echo esc_attr( $option->get_form_field_value() ); ?>"
		data-preview="0"
		data-default-color="<?php echo esc_attr( $option->get_default() ); ?>">

</div>
