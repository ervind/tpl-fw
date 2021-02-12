<div class="clearfix tpl-meta-option-outer">

	<div class="tpl-meta-option" data-connected="<?php echo esc_attr( $option->get_multi_level_name() ); ?>">

		<div class="tpl-meta-option-label">
			<?php echo tpl_kses( $option->get_title() ); ?>
			<div class="tpl-option-desc">
				<?php echo tpl_kses( $option->get_description() ); ?>
			</div>
		</div>

		<div class="tpl-meta-option-wrapper">
			<?php $option->form_field();

			if ( $option->is_repeater() ) {
				$option->repeater_button();
			} ?>
		</div>

	</div>

</div>
