<?php



class TPL_Number extends TPL_Option {

	public		$step		= NULL;
	public		$min		= NULL;
	public		$max		= NULL;
	public		$default	= 0;


	function initialize() {

		parent::initialize();

		if ( isset( $this->args["step"] ) ) {
			$this->set_step( $this->args["step"] );
		}

		if ( isset( $this->args["min"] ) ) {
			$this->set_min( $this->args["min"] );
		}

		if ( isset( $this->args["max"] ) ) {
			$this->set_max( $this->args["max"] );
		}

	}


	function get_step() {

		return $this->step;

	}


	function set_step( $step ) {

		$this->step = $step;

	}


	function get_min() {

		return $this->min;

	}


	function set_min( $min ) {

		$this->min = $min;

	}


	function get_max() {

		return $this->max;

	}


	function set_max( $max ) {

		$this->max = $max;

	}


	function form_field_content() {

		$option = $this;
		include TPL_ROOT_DIR . 'inc/templates/option/data-types/number-field-content.php';

	}


	function format_option( $value ) {

		if ( !intval( $value ) ) {
			return '';
		}
		else {
			return $this->prefix . $value . $this->suffix;
		}

	}


}
