<?php

// The file must have the type-[data-type].php filename format


class TPL_Color extends TPL_Data_Type {

	public	$default		= "#000000";		// Default color if no other defaults are set


	public function __construct( $args ) {

		global $tpl_color_added;

		parent::__construct( $args );

		if ( $tpl_color_added !== true ) {

			add_action( 'admin_enqueue_scripts', function ( $hook_suffix ) {
			    wp_enqueue_style( 'wp-color-picker' );
			    wp_enqueue_script( 'wp-color-picker', array('jquery') );
			});
			$tpl_color_added = true;

		}

	}


	// Writes the form field in wp-admin
	public function form_field_content ( $args ) {

		echo '<div class="tpl-datatype-container">';

		if ( $this->get_option() == "" ) {
			$value = $this->default;
		}
		else {
			$value = $this->get_option();
		}

		if ( $args["for_bank"] == true ) {
			$value = $this->default;
		}

		echo '<input name="' . esc_attr( $this->form_ref() ) . '" id="' . esc_attr( $this->form_ref() ) . '" type="text" value="' . esc_attr( $value ) . '" class="tpl-color-field tpl-preview-0" data-default-color="' . esc_attr( $this->default ) . '">';

		echo '</div>';


		// If called from the front end, needs to enqueue some extra files
		if ( !is_admin() ) {

			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'iris', admin_url( 'js/iris.min.js' ), array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ),	false, 1 );
			wp_enqueue_script( 'wp-color-picker', admin_url( 'js/color-picker.min.js' ), array( 'iris' ), false, 1 );

			$colorpicker_l10n = array(
				'clear'			=> __( 'Clear', 'tpl' ),
				'defaultString'	=> __( 'Default', 'tpl' ),
				'pick'			=> __( 'Select Color', 'tpl' ),
				'current'		=> __( 'Current Color', 'tpl' ),
			);
			wp_localize_script( 'wp-color-picker', 'wpColorPickerL10n', $colorpicker_l10n );

			wp_enqueue_script( 'tpl-admin-scripts', tpl_base_uri() . '/framework/script/admin-scripts.min.js', array( 'jquery' ), false, 1 );
			wp_localize_script( 'tpl-admin-scripts', 'TPL_Admin', array_merge( apply_filters( 'tpl_admin_js_strings', array() ), tpl_admin_vars_to_js() ) );

		}

	}


	// Formats the option into value
	public function format_option ( $value, $args = array() ) {

		return $value;

	}


	// Strings to be added to the admin JS files
	public function admin_js_strings( $strings ) {

		$strings = array_merge( $strings, array(
			'tpl-dt-color_preview-template'	=> '<span class="tpl-color-preview" style="background-color: [tpl-preview-0];"></span>',
		) );

		return $strings;

	}


}
