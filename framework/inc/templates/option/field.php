<div class="<?php $option->form_field_admin_classes(); ?>"
	data-instance="<?php echo $option->get_current_instance(); ?>"
	data-name="<?php echo $option->get_multi_level_name(); ?>"
	data-type="<?php echo $option->get_type(); ?>"
	data-level="<?php echo $option->get_level(); ?>"
	data-connected="<?php echo $option->get_multi_level_name(); ?>">

	<?php $option->repeater_header(); ?>

	<div class="tpl-field-inner<?php echo ( $option->is_repeater() && !$option->is_bank_mode() ) ? ' tpl-admin-hide' : ''; ?>">
		<?php $option->form_field_content(); ?>
		<?php $option->form_field_default(); ?>
	</div>

</div>
