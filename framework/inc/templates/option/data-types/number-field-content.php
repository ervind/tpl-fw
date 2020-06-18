<div class="tpl-datatype-container">

	<?php $option->form_field_prefix(); ?>

	<input <?php $option->print_form_ref(); ?>
		type="number"
		value="<?php echo esc_attr( $option->get_form_field_value() ); ?>"
		data-preview="1"
		<?php echo ( $option->get_step() > 0 ) ? ' step="' . intval( $option->get_step() ) . '"' : ''; ?>
		<?php echo ( $option->get_min() !== NULL ) ? ' min="' . intval( $option->get_min() ) . '"' : ''; ?>
		<?php echo ( $option->get_max() !== NULL ) ? ' max="' . intval( $option->get_max() ) . '"' : ''; ?>
		<?php echo ( $option->get_placeholder() != '' ) ? ' placeholder="' . esc_attr( $option->get_placeholder() ) . '"' : ''; ?>>

	<?php $option->form_field_suffix(); ?>

</div>
