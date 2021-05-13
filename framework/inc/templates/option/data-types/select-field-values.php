<?php foreach ( $option->get_selectable_values() as $key => $value ) {

	if ( is_array( $value ) ) { ?>
		<optgroup label="<?php echo esc_attr( $key ); ?>">
			<?php foreach ( $value as $sub_key => $sub_value ) { ?>
				<option value="<?php echo esc_attr( $sub_key ); ?>"<?php echo ( $sub_key == $option->get_form_field_value() ) ? ' selected' : ''; ?>>
					<?php echo esc_html( $sub_value ); ?>
				</option>
			<?php } ?>
		</optgroup>
	<?php }

	else { ?>
		<option value="<?php echo esc_attr( $key ); ?>"<?php echo ( (string) $key === $option->get_form_field_value() ) ? ' selected' : ''; ?>>
			<?php echo esc_html( $value ); ?>
		</option>
	<?php }

}
