<div class="tpl-datatype-container">

	<?php $option->form_field_prefix(); ?>

	<select <?php $option->print_form_ref(); ?>
		data-preview="1"
		autocomplete="off">

		<?php if ( $option->get_placeholder() != '' ) { ?>
			<option value=""><?php echo esc_html( $option->get_placeholder() ); ?></option>
		<?php } ?>

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
				<option value="<?php echo esc_attr( $key ); ?>"<?php echo ( $key == $option->get_form_field_value() ) ? ' selected' : ''; ?>>
				 	<?php echo esc_html( $value ); ?>
				</option>
			<?php }

		} ?>

	</select>

	<?php $option->form_field_suffix(); ?>

</div>
