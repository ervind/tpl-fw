<div class="clearfix tpl-meta-option-outer">

	<div class="tpl-meta-option" data-connected="<?php echo esc_attr( $option->get_multi_level_name() ); ?>">

		<span class="tpl-meta-option-label"><?php echo tpl_kses( $option->get_title() ); ?></span>

		<div class="tpl-meta-option-wrapper">
			<?php $option->form_field();

			if ( $option->is_repeater() ) {
				$option->repeater_button();
			} ?>
		</div>

	</div>
	<p class="tpl-optiondesc clearfix" data-connected="<?php echo esc_attr( $option->get_multi_level_name() ); ?>">
		<?php echo tpl_kses( $option->get_description() ); ?>
	</p>

</div>
