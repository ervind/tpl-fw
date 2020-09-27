<div class="tpl-combined-wrapper">

<?php foreach ( $option->get_parts() as $part ) { ?>

	<div class="tpl-subitem-wrapper"
		data-instance="<?php echo $part->get_current_instance(); ?>"
		data-name="<?php echo $part->get_multi_level_name(); ?>"
		data-level="<?php echo $part->get_level(); ?>"
		data-connected="<?php echo $part->get_multi_level_name(); ?>">

		<label class="tpl-subitem-label" for="<?php echo esc_attr( $part->form_ref() ); ?>"><?php echo esc_html( $part->get_title() ); ?></label>
		<?php if ( $part->get_description() != '' ) { ?>
			<i class="fa fa-sm fa-question-circle tpl-admin-question tpl-admin-icon">
				<span class="tpl-admin-subitem-desc tpl-admin-hide"><?php echo tpl_kses( $part->get_description() ); ?></span>
			</i>
		<?php } ?>

		<?php $option->is_bank_mode() ? $part->bank_form_field() : $part->form_field(); ?>

	</div>

<?php } ?>

</div>
