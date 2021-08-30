<div class="tpl-datatype-container">

	<input type="hidden" class="checkboxes-store" <?php $option->print_form_ref(); ?> value="<?php echo $option->get_form_field_value(); ?>">

	<?php foreach ( $option->get_selectable_values() as $key => $value ) { ?>
		<div class="checkbox">
			<label class="checked-<?php echo $option->is_key_selected( $key ); ?>">
				<span class="checkbox-item tpl-admin-hide"
				data-key="<?php echo esc_attr( $key ); ?>"
				data-value="<?php echo $option->is_key_selected( $key ) ? 1 : 0; ?>"
				data-preview="<?php echo $key; ?>"
				data-preview-value="<?php echo $option->is_key_selected( $key ) ? $value . ', ' : ''; ?>"></span>
			</label>
			<span><?php echo tpl_kses( $value ); ?></span>
		</div>
	<?php } ?>

</div>
