<?php $option->editor_switch_buttons(); ?>
<div class="tpl-textarea-wrapper tpl-datatype-container">

	<?php $option->form_field_prefix(); ?>

	<textarea <?php $option->print_form_ref(); ?>
		data-preview="1"
		rows="<?php echo esc_attr( $option->get_size() ); ?>"
		><?php echo esc_textarea( $option->get_form_field_value() ); ?></textarea>

	<?php $option->form_field_suffix(); ?>

</div>
