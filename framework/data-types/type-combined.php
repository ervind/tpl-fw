<?php

// The file must have the type-[data-type].php filename format


class TPL_Combined extends TPL_Data_Type {


	public		$default		= array( 0 => '' );		// Needed for initializing the combined option
	public		$parts			= array();				// Initialize the parts objects
	public		$js_func		= "set_js_vars";		// Which function should create the JS variable


	public function __construct( $args ) {

		parent::__construct( $args );

		$parts_objects	= array();

		foreach ( $this->parts as $part ) {

			$part["section"]		= $this->section;
			$part["is_subitem"]		= true;
			$part["parent"]			= $this->name;
			$type_class				= tpl_get_type_class( $part["type"] );
			$part["data_name"]		= $this->data_name;

			if ( $this->js == true ) {
				$part["js"] = true;
			}

			if ( isset( $this->condition ) ) {
				$part["condition_connected"] = $this->data_name;
			}
			else if ( $this->condition_connected != '' ) {
				$part["condition_connected"] = $this->condition_connected;
			}

			$parts_objects[$part["name"]] = new $type_class( $part );

			$path_i = $this->get_level() * 2 + 1;
			$path_s = $this->get_level() * 2 + 2;
			$parts_objects[$part["name"]]->path = $this->path;
			$parts_objects[$part["name"]]->path[$path_i] = 0;
			$parts_objects[$part["name"]]->path[$path_s] = $part["name"];

		}

		$this->parts = $parts_objects;
		unset( $parts_objects );

	}


	// Writes the form field in wp-admin
	public function form_field_content ( $args ) {

		$path_i = $this->get_level() * 2 + 1;
		$path_s = $this->get_level() * 2 + 2;

		echo '<div class="tpl-combined-wrapper">';

		foreach ( $this->parts as $part ) {

			$data_connected = '';
			if ( $part->condition_connected != '' ) {
				$data_connected = ' data-connected="' . esc_attr( $part->condition_connected ) . '"';
			}

			$part->path = $this->path;
			if ( !isset( $part->path[$path_i] ) ) {
				$part->path[$path_i] = 0;
			}
			$part->path[$path_s] = $part->name;

			if ( $part->repeat !== false ) {

				if ( !isset( $part->path[$path_s+1] ) || $part->path[$path_s+1] == 0 ) {

					echo '<label for="'. esc_attr( $part->form_ref() ) .'"' . $data_connected . '>' . esc_html( $part->title ) . ' </label>';
					if ( isset( $part->description ) && $part->description != '' ) {
						echo '<i class="fa fa-sm fa-question-circle tpl-admin-question tpl-admin-icon"' . $data_connected . ' title="' . esc_attr( $part->description ) . '"></i>';
					}

				}

				echo '<div class="tpl-subitem-repeat-wrapper"' . $data_connected . '>';

				$items = $part->get_option();

				if ( !is_array( $items ) ) {
					$items = array( 0 => $items );
				}

				$end = count( $items );

				// Fixed number instances needs some extra handling
				if ( isset( $part->repeat["number"] ) ) {

					if ( $args["for_bank"] == true ) {
						$part->repeat["number"] = 1;
					}

					$end = $part->repeat["number"];

				}

				for ( $i = 0; $i < $end; $i++ ) {

					$part->path[$path_s+1] = $i;
					$part->form_field( $args );

					if ( $args["for_bank"] == true ) {
						break;
					}

				}

				echo '</div>';

				if ( !isset( $part->repeat["number"] ) ) {
					echo '<div class="tpl-button-container"' . $data_connected . '><button class="tpl-repeat-add" data-for="' . esc_attr( $part->data_name ) . '">' . esc_html( $part->repeat_button_title ) . '</button></div>';
				}

			}

			else {

				if ( !isset( $part->path[$path_s+1] ) || $part->path[$path_s+1] == 0 ) {

					echo '<label for="'. esc_attr( $part->form_ref() ) .'"' . $data_connected . '>' . esc_html( $part->title ) . ' </label>';
					if ( isset( $part->description ) && $part->description != '' ) {
						echo '<i class="fa fa-sm fa-question-circle tpl-admin-question tpl-admin-icon"' . $data_connected . ' title="' . esc_attr( $part->description ) . '"></i>';
					}

				}

				$part->form_field( $args );

			}

		}

		echo '</div>';

	}


	// Container end of the form field
	public function form_field_after ( $args ) {

		$path_i = $this->get_level() * 2 + 1;

		echo '</div>';		// .tpl-field-inner

		if ( $this->repeat !== false ) {
			$this->path[$path_i]++;
		}

		echo '</div>';

	}



