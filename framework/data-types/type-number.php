<?php

// The file must have the type-[data-type].php filename format


class TPL_Number extends TPL_Data_Type {

	public		$step		= NULL;		// Distance between 2 consecutive values (whole number)
	public		$min		= NULL;		// Minimum value
	public		$max		= NULL;		// Maximum value


	// Writes the form field in wp-admin
	public function form_field_content ( $args ) {

		if ( $this->get_option() === NULL ) {
			$value = $this->default;
		}
		else {
			$value = $this->get_option();
		}

		if ( $args["for_bank"] == true ) {
			$value = $this->default;
		}

		echo '<div class="tpl-datatype-container">';

		if ( $this->prefix ) {
			echo '<span class="tpl-datatype-prefix tpl-preview-0">' . $this->prefix . '</span>';
		}

		echo '<input type="number" class="tpl-preview-1" id="' . esc_attr( $this->form_ref() ) . '" name="' . esc_attr( $this->form_ref() ) . '" value="' . esc_attr( $value ) . '"';

		if ( $this->min != NULL ) {
			echo ' min="' . intval( $this->min ) . '"';
		}
		if ( $this->max != NULL ) {
			echo ' max="' . intval( $this->max ) . '"';
		}
		if ( $this->step != NULL ) {
			echo ' step="' . intval( $this->step ) . '"';
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


	// Displayed after the form field
	public function form_field_after ( $args ) {

		$path_i = $this->get_level() * 2 + 1;

		if ( $this->default !== NULL && $args["show_default"] == true ) {
			echo ' <div class="tpl-default-container">
				<i class="tpl-default-value">(';

			$text = '';

			$text .= __( 'default:', 'tpl' ) . ' ';
			if ( $this->default == 0 ) {
				$text .= '0';
			}
			else {
				$text .= tpl_kses( $this->format_option( $this->default ) );
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

		if ( !intval( $value ) ) {
			return false;
		}
		if ( is_array( $value ) ) {
			$value = $value[0];
		}
		else {
			return $this->prefix . $value . $this->suffix;
		}

	}


}
