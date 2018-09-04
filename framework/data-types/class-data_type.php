<?php

// This is the default data type class. All the data types are children of this class.


class TPL_Data_Type {

	// Setting up some defaults...

	public		$prefix				= "";			// Is put before the value
	public		$suffix				= "";			// Is put after the value
	public		$placeholder		= "";			// Used in admin if no value is added yet
	public		$default			= '';			// Default value init
	public		$data_name			= '';			// Used by forms in the admin
	public		$js					= false;		// By default, JS is turned off
	public		$js_func			= "get_value";	// Which function should create the JS variable
	public		$repeat				= false;		// Is it a repeater / multi-instance option?
	public		$admin_class		= '';			// Extra class added to the admin field
	public		$description		= '';			// Initialize the option's description
	public		$condition_connected = '';			// Some initialization for conditions
	protected	$is_subitem			= false;		// Is set to TRUE if it's a subitem of another option
	protected	$path				= array();		// Used to find instances and subitems of an option


	// Sets up the object attributes while registering options
	public function __construct( $args ) {

		// If the field is repeater, this is written on the Add button
		if ( !isset( $args["repeat_button_title"] ) ) {
			$args["repeat_button_title"] = __( 'Add row', 'tpl' );
		}

		$args = apply_filters( 'tpl_before_option_object_created', $args );

		// Setting up initial values
		foreach ( $args as $key => $arg ) {
			$this->$key = $arg;
		}

		// Error handling
		if ( !isset( $this->name ) ) {
			tpl_error( __( 'The "name" attribute is required during registering options', 'tpl' ), true );
			die();
		}

		if ( !isset( $this->title ) ) {
			$this->title = $this->name;
			tpl_error(
				sprintf(
					__( 'It\'s recommended to set a title for "%s" option', 'tpl' ),
					esc_html( $this->name )
				), true, 'notice-warning'
			);
		}

		if ( !isset( $this->section ) ) {
			$this->section = "dummy-section";
			tpl_error(
				sprintf(
					__( 'It\'s recommended to assign %s to a section. Using a dummy section to avoid errors...', 'tpl' ),
					esc_html( $this->name )
				), true
			);
		}

		if ( empty( $this->path ) ) {
			$path_n = $this->get_level() * 2;
			$this->path[$path_n] = $this->name;
		}

		if ( $this->is_subitem ) {
			$this->data_name .= '/' . $this->name;
		}
		else {
			$this->data_name = $this->name;
		}

		if ( isset( $this->condition ) ) {
			$this->condition_connected = $this->data_name;
		}

		if ( $this->repeat == true ) {

			add_filter( 'tpl_admin_js_strings', array( $this, 'admin_js_strings' ) );

			add_action( 'admin_enqueue_scripts', function ( $hook_suffix ) {
				wp_enqueue_script( 'jquery-ui-sortable', '', array( 'jquery', 'jquery-ui-core' ) );
			} );

		}

	}


	// Gets the pure form reference name based on the option name. Virtually converts the option name used by TPL into a WP backend form friendly name
	public function form_ref () {

		global $tpl_sections, $tpl_settings_pages;

		if ( tpl_is_primary_section( $this->section ) ) {
			$form_ref = $this->get_data_section() . '[' . $this->path[0] . ']';
		}
		else {
			$form_ref = $this->path[0];
		}

		foreach ( $this->path as $i => $step ) {
			if ( $i > 0 ) {
				$form_ref .= '[' . $step . ']';
			}
		}

		return $form_ref;

	}


	// Shows the form field in wp-admin
	public function form_field ( $args = array() ) {

		$path_i = $this->get_level() * 2 + 1;

		if ( !isset( $args["for_bank"] ) ) {
			$args["for_bank"] = false;
		}

		if ( !isset( $args["show_default"] ) ) {
			$args["show_default"] = true;
		}

		if ( !$this->is_subitem ) {
			$this->path = array( 0 => $this->name );
		}

		if ( $this->repeat !== false ) {

			$values = $this->get_option();

			// If it was a non-repeater field before, convert the result to array
			if ( !is_array( $values ) || !is_numeric( key( $values ) ) ) {
				$values = array( 0 => $values );
			}

			if ( ( count( $values ) >= 1 && $values[0] != '' ) || $args["for_bank"] == true || isset( $this->repeat["number"] ) ) {

				$end = count( $values );

				for ( $i = 0; $i < $end; $i++ ) {

					if ( !$this->is_subitem ) {
						$this->path[$path_i] = $i;
					}

					// Now the path is set up

					$this->form_field_before( $args );
					$this->form_field_content( $args );
					$this->form_field_after( $args );

					if ( $args["for_bank"] == true ) {
						break;
					}

				}

			}

		}

		else {

			if ( !$this->is_subitem ) {
				$this->path[$path_i] = 0;
			}

			// Now the path is set up

			$this->form_field_before( $args );
			$this->form_field_content( $args );
			$this->form_field_after( $args );

		}

	}


