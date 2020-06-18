<?php



class TPL_Text extends TPL_Option {

	protected	$size			= 0;		// 0 = Infinite string length; Other number = max length of the string


	function initialize() {

		parent::initialize();

		if ( isset( $this->args["size"] ) ) {
			$this->set_size( $this->args["size"] );
		}

	}


	function get_size() {

		return $this->size;

	}


	function set_size( $size ) {

		$this->size = $size;

	}


	public function form_field_content() {

		$option = $this;
		include TPL_ROOT_DIR . 'inc/templates/option/data-types/text-field-content.php';

	}


}
