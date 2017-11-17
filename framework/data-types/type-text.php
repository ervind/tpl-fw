<?php

// The file must have the type-[data-type].php filename format


class TPL_Text extends TPL_Data_Type {

	protected	$size			= 0;		// 0 = Infinite string length; Other number = max length of the string
	protected	$less_string	= true;		// Should the LESS variable forced to be a string or keep as a natural value
	public		$less			= false;	// LESS won't work HTML elements inside text, so better to turn it off here



	// Writes the form field in wp-admin
	public function form_field_content ( $for_bank = false ) {

		if ( $for_bank == true ) {
			$value = $this->default;
		}
		else {
			$value = $this->get_option();
		}

		echo '<div class="tpl-datatype-container">';

		if ( $this->prefix ) {
			echo '<span class="tpl-datatype-prefix tpl-preview-0">' . $this->prefix . '</span>';
		}

		echo '<input class="tpl-preview-1" type="text" id="' . esc_attr( $this->form_ref() ) . '" name="' . esc_attr( $this->form_ref() ) . '" value="' . esc_attr( $value ) . '"';

		if ( $this->size > 0 ) {
			echo ' maxlength="' . intval( $this->size ) . '"';
		}

		if ( $this->placeholder != '' ) {
			echo ' placeholder="' . esc_attr( $this->placeholder ) . '"';
		}

		echo '>';

		if ( $this->suffix ) {
			echo '<span class="tpl-datatype-suffix tpl-preview-2">' . $this->suffix . '</span>';
		}

		echo '</div>';

	}


}