	// Returns the values as an array
	public function get_value ( $args = array(), $id = 0 ) {

		$path_n = $this->get_level() * 2;
		$path_i = $this->get_level() * 2 + 1;
		$path_s = $this->get_level() * 2 + 2;

		if ( !isset( $args["path"][$path_n] ) ) {
			$args["path"][$path_n] = $this->name;
		}

		if ( $this->repeat === false ) {
			$args["path"][$path_i] = 0;
		}

		$result = array();

		$values = $this->get_option( $args, $id );

		// Full branch
		if ( !isset( $args["path"][$path_i] ) ) {

			foreach ( $values as $i => $value ) {

				$this->path[$path_i] = $i;

				foreach ( $this->parts as $part ) {
					$sub_args = array( 'path' => array_replace( $this->path, array( $path_n => $this->name, $path_i => $i, $path_s => $part->name ) ) );
					$result[$i][$part->name] = $part->get_value( $sub_args, $id );
				}

			}

		}

		else {

			// One instance of the combined
			if ( !isset( $args["path"][$path_s] ) ) {

				$this->path[$path_i] = $args["path"][$path_i];

				foreach ( $this->parts as $part ) {
					$sub_args = array( 'path' => array_replace( $this->path, array( $path_n => $this->name, $path_i => $args["path"][$path_i], $path_s => $part->name ) ) );
					$result[$part->name] = $part->get_value( $sub_args, $id );
				}

			}

			// Sub-item only
			else {

				$this->path[$path_i] = $args["path"][$path_i];

				foreach ( $this->parts as $part ) {
					if ( $part->name == $args["path"][$path_s] ) {
						$result = $part->get_value( $args, $id );
					}
				}

			}

		}

		return $result;

	}


	// Prints the value as a list
	public function value ( $args = array(), $id = 0 ) {

		$path_n = $this->get_level() * 2;
		$path_i = $this->get_level() * 2 + 1;
		$path_s = $this->get_level() * 2 + 2;

		if ( !isset( $args["path"][$path_n] ) ) {
			$args["path"][$path_n] = $this->name;
		}

		if ( $this->repeat === false ) {
			$args["path"][$path_i] = 0;
		}

		$values = $this->get_value( $args, $id );

		// List all
		if ( !isset( $args["path"][$path_i] ) ) {

			foreach ( $values as $i => $value ) {

				$this->part[$path_i] = $i;
				echo '<dl>';

				foreach ( $this->parts as $part ) {

					if ( !empty( $value[$part->name] ) ) {
						echo '<dt>' . esc_html( $part->title ) . '</dt>';
						$args["path"][$path_i] = $i;
						echo '<dd>';
						$part->value( $args, $id );
						echo '</dd>';
					}

				}
				echo '</dl>';

			}

			return;

		}

		// Only one instance
		else {

			if ( !isset( $args["path"][$path_s] ) ) {

				echo '<dl>';
				foreach ( $this->parts as $part ) {

					if ( !empty( $values[$part->name] ) ) {
						$args["path"][$path_s] = $part->name;
						echo '<dt>' . esc_html( $part->title ) . '</dt>';
						echo '<dd>';
						$part->value( $args, $id );
						echo '</dd>';
					}

				}
				echo '</dl>';

			}

			// Only one sub-item
			else {

				foreach ( $this->parts as $part ) {
					if ( $part->name == $args["path"][$path_s] ) {
						$part->value( $args, $id );
					}
				}

			}

		}

	}


	// Returns the full option object
	public function get_object ( $args = array(), $id = 0 ) {

		$path_n = $this->get_level() * 2;
		$path_s = $this->get_level() * 2 + 2;

		if ( !isset( $args["path"][$path_n] ) ) {
			$args["path"][$path_n] = $this->name;
		}

		// Full object
		if ( !isset( $args["path"][$path_s] ) ) {

			return $this;

		}

		// Single branch
		else {

			foreach ( $this->parts as $part ) {

				if ( $part->name == $args["path"][$path_s] ) {
					return $part;
				}

			}

		}

	}


	public function set_js_vars ( $args = array() ) {

		$result = array();

		if ( $this->js == true ) {

			$path_n = $this->get_level() * 2;
			$path_i = $this->get_level() * 2 + 1;
			$path_s = $this->get_level() * 2 + 2;

			if ( !isset( $args["path"][$path_n] ) ) {
				$args["path"][$path_n] = $this->name;
			}

			if ( $this->repeat === false ) {
				$args["path"][$path_i] = 0;
			}

			$values = $this->get_option( $args );

			// Full branch
			if ( !isset( $args["path"][$path_i] ) ) {

				foreach ( $values as $i => $value ) {
					foreach ( $this->parts as $part ) {
						$js_func = $part->js_func;
						$sub_args = array( 'path' => array_replace( $args["path"], array( $path_n => $this->name, $path_i => $i, $path_s => $part->name ) ) );
						$result[$i][$part->name] = $part->$js_func( $sub_args );
					}
				}

			}

			else {

				// One instance of the combined
				if ( !isset( $args["path"][$path_s] ) ) {

					foreach ( $this->parts as $part ) {
						$js_func = $part->js_func;
						$sub_args = array( 'path' => array_replace( $args["path"], array( $path_n => $this->name, $path_i => $args["path"][$path_i], $path_s => $part->name ) ) );
						$result[$part->name] = $part->$js_func( $sub_args );
					}

				}

				// Sub-item only
				else {

					foreach ( $this->parts as $part ) {
						$js_func = $part->js_func;
						if ( $part->name == $args["path"][$path_s] ) {
							$result = $part->$js_func( $args );
						}
					}

				}

			}

		}

		return $result;

	}


	// Return the conditions (if any) for this option
	public function get_conditions() {

		$conditions = array();


		if ( isset( $this->condition ) ) {
			$conditions[$this->data_name] = $this->condition;
		}

		foreach ( $this->parts as $part ) {
			if ( isset( $part->condition ) ) {
				$conditions[$part->data_name] = $part->condition;
			}
			else {
				$sub_conditions = $part->get_conditions();
				if ( $sub_conditions !== false ) {
					return array_merge( $conditions, $sub_conditions );
				}
			}
		}

		if ( !empty( $conditions ) ) {
			return $conditions;
		}
		else {
			return false;
		}

	}


}
