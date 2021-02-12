<div id="<?php echo esc_attr( $section->get_name() ); ?>">

	<?php if ( $section->get_title() ) { ?>
		<h3><?php echo esc_html( $section->get_title() ); ?></h3>
	<?php } ?>

	<?php if ( $section->get_description() ) { ?>
		<p><?php echo tpl_kses( $section->get_description() ); ?></p>
	<?php } ?>

	<?php if ( $section->get_options() ) { ?>
		<table class="form-table">
			<?php $section->render_primary_fields( $settings_page ); ?>
		</table>
	<?php } ?>

</div>