	// Container start of the form field
	public function form_field_before ( $args = array() ) {

		if ( !isset( $args["extra_class"] ) ) {
			$args["extra_class"] = '';
		}

		$path_i = $this->get_level() * 2 + 1;

		if ( isset( $this->path[$path_i] ) ) {
			$data_instance = $this->path[$path_i];
		}
		else {
			$data_instance = 0;
		}

		if ( $this->repeat !== false ) {
			$args["extra_class"] .= ' tpl-repeat';
		}

		// Extra admin classes if needed
		if ( $this->admin_class != '' ) {
			$args["extra_class"] .= ' ' . $this->admin_class;
		}

		// If child item of a combined field
		if ( $this->is_subitem ) {
			$args["extra_class"] .= ' tpl-subitem';
		}

		// Which condition is it connected to if there's any
		$data_connected = '';
		if ( $this->condition_connected != '' ) {
			$data_connected = ' data-connected="' . esc_attr( $this->condition_connected ) . '"';
		}

		$class = preg_replace( '/\s+/', ' ', 'tpl-field tpl-dt-'. $this->type . ' ' . $args["extra_class"]  );

		echo '<div class="' . esc_attr( $class ) . '" data-instance="' . esc_attr( $data_instance ) . '" data-name="' . esc_attr( $this->data_name ) . '" data-level="' . esc_attr( $this->get_level() ) . '"' . $data_connected . '>';

		// Repeater fields
		if ( $this->repeat !== false ) {

			// If it goes for the repeater bank, keep it open (newly added instances are displayed open by default)
			if ( $args["for_bank"] ) {
				$header_state_class = '';
				$toggle_class = ' tpl-toggle-close';
				$toggle_title = __( 'Minimize', 'tpl' );
			}
			else {
				$header_state_class = ' tpl-repeat-header-closed';
				$toggle_class = ' tpl-toggle-open';
				$toggle_title = __( 'Maximize', 'tpl' );
			}

			echo '<div class="tpl-repeat-header' . $header_state_class . '">
					<div class="tpl-admin-icon fa tpl-arranger" title="' . __( 'Drag & Drop to reorder', 'tpl' ) . '"></div>
					<div class="tpl-header-title"><span class="tpl-header-title-instance">(#' . $data_instance . ')</span><span class="tpl-header-title-preview"></span></div>
					<div class="tpl-admin-icon fa tpl-toggle' . $toggle_class . '" title="' . $toggle_title . '"></div>';

			if ( !isset( $this->repeat["number"] ) ) {
				echo '<div class="tpl-admin-icon fa tpl-remover" title="' . __( 'Remove row', 'tpl' ) . '"></div>';
			}

			echo '</div>';

		}

		echo '<div class="tpl-field-inner';
		if ( $this->repeat && !$args["for_bank"] ) {
			echo ' tpl-admin-hide';
		}
		echo '">';

	}


	// Content of the form field
	public function form_field_content ( $args ) {

		$value = $this->get_option();
		if ( $value == '' || $args["for_bank"] == true ) {
			$value = $this->default;
		}
		echo $value;

	}


	// Displayed after the form field
	public function form_field_after ( $args ) {

		$path_i = $this->get_level() * 2 + 1;

		if ( $this->default != '' && $args["show_default"] == true ) {
			echo '<div class="tpl-default-container">
				<i class="tpl-default-value">(';

			echo __( 'default:', 'tpl' ) . ' ' . $this->format_option( $this->default );

			echo ')</i>
			</div>';
		}

		echo '</div>';		// .tpl-field-inner

		if ( $this->repeat !== false ) {
			$this->path[$path_i]++;
		}

		echo '</div>';

	}


	// This function gets the section name needed for the form fields in the admin
	public function get_data_section () {

		global $tpl_sections, $tpl_settings_pages;

		if ( tpl_is_primary_section( $this->section ) ) {
			foreach ( $tpl_settings_pages as $key => $settings_page ) {
				if ( !tpl_section_registered( $this->section ) ) {
					return $key;
				}
				if ( $settings_page["post_type"] == $tpl_sections[$this->section]['post_type'] ) {
					return $key;
				}
			}
		}

		return $this->section;

	}


	// Get which settings page the option is connected to. If it's connected to a post or page, returns empty string
	public function get_settings_page () {

		global $tpl_sections, $tpl_settings_pages;

		if ( tpl_is_primary_section( $this->section ) ) {
			foreach ( $tpl_settings_pages as $key => $settings_page ) {
				if ( $settings_page["post_type"] == $tpl_sections[$this->section]['post_type'] ) {
					if ( $settings_page["menu_func"] == 'add_theme_page' ) {
						return 'appearance_page';
					}
					if ( $settings_page["menu_func"] == 'add_options_page' ) {
						return 'settings_page';
					}
				}
			}
		}

		return '';

	}


	// Gets the pure value of an option from the database and returns it if any values found --- returns default value or empty string if no value found in database.
	// This function is used by data types, please use it if you are writing your own data type!
	// In your template files use tpl_get_value instead
	public function get_option ( $args = array(), $id = 0 ) {

		global $tpl_sections;


		if ( isset( $args["path"] ) ) {
			$this->path = $args["path"];
		}

		if ( !isset( $this->path[0] ) ) {
			$this->path[0] = $this->name;
		}


		// If the option is connected to a post meta, let it be the return value
		if ( !tpl_is_primary_section( $this->section ) ) {

			if ( $id == 0 ) {
				global $post;
				$id = $post->ID;
			}

			$meta_key = '_tpl_' . $this->name;

			if ( !tpl_has_section_post_type( $this->section, get_post_type( $id ) ) ) {
				return false;
			}

			// If the metadata exists in the database, return it!
			if ( metadata_exists( 'post', $id, $meta_key ) ) {
				$options = get_post_meta( $id, $meta_key );
				$options = array(
					$this->name	=> $options[0],
				);
			}

			// If not, return the default value defined in your options file
			else {
				return $this->default;
			}
		}

		// ... or a Settings page by default
		else {
			$options = get_option( $this->get_data_section() );
		}


		// Deciding what to return
		if ( is_array( $options ) ) {

			if ( $this->repeat === false && count( $this->path ) == 1 ) {
				$this->path[1] = 0;
			}

			if ( isset( $options[$this->path[0]] ) ) {

				$value = $options[$this->path[0]];

				foreach ( $this->path as $step => $item ) {
					if ( $step > 0 ) {
						if ( isset( $value[$item] ) ) {
							if ( is_array( $value ) ) {
								$value = $value[$item];
							}
						}
						else {
							$value = $this->default;
							break;
						}
					}
				}

			}

			else {

				$value = $this->default;

			}

			// Normal return
			return $value;

		}
		else {

			return $this->default;

		}

	}


	// Returns the formatted value (with suffix and prefix)
	public function get_value ( $args = array(), $id = 0 ) {

		$path_n = $this->get_level() * 2;
		$path_i = $this->get_level() * 2 + 1;

		if ( !isset( $args["path"][$path_n] ) ) {
			$args["path"][$path_n] = $this->name;
		}

		if ( $this->repeat === false ) {
			$args["path"][$path_i] = 0;
		}

		$result = array();
		ksort( $args["path"] );

		$values = $this->get_option( $args, $id );

		// Repeater branch
		if ( !isset( $args["path"][$path_i] ) && is_array( $values ) ) {

			foreach ( $values as $i => $value ) {
				$result[$i] = $this->format_option( $value, $args );
			}

		}

		// Single branch
		else {

			$result = $this->format_option( $values, $args );

		}

		return $result;

	}


	// Echoes the value of the option
	public function value ( $args = array(), $id = 0 ) {

		$path_i = $this->get_level() * 2 + 1;

		if ( $this->repeat === false ) {
			$args["path"][$path_i] = 0;
		}

		$values = $this->get_value( $args, $id );

		if ( !isset( $args["path"][$path_i] ) ) {

			if ( is_array( $values ) ) {
				echo '<ul>';
				foreach ( $values as $value ) {
					echo '<li>' . tpl_kses( $value ) . '</li>';
				}
				echo '</ul>';
				return;
			}

		}

		else {

			echo tpl_kses( $this->get_value( $args, $id ) );

		}

	}


	// Returns the full option object
	public function get_object ( $args = array(), $id = 0 ) {

		return $this;

	}


	// Formats the option into value
	public function format_option ( $value, $args = array() ) {

		return $this->prefix . $value . $this->suffix;

	}


	// Gets the default value
	public function get_default () {

		return $this->default;

	}


	// Return which level the option is on in the subitem hierarchy ( 0 = base level )
	protected function get_level () {

		$level = substr_count( $this->data_name, '/' );

		return $level;

	}


	// Helper function if you want to echo the value
	public function __toString() {

        return $this->get_value();

    }


	// Return the conditions (if any) for this option
	public function get_conditions() {

		if ( isset( $this->condition ) ) {
			return array(
				$this->data_name => $this->condition
			);
		}

		else {
			return false;
		}

	}


	// Strings to be added to the admin JS files
	public function admin_js_strings( $strings ) {

		$strings = array_merge( $strings, array(
			'remover_confirm_text'	=> __( 'Do you really want to remove this instance?', 'tpl' ),
			'Repeat_Minimize'		=> __( 'Minimize', 'tpl' ),
			'Repeat_Maximize'		=> __( 'Maximize', 'tpl' ),
			'Show_Settings'			=> __( 'Show Settings', 'tpl' ),
			'Hide_Settings'			=> __( 'Hide Settings', 'tpl' ),
		) );

		if ( isset( $this->preview ) ) {
			$strings[$this->data_name.'_preview-template'] = $this->preview;
		}

		return $strings;

	}


}
