<?php



class TPL_Icon extends TPL_Combined {


	function __construct( $args ) {

		$args["parts"] = [
			[
				"name"			=> 'code',
				"title"			=> __( 'Icon', 'tpl' ),
				"description"	=> __( 'The Font Awesome code of the icon (uses the fa-xxx name structure)', 'tpl' ),
				"type"			=> 'font_awesome',
				"admin_class"	=> 'tpl-select-preview-key',
				"default"		=> '',
			],
			[
				"name"			=> 'color',
				"title"			=> __( 'Icon Color', 'tpl' ),
				"description"	=> __( 'What should be the color of this icon?', 'tpl' ),
				"type"			=> 'color',
				"default"		=> '',
			],
			[
				"name"			=> 'size',
				"title"			=> __( 'Icon size', 'tpl' ),
				"description"	=> __( 'Size of the icon in Font Awesome sizes', 'tpl' ),
				"type"			=> 'select',
				"default"		=> '1x',
				"values"		=> [
					"xs"			=> __( 'Extra Small', 'tpl' ),
					"sm"			=> __( 'Small', 'tpl' ),
					"1x"			=> __( 'Normal', 'tpl' ),
					"lg"			=> __( 'Larger', 'tpl' ),
					"2x"			=> __( 'Double', 'tpl' ),
					"3x"			=> __( 'Triple', 'tpl' ),
					"4x"			=> __( '4x', 'tpl' ),
					"5x"			=> __( '5x', 'tpl' ),
					"6x"			=> __( '6x', 'tpl' ),
					"7x"			=> __( '7x', 'tpl' ),
					"8x"			=> __( '8x', 'tpl' ),
					"9x"			=> __( '9x', 'tpl' ),
					"10x"			=> __( '10x', 'tpl' ),
				],
			],
			[
				"name"			=> 'url',
				"title"			=> __( 'Icon URL', 'tpl' ),
				"description"	=> __( 'Where should the icon be linked to?', 'tpl' ),
				"type"			=> 'text',
			],
			[
				"name"			=> 'title',
				"title"			=> __( 'Link Title', 'tpl' ),
				"description"	=> __( 'This is displayed when hovering the mouse over the icon when it is a link', 'tpl' ),
				"type"			=> 'text',
				"condition"		=> [
					[
						"type"		=> 'option',
						"name"		=> '_THIS_/url',
						"relation"	=> '!=',
						"value"		=> '',
					],
				],
			],
			[
				"name"			=> 'newtab',
				"title"			=> __( 'Open in new tab?', 'tpl' ),
				"description"	=> __( 'If yes, the link will open in a new browser tab', 'tpl' ),
				"type"			=> 'boolean',
				"default"		=> true,
				"condition"		=> [
					[
						"type"		=> 'option',
						"name"		=> '_THIS_/url',
						"relation"	=> '!=',
						"value"		=> '',
					],
				],
			],
		];

		parent::__construct( $args );

	}


	function get_value() {

		$option = $this->get_option();
		$this->set_parts_post();

		if ( !empty( $option ) ) {

			if ( $this->is_repeater() ) {

				$values = [];

				foreach ( $option as $instance => $row ) {
					$this->path[1] = $instance;
					foreach ( $this->get_parts() as $part ) {
						$part->path[1] = $this->path[1];
					}
					$values[] = $this->format_option( $option );
				}

				return $values;

			}
			else {
				return $this->format_option( $option );
			}

		}

	}


	function format_option( $option ) {

		$return_value = '';

		if ( $this->parts["url"]->get_option() ) {
			$newtab = $this->parts["newtab"]->get_option() ? ' target="_blank"' : '';
			$title = $this->parts["title"]->get_option() ? ' title="' . esc_attr( $this->parts["title"]->get_value() ) . '"' : '';
			$return_value .= '<a href="' . esc_attr( $this->parts["url"]->get_value() ) . '"' . $newtab . $title . '>';
		}

		if ( $this->parts["code"]->get_option() ) {
			$color = $this->parts["color"]->get_option() ? ' style="color: ' . $this->parts["color"]->get_option() . '"' : '';
			$size = $this->parts["size"]->get_option() ? ' fa-' . esc_attr( $this->parts["size"]->get_option() ) : '';
			$return_value .= '<i class="' . $this->parts["code"]->get_icon_type() . $size . ' fa-' . esc_attr( $this->parts["code"]->get_option() ) . '"' . $color . '></i>';
		}

		if ( $this->parts["url"]->get_option() ) {
			$return_value .= '</a>';
		}

		return $return_value;

	}


	function value() {

		if ( $this->is_repeater() ) {

			$values = $this->get_value();

			if ( is_array( $values ) ) { ?>
				<ul>
					<?php foreach ( $values as $value ) { ?>
						<li><?php echo $value; ?></li>
					<?php } ?>
				</ul>
			<?php }

		}

		else {
			echo $this->get_value();
		}

	}


	function admin_js_strings( $strings ) {

		$strings = array_merge( $strings, array(
			'tpl-dt-icon_preview-template'	=> '<i class="[code/tpl-preview-3] fa-fw fa-lg fa-[code/tpl-preview-1]" style="color: [color/tpl-preview-0]"></i> [title/tpl-preview-1]',
		) );

		return $strings;

	}


}
