<?php

// The file must have the type-[data-type].php filename format


class TPL_Boolean extends TPL_Data_Type {



	// Writes the form field in wp-admin
	public function form_field_content ( $for_bank = false ) {

		if ( $for_bank == true ) {
			$value = $this->default;
		}
		else {
			$value = $this->get_option();
		}

		if ( $value == 1 ) {
			$preview_value = 'check-square-o';
		}
		else {
			$preview_value = 'square-o';
		}

		echo '<div class="tpl-datatype-container">';

		echo '<label class="checked-' . $value . '"><input type="hidden" class="tpl-preview-0" data-preview-value="' . $preview_value . '" id="' . esc_attr( $this->form_ref() ) . '" name="' . esc_attr( $this->form_ref() ) . '" value="' . $value . '"';

		echo '></label>';

		echo '</div>';

	}



	// Displayed after the form field
	public function form_field_after () {

		$path_i = $this->get_level() * 2 + 1;

		if ( $this->default === true || $this->default === false ) {
			echo ' <div class="tpl-default-container">
				<i class="tpl-default-value">(';

			$text = '';

			$text .= __( 'default:', 'tpl' ) . ' ';
			if ( $this->default === true ) {
				$text .= 'true';
			}
			if ( $this->default === false ) {
				$text .= 'false';
			}

			echo $text;

			echo ')</i>
			</div>';
		}

		echo '</div>';		// .tpl-field-inner

    	if ( $this->repeat !== false ) {
    		$this->path[$path_i]++;
		}

		echo '</div>';

	}



	// Formats the option into value
	public function format_option ( $value, $args = array() ) {

		return intval( $value );

	}



	// LESS variable helper function
	public function format_less_var( $name, $value ) {

		$less_variable = '@' . $name . ': ';

		// Should it be included in LESS as a string variable? If yes, put it inside quote marks
		if ( $this->get_option() == true ) {
			$less_variable .= 'true';
		}
		else {
			$less_variable .= 'false';
		}

		$less_variable .= ';';

		return $less_variable;

	}



	// Strings to be added to the admin JS files
	public function admin_js_strings( $strings ) {

		$strings = array_merge( $strings, array(
			'tpl-dt-boolean_preview-template'	=> '<i class="fa fa-lg fa-[tpl-preview-0]"></i>',
		) );

		return $strings;

	}


}
