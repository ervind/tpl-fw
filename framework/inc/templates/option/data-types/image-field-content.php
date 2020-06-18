<div class="tpl-datatype-container">

	<div class="tpl-image-container">

		<img class="tpl-uploaded-image"
			alt="<?php printf( __( '%s image tag', 'tpl' ), esc_attr( $option->get_title() ) ); ?>"
			src="<?php echo esc_url( wp_get_attachment_image_src( $option->get_form_field_value(), 'thumbnail' )[0] ); ?>"
			<?php if ( $option->get_form_field_value() == '' || !is_numeric( $option->get_form_field_value() ) ) { echo ' style="display: none"'; } ?>
			data-preview="0">

		<img class="tpl-img-placeholder"
			alt="<?php _e( 'Placeholder image', 'tpl' ); ?>"
			src="<?php echo TPL_ROOT_URL . 'assets/no-image-placeholder.png' ?>"
			<?php if ( $option->get_form_field_value() != '' && is_numeric( $option->get_form_field_value() ) ) { echo ' style="display: none"'; } ?>>

		<div class="tpl-admin-icon fa tpl-closer"
			title="<?php _e( 'Click here to remove image.', 'tpl' ); ?>"
			<?php if ( $option->get_form_field_value() == '' || !is_numeric( $option->get_form_field_value() ) ) { echo ' style="display: none"'; } ?>>
		</div>

	</div>

	<input <?php $option->print_form_ref(); ?>
		class="tpl-img_id"
		type="hidden"
		value="<?php echo esc_attr( $option->get_form_field_value() ); ?>">
	<input class="button" type="button" name="<?php echo esc_attr( $option->get_name() ); ?>'_button" value="<?php _e( 'Upload', 'tpl' ); ?>">

</div>
