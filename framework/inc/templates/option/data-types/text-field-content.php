<div class="tpl-datatype-container">

	<?php $option->form_field_prefix(); ?>

	<input <?php $option->print_form_ref(); ?>
		type="text"
		value="<?php echo esc_attr( $option->get_form_field_value() ); ?>"
		data-preview="1"
		<?php echo ( $option->get_size() > 0 ) ? ' maxlength="' . intval( $option->get_size() ) . '"' : ''; ?>
		<?php echo ( $option->get_placeholder() != '' ) ? ' placeholder="' . esc_attr( $option->get_placeholder() ) . '"' : ''; ?>>

	<?php $option->form_field_suffix(); ?>

</div>
