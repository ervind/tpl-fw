<div class="tpl-datatype-container" data-edit-url-template="<?php echo $option->get_admin_edit_url( true ); ?>">

	<select <?php $option->print_form_ref(); ?>
		data-preview="1"
		autocomplete="off">

		<?php $option->list_selectable_values(); ?>

	</select>

	<a href="<?php echo $option->get_admin_edit_url(); ?>"
		class="tpl-select-icon tpl-edit-icon<?php echo $option->get_form_field_value() == '' ? ' tpl-admin-hide' : ''; ?>"
		target="_blank"
		title="<?php printf( __( 'Edit this %s', 'tpl' ), strtolower( get_post_type_object( $option->get_post_type() )->labels->singular_name ) ); ?>">
		<i class="far fa-lg fa-fw fa-edit"></i>
	</a>

	<a href="<?php echo $option->get_admin_posts_url(); ?>"
		class="tpl-select-icon tpl-new-icon tpl-list-icon<?php echo $option->get_form_field_value() != '' ? ' tpl-admin-hide' : ''; ?>"
		target="_blank"
		title="<?php printf( __( 'Browse the list of all %s', 'tpl' ), strtolower( get_post_type_object( $option->get_post_type() )->labels->name ) ); ?>">
		<i class="fas fa-lg fa-fw fa-list"></i>
	</a>

	<?php if ( $option->has_template() ) { ?>
		<a href="#"
			class="tpl-select-icon tpl-new-icon tpl-template-add-icon<?php echo $option->get_form_field_value() != '' ? ' tpl-admin-hide' : ''; ?>"
			target="_blank"
			title="<?php printf( __( 'Add new %s from template and connect', 'tpl' ), strtolower( get_post_type_object( $option->get_post_type() )->labels->singular_name ) ); ?>">
			<i class="fas fa-lg fa-fw fa-file-medical"></i>
		</a>
	<?php } ?>

</div>
