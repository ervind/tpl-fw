<?php

// The file must have the type-[data-type].php filename format


class TPL_Boolean extends TPL_Data_Type {



	// Writes the form field in wp-admin
	public function form_field_content ( $args ) {

		if ( $args["for_bank"] == true ) {
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
	public function form_field_after ( $args ) {

		$path_i = $this->get_level() * 2 + 1;

		if ( ( $this->default === true || $this->default === false ) && $args["show_default"] == true ) {
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



	// Gets the pure option value
	public function get_option ( $args = array(), $id = 0 ) {

		$option = parent::get_option( $args = array(), $id = 0 );

		if ( $option == 'yes' ) {
			return true;
		}

		if ( $option == 'no' ) {
			return false;
		}

		return $option;

	}



	// Formats the option into value
	public function format_option ( $value, $args = array() ) {

		return intval( $value );

	}



	// Strings to be added to the admin JS files
	public function admin_js_strings( $strings ) {

		$strings = array_merge( $strings, array(
			'tpl-dt-boolean_preview-template'	=> '<i class="fa fa-lg fa-[tpl-preview-0]"></i>',
		) );

		return $strings;

	}


}
