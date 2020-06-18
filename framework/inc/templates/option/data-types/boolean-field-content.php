<div class="tpl-datatype-container">

	<label class="checked-<?php echo $option->get_form_field_value(); ?>">
		<input <?php $option->print_form_ref(); ?>
			type="hidden"
			value="<?php echo esc_attr( $option->get_form_field_value() ); ?>"
			data-preview="0">
	</label>

</div>
