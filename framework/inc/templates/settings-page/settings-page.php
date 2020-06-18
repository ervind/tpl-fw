<div id="<?php echo esc_attr( $settings_page->get_menu_slug() ); ?>_wrap" class="wrap tpl_settings_page_wrap" data-name="<?php echo esc_attr( $settings_page->get_name() ); ?>">
	<h2 id="tpl-options-main-title"><?php echo esc_html( $settings_page->get_title() ); ?></h2>

	<form method="post" action="options.php">

		<?php if ( count ( $sections ) > 1 ) { ?>
			<div id="tpl-settings-tabs" data-store="<?php echo esc_attr( $settings_page->get_name() ); ?>_activetab">
				<ul class="nav-tab-wrapper">

					<?php foreach ( $sections as $section ) { ?>
						<li><a class="nav-tab" href="#<?php echo esc_attr( $section->get_name() ); ?>"><?php echo esc_html( $section->get_tab() ); ?></a></li>
					<?php } ?>

				</ul>
		<?php }

		$settings_page->render_sections();

		if ( count( $sections ) > 1 ) { ?>
			</div>
		<?php }

		$settings_page->form_hidden_fields();
		echo get_submit_button(); ?>

	</form>
</div>

<?php do_action( 'tpl_after_primary_sections' );
