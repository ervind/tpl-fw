<?php



class TPL_Date extends TPL_Option {


	public	$default	= '';


	function __construct( $args ) {
		global $tpl_datepicker_added;

		parent::__construct( $args );

		if ( $tpl_datepicker_added !== true ) {

			add_filter( 'tpl_admin_js_strings', array( $this, 'admin_js_strings' ) );
			add_action( 'admin_enqueue_scripts', function( $hook_suffix ) {
			    wp_enqueue_script( 'jquery-ui-datepicker', [ 'jquery', 'jquery-ui-core' ] );
			});
			$tpl_datepicker_added = true;

		}

	}


	function form_field_content() {

		$option = $this;
		include TPL_ROOT_DIR . 'inc/templates/option/data-types/date-field-content.php';

	}


	function format_option( $value ) {

		if ( $value != '' ) {
			$date = new DateTime( $value );
			return date_i18n( get_option( 'date_format' ), $date->getTimestamp() );
		}

		return '';

	}


	public function admin_js_strings( $strings ) {

		$strings = array_merge( $strings, [
			'date_starts_with'		=> get_option( 'start_of_week' ),
		] );

		return $strings;

	}


}
