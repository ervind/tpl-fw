<?php

// The file must have the type-[data-type].php filename format


class TPL_Icon extends TPL_Combined {


	public		$js_func		= "get_value";		// Which function should create the JS variable


	public function __construct( $args ) {

		$args["parts"][] = array(
			"name"			=> 'code',
			"title"			=> __( 'Icon', 'tpl' ),
			"description"	=> __( 'The Font Awesome code of the icon (uses the fa-xxx name structure)', 'tpl' ),
			"type"			=> 'font_awesome',
			"admin_class"	=> 'tpl-select-preview-key',
			"default"		=> '',
		);

		$args["parts"][] = array(
			"name"			=> 'color',
			"title"			=> __( 'Icon Color', 'tpl' ),
			"description"	=> __( 'What should be the color of this icon?', 'tpl' ),
			"type"			=> 'color',
			"default"		=> '',
		);

		$args["parts"][] = array(
			"name"			=> 'size',
			"title"			=> __( 'Icon size', 'tpl' ),
			"description"	=> __( 'Size of the icon in Font Awesome sizes', 'tpl' ),
			"type"			=> 'select',
			"default"		=> '',
			"values"		=> array(
				"xs"			=> __( 'Extra Small', 'a-staff' ),
				"sm"			=> __( 'Small', 'a-staff' ),
				"1x"			=> __( 'Normal', 'a-staff' ),
				"lg"			=> __( 'Larger', 'a-staff' ),
				"2x"			=> __( 'Double', 'a-staff' ),
				"3x"			=> __( 'Triple', 'a-staff' ),
				"4x"			=> __( '4x', 'a-staff' ),
				"5x"			=> __( '5x', 'a-staff' ),
				"6x"			=> __( '6x', 'a-staff' ),
				"7x"			=> __( '7x', 'a-staff' ),
				"8x"			=> __( '8x', 'a-staff' ),
				"9x"			=> __( '9x', 'a-staff' ),
				"10x"			=> __( '10x', 'a-staff' ),
			),
			"key"			=> true,
		);

		$args["parts"][] = array(
			"name"			=> 'url',
			"title"			=> __( 'Icon URL', 'tpl' ),
			"description"	=> __( 'Where should the icon be linked to?', 'tpl' ),
			"type"			=> 'text',
		);

		$args["parts"][] = array(
			"name"			=> 'title',
			"title"			=> __( 'Link Title', 'tpl' ),
			"description"	=> __( 'This is displayed when hovering the mouse over the icon when it is a link', 'tpl' ),
			"type"			=> 'text',
			"condition"		=> array(
				array(
					"type"		=> 'option',
					"name"		=> '_THIS_/url',
					"relation"	=> '!=',
					"value"		=> '',
				),
			),
		);

		$args["parts"][] = array(
			"name"			=> 'newtab',
			"title"			=> __( 'Open in new tab?', 'tpl' ),
			"description"	=> __( 'If yes, the link will open in a new browser tab', 'tpl' ),
			"type"			=> 'boolean',
			"default"		=> true,
			"condition"		=> array(
				array(
					"type"		=> 'option',
					"name"		=> '_THIS_/url',
					"relation"	=> '!=',
					"value"		=> '',
				),
			),
		);

		parent::__construct( $args );

	}



	// Adding the necessary classes to the admin field
	public function form_field_before ( $before_args = array() ) {

		$before_args["extra_class"] = 'tpl-dt-combined';

		parent::form_field_before( $before_args );

	}



	// Returns the values as an array
	public function get_value ( $args = array(), $id = 0 ) {

		$path_n = $this->get_level() * 2;
		$path_i = $this->get_level() * 2 + 1;
		$path_s = $this->get_level() * 2 + 2;

		if ( !isset( $args["path"][$path_n] ) ) {
			$args["path"][$path_n] = $this->name;
		}

		if ( $this->repeat === false ) {
			$args["path"][$path_i] = 0;
		}

		$result = array();

		$values = $this->get_option( $args, $id );

		if ( !isset( $args["path"][$path_i] ) ) {

			foreach ( $values as $i => $value ) {
				foreach ( $this->parts as $part ) {
					if ( $part->name == "code" && isset( $value["code"] ) ) {
						$result[$i] = $part->format_option( $value["code"], $value );
					}
				}
			}

		}

		else {

			if ( !isset( $args["path"][$path_s] ) ) {

				foreach ( $this->parts as $part ) {
					if ( $part->name == "code" && isset( $values["code"] ) ) {
						$result = $part->format_option( $values["code"], $values );
					}
				}

			}
			else {

				foreach ( $this->parts as $part ) {
					if ( $part->name == $args["path"][$path_s] ) {
						$result = $part->get_value( $args, $id );
					}
				}

			}

		}

		return $result;

	}



	// Prints the value as a list
	public function value ( $args = array(), $id = 0 ) {

		$path_n = $this->get_level() * 2;
		$path_i = $this->get_level() * 2 + 1;
		$path_s = $this->get_level() * 2 + 2;

		if ( !isset( $args["path"][$path_n] ) ) {
			$args["path"][$path_n] = $this->name;
		}

		if ( $this->repeat === false ) {
			$args["path"][$path_i] = 0;
		}

		$values = $this->get_value( $args, $id );
		$kses_extra = array(
			'i'	=> array(
				'style'	=> array(),
				'class'	=> array(),
			),
		);

		// List all
		if ( !isset( $args["path"][$path_i] ) ) {

			echo '<ul>';
			foreach ( $values as $value ) {
				echo '<li>' . tpl_kses( $value, $kses_extra ) . '</li>';
			}
			echo '</ul>';
			return;

		}

		// Only one instance
		else {

			if ( !isset( $args["path"][$path_s] ) ) {

				echo tpl_kses( $values, $kses_extra );

			}

			// Only one sub-item
			else {

				foreach ( $this->parts as $part ) {
					if ( $part->name == $args["path"][$path_s] ) {
						echo tpl_kses( $part->get_value( $args, $kses_extra ) );
					}
				}

			}

		}

	}



	// Strings to be added to the admin JS files
	public function admin_js_strings( $strings ) {

		$strings = array_merge( $strings, array(
			'tpl-dt-icon_preview-template'	=> '<i class="[code/tpl-preview-3] fa-fw fa-lg fa-[code/tpl-preview-1]" style="color: [color/tpl-preview-0]"></i> [title/tpl-preview-1]',
		) );

		return $strings;

	}


}
