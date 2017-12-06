<?php

// The file must have the type-[data-type].php filename format


class TPL_Font extends TPL_Select {


	public function __construct ( $args ) {

		global $tpl_font_family_sets;
		$families = array();

		if ( !isset( $args["sets"] ) ) {
			$args["sets"] = array( 'Basic fonts', 'Standard fonts' );
		}

		foreach ( $args["sets"] as $set ) {

			if ( $set == 'Google fonts' && !array_key_exists( 'Google fonts', $tpl_font_family_sets ) ) {

				$this->register_google_fonts();

				if ( !isset( $args["description"] ) ) {
					$args["description"] = '';
				}

				$args["description"] .= '. ' . sprintf( __( 'You can find demos for the Google fonts here: %s', 'tpl' ), 'https://fonts.google.com/' );

			}

			$families[$set] = $this->build_font_selector_values( $set );

		}

		$args["values"] = $families;

		parent::__construct( $args );

	}


	// Adding the necessary classes to the admin field
	public function form_field_before ( $before_args = array() ) {

		$before_args["extra_class"] = 'tpl-dt-select';

		parent::form_field_before( $before_args );

	}


	// Builds up the values for the selected font set
	public function build_font_selector_values ( $set ) {

		global $tpl_font_family_sets;
		$values = array();

		foreach ( $tpl_font_family_sets[$set] as $font ) {

			$stitle = sanitize_title( $font["name"] );
			$values[$stitle] = $font["name"];

		}

		return $values;

	}


	// Registers the Google fonts into the font selector array if they were selected
	public function register_google_fonts () {

		require_once ABSPATH . "wp-admin/includes/file.php";
		WP_Filesystem();
        global $wp_filesystem;

		$gfonts_file = tpl_base_dir() . '/framework/lib/google-fonts/google-fonts.json';
		$gfonts = json_decode( $wp_filesystem->get_contents( $gfonts_file ), true );

		foreach ( $gfonts["items"] as $font ) {

			if ( $font["category"] == 'handwriting' ) {
				$fallback = array( 'cursive', 'sans-serif' );
			}
			else if ( $font["category"] == 'display' ) {
				$fallback = array( 'sans-serif' );
			}
			else {
				$fallback = array( $font["category"] );
			}

			tpl_register_font_family( array(
				'set'		=> 'Google fonts',
				'name'		=> $font["family"],
				'cat'		=> array( $font["category"] ),
				'fallback'	=> $fallback,
			) );

		}

	}


}



// Global variable for font family sets
$tpl_font_family_sets = array();

// Register a Font Family
function tpl_register_font_family( $narr ) {

	global $tpl_font_family_sets;

	$tpl_font_family_sets[$narr["set"]][$narr["name"]] = $narr;

	ksort( $tpl_font_family_sets[$narr["set"]] );

}



// Registering the BASE font set
tpl_register_font_family( array(
	'set'		=> 'Basic fonts',
	'name'		=> 'sans-serif',
	'cat'		=> array( 'sans-serif' ),
) );

tpl_register_font_family( array(
	'set'		=> 'Basic fonts',
	'name'		=> 'serif',
	'cat'		=> array( 'serif' ),
) );

tpl_register_font_family( array(
	'set'		=> 'Basic fonts',
	'name'		=> 'monospace',
	'cat'		=> array( 'monospace' ),
) );

// Registering the STANDARD font set
tpl_register_font_family( array(
	'set'		=> 'Standard fonts',
	'name'		=> 'Georgia',
	'cat'		=> array( 'serif' ),
	'fallback'	=> array( 'serif' ),
) );

tpl_register_font_family( array(
	'set'		=> 'Standard fonts',
	'name'		=> 'Palatino Linotype',
	'cat'		=> array( 'serif' ),
	'fallback'	=> array( 'Book Antiqua', 'Palatino', 'serif' ),
) );

tpl_register_font_family( array(
	'set'		=> 'Standard fonts',
	'name'		=> 'Times New Roman',
	'cat'		=> array( 'serif' ),
	'fallback'	=> array( 'Times', 'serif' ),
) );

tpl_register_font_family( array(
	'set'		=> 'Standard fonts',
	'name'		=> 'Arial',
	'cat'		=> array( 'sans-serif' ),
	'fallback'	=> array( 'Helvetica', 'sans-serif' ),
) );

tpl_register_font_family( array(
	'set'		=> 'Standard fonts',
	'name'		=> 'Arial Black',
	'cat'		=> array( 'sans-serif' ),
	'fallback'	=> array( 'Gadget', 'sans-serif' ),
) );

tpl_register_font_family( array(
	'set'		=> 'Standard fonts',
	'name'		=> 'Comic Sans MS',
	'cat'		=> array( 'sans-serif', 'cursive' ),
	'fallback'	=> array( 'cursive', 'sans-serif' ),
) );

tpl_register_font_family( array(
	'set'		=> 'Standard fonts',
	'name'		=> 'Impact',
	'cat'		=> array( 'sans-serif' ),
	'fallback'	=> array( 'Charcoal', 'sans-serif' ),
) );

tpl_register_font_family( array(
	'set'		=> 'Standard fonts',
	'name'		=> 'Lucida Sans Unicode',
	'cat'		=> array( 'sans-serif' ),
	'fallback'	=> array( 'Lucida Grande', 'sans-serif' ),
) );

tpl_register_font_family( array(
	'set'		=> 'Standard fonts',
	'name'		=> 'Tahoma',
	'cat'		=> array( 'sans-serif' ),
	'fallback'	=> array( 'Geneva', 'sans-serif' ),
) );

tpl_register_font_family( array(
	'set'		=> 'Standard fonts',
	'name'		=> 'Trebuchet MS',
	'cat'		=> array( 'sans-serif' ),
	'fallback'	=> array( 'Helvetica', 'sans-serif' ),
) );

tpl_register_font_family( array(
	'set'		=> 'Standard fonts',
	'name'		=> 'Verdana',
	'cat'		=> array( 'sans-serif' ),
	'fallback'	=> array( 'Geneva', 'sans-serif' ),
) );

tpl_register_font_family( array(
	'set'		=> 'Standard fonts',
	'name'		=> 'Courier New',
	'cat'		=> array( 'monospace' ),
	'fallback'	=> array( 'Courier', 'monospace' ),
) );

tpl_register_font_family( array(
	'set'		=> 'Standard fonts',
	'name'		=> 'Lucida Console',
	'cat'		=> array( 'monospace' ),
	'fallback'	=> array( 'Monaco', 'monospace' ),
) );
