<?php



class TPL_TinyMCE extends TPL_Textarea {


	public function __construct( $args ) {
		global $tpl_mce_buttons_filtered;

		parent::__construct( $args );

		if ( is_admin()
			&& isset( $_GET["page"] )
			&& ( $this->section->is_primary() )
			&& $tpl_mce_buttons_filtered !== true
		) {

			add_filter( 'mce_buttons', [ $this, 'mce_buttons' ] );
			add_action( 'tpl_after_primary_sections', [ $this, 'mce_dummy_editor' ] );
			$tpl_mce_buttons_filtered = true;

		}

		// Forcing the visual mode for WP Editor where the TinyMCE DT is used (needed for initializing correctly)
		add_filter( 'wp_default_editor', function() {
			return "tinymce";
		} );

	}


	function mce_buttons( $buttons ) {

		foreach ( $buttons as $i => $button ) {

			if ( $button == 'fullscreen' || $button == 'wp_more' || $button == 'layerslider_button' || $button == 'wp_adv' ) {
				unset( $buttons[$i] );
			}

		}

		return $buttons;

	}


	function mce_dummy_editor() {

		wp_editor( '', 'dummy_editor', [
			'editor_css' 	=> '<style> #wp-dummy_editor-wrap { display: none; } </style>',
			'wpautop'		=> false,
			'media_buttons'	=> true,
		] );

	}


	function editor_switch_buttons() {
		?>

		<div class="tpl-editor-switch-buttons-wrap">
			<button class="tpl-editor-visual-button"><?php _e( 'Visual', 'tpl' ); ?></button>
			<button class="tpl-editor-text-button"><?php _e( 'Text', 'tpl' ); ?></button>
		</div>

		<?php
	}


	function format_option( $value ) {

		return $this->prefix . $value . $this->suffix;

	}


}
