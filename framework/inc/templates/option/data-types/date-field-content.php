<div class="tpl-datatype-container">

	<?php $option->form_field_prefix(); ?>

	<input <?php $option->print_form_ref(); ?>
		class="tpl-date-field"
		type="text"
		value="<?php echo esc_attr( $option->get_form_field_value() ); ?>"
		data-preview="1"
		autocomplete="off">

	<?php $option->form_field_suffix(); ?>

</div>
