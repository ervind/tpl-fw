<?php

// The file must have the type-[data-type].php filename format


class TPL_Static extends TPL_Data_Type {


	// Content of the form field
	public function form_field_content ( $args ) {

		$value = $this->get_option();
		echo $this->prefix . $value . $this->suffix;

	}


	// Container end of the form field
	public function form_field_after ( $args ) {

		echo '</div>
		</div>';

	}


	// As a static option, we return here the default value
	public function get_option ( $args = array(), $id = 0 ) {

		return $this->default;

	}

}
