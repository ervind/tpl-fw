<?php

// The file must have the type-[data-type].php filename format


class TPL_Static extends TPL_Data_Type {

	protected	$less_string	= true;		// Should the LESS variable forced to be a string or keep as a natural value


	// Content of the form field
	public function form_field_content ( $for_bank = false ) {

		$value = $this->get_option();
		echo tpl_kses( $this->prefix . $value . $this->suffix );

	}


	// Container end of the form field
	public function form_field_after () {

		echo '</div>';

	}


	// As a static option, we return here the default value
	public function get_option ( $args = array(), $id = 0 ) {

		return $this->default;

	}

}
