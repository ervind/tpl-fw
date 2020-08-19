<div class="tpl-datatype-container">

	<?php $option->form_field_prefix(); ?>

	<select <?php $option->print_form_ref(); ?>
		data-preview="1"
		autocomplete="off">

		<?php $option->list_selectable_values(); ?>

	</select>

	<?php $option->form_field_suffix(); ?>

	<?php if ( $option->has_refresh_action() ) { ?>
		<a href="#"
			class="tpl-select-icon tpl-refresh-icon"
			title="<?php _e( 'Refresh list', 'tpl' ); ?>"
			data-refresh="<?php echo $option->get_refresh_action(); ?>">
			<i class="fas fa-lg fa-fw fa-sync-alt"></i>
		</a>
	<?php } ?>

</div>
