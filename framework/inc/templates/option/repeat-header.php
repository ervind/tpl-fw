<div class="tpl-repeat-header<?php echo $option->is_bank_mode() ? '' : ' tpl-repeat-header-closed'; ?>">
	<div class="tpl-admin-icon fa tpl-arranger" title="<?php _e( 'Drag & Drop to reorder', 'tpl' ); ?>"></div>
	<div class="tpl-header-title">
		<span class="tpl-header-title-instance">(#<?php echo $option->get_current_instance(); ?>)</span>
		<span class="tpl-header-title-preview"></span>
	</div>
	<div class="tpl-admin-icon fa tpl-toggle <?php echo ( $option->is_repeater() && !$option->is_bank_mode() ) ? 'tpl-toggle-open' : 'tpl-toggle-close'; ?>"
		title="<?php echo ( $option->is_repeater() && !$option->is_bank_mode() ) ? __( 'Maximize', 'tpl' ) : __( 'Minimize', 'tpl' ); ?>">
	</div>
	<div class="tpl-admin-icon fa tpl-remover" title="<?php _e( 'Remove row', 'tpl' ); ?>"></div>
</div>
