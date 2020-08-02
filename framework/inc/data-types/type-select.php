<?php



class TPL_Select extends TPL_Option {


	public $values = [];


	public function __construct( $args ) {
		global $tpl_select_added;

		parent::__construct( $args );

		if ( $tpl_select_added !== true ) {

			add_action( 'admin_enqueue_scripts', function ( $hook_suffix ) {
				if ( !wp_script_is( 'select2' ) ) {
					wp_enqueue_script( 'select2', TPL_ROOT_URL . 'lib/select2/js/select2.min.js', [ 'jquery' ] );
					wp_enqueue_style( 'select2-style', TPL_ROOT_URL . 'lib/select2/css/select2.min.css', [] );
				}
			}, 99 );
			$tpl_select_added = true;

		}

	}


	function initialize() {

		parent::initialize();

		if ( isset( $this->args["values"] ) ) {
			$this->set_selectable_values( $this->args["values"] );
		}

	}


	function get_admin_classes() {

		$admin_classes = parent::get_admin_classes();

		if ( !in_array( 'tpl-dt-select', $admin_classes ) ) {
			$admin_classes[] = 'tpl-dt-select';
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
		include TPL_ROOT_DIR . 'inc/templates/option/data-types/select-field-content.php';

	}


	function list_selectable_values() {

		$option = $this;
		include TPL_ROOT_DIR . 'inc/templates/option/data-types/select-field-values.php';

	}


	function get_form_field_value() {

		if ( $this->is_bank_mode() ) {
			return $this->get_default();
		}

		// Without this the repeat headers might not show correct initial previews
		if ( $this->get_single_option_by_path() == '' && $this->get_placeholder() == '' ) {
			$selectables = $this->get_selectable_values();

			if ( is_array( $selectables ) ) {
				reset( $selectables );
				return key( $selectables );
			}
		}

		return $this->get_single_option_by_path();

	}


	function form_default_value() {

		if ( $this->get_default() === '' ) {
			return '';
		}

		return sprintf( __( '(default: %s)', 'tpl' ), $this->format_option( $this->get_default() ) );

	}


	function format_option( $value ) {

		$selectables = $this->get_selectable_values();

		// First flatten the values array for better handling
		foreach ( $selectables as $key => $selectable ) {
			if ( is_array( $selectable ) ) {
				foreach ( $selectable as $sub_key => $sub_selectable ) {
					$selectables[$sub_key] = $sub_selectable;
				}
				unset( $selectables[$key] );
			}
		}

		$selected = $value;

		if ( !isset( $selectables[$selected] ) ) {
			return $selected;
		}

		return $this->prefix . $selectables[$selected] . $this->suffix;

	}


}
