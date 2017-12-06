<?php

// The file must have the type-[data-type].php filename format


class TPL_Textarea extends TPL_Data_Type {

	protected	$size			= 8;		// Number of rows in wp-admin


	// Writes the form field in wp-admin
	public function form_field_content ( $args ) {

		if ( $args["for_bank"] == true ) {
			$value = $this->default;
		}
		else {
			$value = esc_textarea( $this->get_option() );
		}

		echo '<div class="tpl-textarea-wrapper tpl-datatype-container">';

		if ( $this->prefix ) {
			echo '<span class="tpl-datatype-prefix tpl-preview-0">' . $this->prefix . '</span>';
		}

		echo '<textarea class="tpl-preview-1" id="' . esc_attr( $this->form_ref() ) . '" name="' . esc_attr( $this->form_ref() ) . '" rows="' . esc_attr( $this->size ) . '">'
		. $value
		. '</textarea>';

		if ( $this->suffix ) {
			echo '<span class="tpl-datatype-suffix tpl-preview-2">' . $this->suffix . '</span>';
		}

		echo '</div>';

	}


	// Container end of the form field
	public function form_field_after ( $args ) {

		$path_i = $this->get_level() * 2 + 1;

		if ( !empty( $this->default ) && $args["show_default"] == true ) {
			echo ' <div class="tpl-default-container">
				<i class="tpl-default-value">(';

			echo __( 'default:', 'tpl' ) . ' <pre>' . esc_html( $this->default ) . '</pre>';

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

		return nl2br( $this->prefix . $value . $this->suffix );

	}


	// Echoes the value of the option
	public function value ( $args = array(), $id = 0 ) {

		if ( $this->repeat !== false ) {

			$values = $this->get_value( $args, $id );

			if ( is_array( $values ) ) {
				echo '<ul>';
				foreach ( $values as $value ) {
					echo '<li>' . tpl_kses( $value ) . '</li>';
				}
				echo '</ul>';
				return;
			}

		}

		echo '<p>' . tpl_kses( $this->get_value( $args, $id ) ) . '</p>';

	}


}
