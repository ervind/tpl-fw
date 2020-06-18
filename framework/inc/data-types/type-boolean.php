<?php



class TPL_Boolean extends TPL_Option {


	public		$default		= false;


	function form_field_content() {

		$option = $this;
		include TPL_ROOT_DIR . 'inc/templates/option/data-types/boolean-field-content.php';

	}


	function get_form_field_value() {

		return (int) parent::get_form_field_value();

	}


	function get_single_option_by_path() {

		$option = parent::get_single_option_by_path();

		if ( $option == '1' ) {
			return true;
		}

		if ( $option == '0' ) {
			return false;
		}

		return $option;

	}


	function form_default_value() {

		if ( $this->get_default() === '' ) {
			return '';
		}

		return sprintf( __( '(default: %s)', 'tpl' ), $this->format_option( $this->get_default() ) );

	}


	function format_option( $value ) {

		if ( $value == true ) {
			return __( 'True', 'tpl' );
		}

		return __( 'False', 'tpl' );

	}


	function admin_js_strings( $strings ) {

		$strings = array_merge( $strings, [
			'tpl-dt-boolean_preview-template'	=> '<label class="checked-[tpl-preview-0]"></label>',
		] );

		return $strings;

	}


}
