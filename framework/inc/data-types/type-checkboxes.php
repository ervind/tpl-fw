<?php



class TPL_Checkboxes extends TPL_Option {


	public $values	= [];
	public $default	= '';


	function initialize() {

		if ( isset( $this->args["values"] ) ) {
			$this->set_selectable_values( $this->args["values"] );
		}

		parent::initialize();

	}


	function get_admin_classes() {

		$admin_classes = parent::get_admin_classes();

		if ( !in_array( 'tpl-dt-checkboxes', $admin_classes ) ) {
			$admin_classes[] = 'tpl-dt-checkboxes';
		}

		return $admin_classes;

	}


	function set_selectable_values( $values ) {

		$this->values = $values;

	}


	function get_selectable_values() {

		return $this->values;

	}


	function form_field_content() {

		$option = $this;
		include TPL_ROOT_DIR . 'inc/templates/option/data-types/checkboxes-field-content.php';

	}


	function set_default( $default ) {

		$default_raw = '';

		foreach ( $this->get_selectable_values() as $key => $value ) {
			if ( !isset( $default[$key] ) ) {
				$default[$key] = 0;
			}
			$default_raw .= $key . ':' . $default[$key] . ',';
		}

		$default_raw = rtrim( $default_raw, ',' );

		$this->default = $default_raw;

	}


	function form_default_value() {

		if ( $this->get_default() === '' ) {
			return '';
		}

		$defaults = $this->format_option( $this->get_default() );

		return sprintf( __( '(default: %s)', 'tpl' ), $this->get_values_list( $defaults ) );

	}


	function get_values_list( $values = false ) {

		$values_list = '';

		if ( $values === false ) {
			$values = $this->get_value();
		}

		if ( $values == '' ) {
			$values = [];
		}

		foreach ( $this->get_selectable_values() as $key => $label ) {
			if ( !isset( $values[$key] ) ) {
				$values[$key] = false;
			}
			if ( $values[$key] == true ) {
				$values_list .= $label . ', ';
			}
		}

		return rtrim( $values_list, ', ' );

	}


	function format_option( $value ) {

		if ( !is_array( $value ) && !empty( $value ) ) {
			$raw_array = explode( ',', $value );
			$value = [];
			foreach ( $raw_array as $line ) {
				$item = explode( ':', $line );
				if ( !isset( $item[1] ) ) {
					$item[1] = 0;
				}
				$value[$item[0]] = $item[1];
			}
		}

		return $value;

	}


	function is_key_selected( $key ) {

		$values = $this->format_option( $this->get_single_option_by_path() );

		if ( isset( $values[$key] ) && $values[$key] ) {
			return 1;
		}

		return 0;

	}


	function value() {

		if ( $this->is_repeater() ) {

			$values = $this->get_value();

			if ( is_array( $values ) ) { ?>
				<ul>
					<?php foreach ( $values as $value ) { ?>
						<li><?php echo $this->get_values_list( $value ); ?></li>
					<?php } ?>
				</ul>
			<?php }

		}

		else {
			echo $this->get_values_list();
		}

	}


}
