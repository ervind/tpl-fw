<?php

// The file must have the type-[data-type].php filename format


class TPL_TinyMCE extends TPL_Textarea {


	public function __construct( $args ) {

		global $tpl_mce_buttons_filtered;

		parent::__construct( $args );

		if ( isset( $_GET["page"] )
			&& ( tpl_is_primary_section( $this->section ) )
			&& $tpl_mce_buttons_filtered !== true
			&& tpl_has_section_post_type ( $this->section, str_replace( 'tpl_', '', $_GET["page"] ) ) ) {

			add_filter( 'mce_buttons', array( $this, 'mce_buttons' ) );
			add_action( 'tpl_after_primary_sections', array( $this, 'mce_dummy_editor' ) );
			$tpl_mce_buttons_filtered = true;

		}

		// Forcing the visual mode for WP Editor where the TinyMCE DT is used (needed for initializing correctly)
		add_filter( 'wp_default_editor', function() {
			return "tinymce";
		} );

		if ( !has_action( 'tpl_before_textarea', array( 'TPL_TinyMCE', 'editor_switch_buttons' ) ) ) {
			add_action( 'tpl_before_textarea', array( 'TPL_TinyMCE', 'editor_switch_buttons' ) );
		}

	}


	// Unsetting some unnecessary buttons
	public function mce_buttons ( $buttons ) {

		foreach ( $buttons as $i => $button ) {

			if ( $button == 'fullscreen' || $button == 'wp_more' || $button == 'layerslider_button' || $button == 'wp_adv' ) {
				unset( $buttons[$i] );
			}

		}

		return $buttons;

	}


	// This function is only needed for initializing TinyMCE with the correct settings
	public function mce_dummy_editor () {

		wp_editor( '', 'dummy_editor', array(
			'editor_css' 	=> '<style> #wp-dummy_editor-wrap { display: none; } </style>',
			'wpautop'		=> false,
			'media_buttons'	=> true,
		) );

	}


	// Adds the editor switch buttons before the TinyMCE textarea
	public static function editor_switch_buttons() {
		?>

		<div class="tpl-editor-switch-buttons-wrap">
			<button class="tpl-editor-visual-button"><?php _e( 'Visual', 'tpl' ); ?></button>
			<button class="tpl-editor-text-button"><?php _e( 'Text', 'tpl' ); ?></button>
		</div>

		<?php
	}


}
