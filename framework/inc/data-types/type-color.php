<?php



class TPL_Color extends TPL_Option {

	public	$default		= "#000000";


	function __construct( $args ) {
		global $tpl_color_added;

		parent::__construct( $args );

		if ( $tpl_color_added !== true ) {

			add_action( 'admin_enqueue_scripts', function ( $hook_suffix ) {
			    wp_enqueue_style( 'wp-color-picker' );
			    wp_enqueue_script( 'wp-color-picker', [ 'jquery' ] );
			});
			$tpl_color_added = true;

		}

	}


	function form_field_content() {

		$option = $this;
		include TPL_ROOT_DIR . 'inc/templates/option/data-types/color-field-content.php';

	}


	function format_option( $value ) {

		return $value;

	}


	function admin_js_strings( $strings ) {

		$strings = array_merge( $strings, [
			'tpl-dt-color_preview-template'	=> '<span class="tpl-color-preview" style="background-color: [tpl-preview-0];"></span>',
		] );

		return $strings;

	}


}
