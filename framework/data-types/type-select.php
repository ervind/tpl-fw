<?php

// The file must have the type-[data-type].php filename format


class TPL_Select extends TPL_Data_Type {


	public		$key				= false;		// Should return the key (true) or the label (false)?


	public function __construct( $args ) {

		global $tpl_select_added;

		parent::__construct( $args );

		if ( $tpl_select_added !== true ) {

			add_action( 'admin_enqueue_scripts', function ( $hook_suffix ) {
				if ( !wp_script_is( 'select2' ) ) {
					wp_enqueue_script( 'tpl-select2', tpl_base_uri() . '/framework/lib/select2/js/select2.min.js', array( 'jquery' ) );
				}
				wp_enqueue_style( 'tpl-select2-style', tpl_base_uri() . '/framework/lib/select2/css/select2.min.css', array() );
			} );
			$tpl_select_added = true;

		}

	}


	// Writes the form field in wp-admin
	public function form_field_content ( $args ) {

		echo '<div class="tpl-datatype-container">';

		if ( $this->prefix ) {
			echo '<span class="tpl-datatype-prefix tpl-preview-0">' . $this->prefix . '</span>';
		}

		// The saved or default value:
		$id = $this->get_option();

		if ( ( $id == '' || $args["for_bank"] == true ) && ( isset( $this->default ) ) ) {
			$id = $this->default;
		}

		echo '<select class="tpl-preview-1" id="' . esc_attr( $this->form_ref() ) . '" name="' . esc_attr( $this->form_ref() ) . '" autocomplete="off">';

		if ( $this->placeholder != '' ) {
			echo '<option value="">' . esc_html( $this->placeholder ) . '</option>';
		}

		foreach ( $this->values as $key => $value ) {

			if ( is_array( $value ) ) {

				echo '<optgroup label="' . esc_attr( $key ) . '">';

				foreach ( $value as $sub_key => $sub_value ) {

					echo '<option value="' . esc_attr( $sub_key ) . '"';

					if ( $sub_key == $id ) {
						echo ' selected';
					}

					echo '>' . esc_html( $sub_value ) . '</option>';

				}

				echo '</optgroup>';

			}

			else {

				echo '<option value="' . esc_attr( $key ) . '"';

				if ( $key == $id ) {
					echo ' selected';
				}

				echo '>' . esc_html( $value ) . '</option>';

			}

		}

		echo '</select>';

		if ( $this->suffix ) {
			echo '<span class="tpl-datatype-suffix tpl-preview-2">' . $this->suffix . '</span>';
		}

		echo '</div>';

		// If called from the front end, needs to enqueue some extra files
		if ( !is_admin() ) {

			if ( !wp_script_is( 'select2' ) ) {
				wp_enqueue_script( 'tpl-select2', tpl_base_uri() . '/framework/lib/select2/js/select2.min.js', array( 'jquery' ) );
			}
			wp_enqueue_style( 'tpl-select2-style', tpl_base_uri() . '/framework/lib/select2/css/select2.min.css', array() );

			wp_enqueue_style( 'tpl-common-style', tpl_base_uri() . '/framework/style/common.css', array(), false );

		}

	}


	// Container end of the form field
	public function form_field_after ( $args ) {

		$path_i = $this->get_level() * 2 + 1;

		if ( !empty( $this->default ) && $args["show_default"] == true ) {
			echo '<div class="tpl-default-container">
				<i class="tpl-default-value">(';

			echo __( 'default:', 'tpl' ) . ' ' . tpl_kses( $this->format_option( $this->default, array( "key" => false ) ) );

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
	public function format_option ( $id, $args = array() ) {

		// Deciding to return the key or the value
		if ( !isset( $args["key"] ) ) {
			$key = $this->key;
		}
		else {
			$key = $args["key"];
		}

		$values = $this->values;

		foreach ( $values as $k => $value ) {
			if ( is_array( $value ) ) {
				foreach ( $value as $sub_key => $sub_value ) {
					$values[$sub_key] = $sub_value;
				}
				unset( $values[$k] );
			}
		}

		if ( $key ) {
			return $id;
		}
		elseif ( !isset( $values[$id] ) ) {
			return $id;
		}
		else {
			return $this->prefix . $values[$id] . $this->suffix;
		}

	}


	// Gets the options in Gutenberg SelectControl format
	public function gutenberg_values() {

		$gutenberg_values = array();

		foreach ( $this->values as $key => $value ) {

			$gutenberg_values[] = array(
				"value"	=> $key,
				"label"	=> $value,
			);

		}

		return $gutenberg_values;

	}


}
