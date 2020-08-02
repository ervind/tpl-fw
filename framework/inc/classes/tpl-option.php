<?php // Option management class



class TPL_Option {


	public		$prefix			= '';
	public		$suffix			= '';
	public		$title			= '';
	public		$default		= '';
	public		$admin_class	= '';
	public		$for_bank		= false;
	protected	$post			= NULL;


	function __construct( $args ) {

		$this->args = $args;
		$this->initialize();

		$this->set_path( [
			0	=> $this->get_name(),
			1	=> 0,
		] );

		$this->setup_hooks();

	}


	function setup_hooks() {

		if ( $this->is_repeater() ) {

			add_filter( 'tpl_admin_js_strings', [ $this, 'admin_js_strings' ] );
			add_action( 'admin_enqueue_scripts', function( $hook_suffix ) {
				wp_enqueue_script( 'jquery-ui-sortable', '', [ 'jquery', 'jquery-ui-core' ] );
			} );

		}

	}


	function initialize() {

		if ( isset( $this->args["name"] ) ) {
			$this->set_name( $this->args["name"] );
		}

		if ( isset( $this->args["title"] ) ) {
			$this->set_title( $this->args["title"] );
		}

		if ( isset( $this->args["description"] ) ) {
			$this->set_description( $this->args["description"] );
		}
		else {
			$this->set_description( '' );
		}

		if ( isset( $this->args["section"] ) ) {
			$this->set_section( $this->args["section"] );
		}

		if ( isset( $this->args["type"] ) ) {
			$this->set_type( $this->args["type"] );
		}

		if ( isset( $this->args["condition"] ) ) {
			$this->set_conditions( $this->args["condition"] );
		}

		if ( isset( $this->args["default"] ) ) {
			$this->set_default( $this->args["default"] );
		}

		if ( isset( $this->args["prefix"] ) ) {
			$this->set_prefix( $this->args["prefix"] );
		}

		if ( isset( $this->args["suffix"] ) ) {
			$this->set_suffix( $this->args["suffix"] );
		}

		if ( isset( $this->args["placeholder"] ) ) {
			$this->set_placeholder( $this->args["placeholder"] );
		}

		if ( isset( $this->args["repeat"] ) ) {
			$this->set_repeater( $this->args["repeat"] );
		}

		if ( $this->is_repeater() ) {

			if ( isset( $this->args["repeat_button_title"] ) ) {
				$this->set_repeat_button_title( $this->args["repeat_button_title"] );
			}
			else {
				$this->set_repeat_button_title( __( 'Add row', 'tpl' ) );
			}

		}

	}


	function get_name() {

		return $this->name;

	}


	function set_name( $name ) {

		$this->name = $name;

	}


	function get_title() {

		return $this->title;

	}


	function set_title( $title ) {

		$this->title = $title;

	}


	function get_description() {

		return $this->description;

	}


	function set_description( $description ) {

		$this->description = $description;

	}


	function get_section() {

		return $this->section;

	}


	function set_section( $section_name ) {
		global $tpl_fw;

		$this->section = $tpl_fw->get_section( $section_name );

	}


	function get_type() {

		return $this->type;

	}


	function set_type( $type ) {

		$this->type = $type;

	}


	function get_default() {

		return $this->default;

	}


	function set_default( $default ) {

		$this->default = $default;

	}


	function get_prefix() {

		return $this->prefix;

	}


	function set_prefix( $prefix ) {

		$this->prefix = $prefix;

	}


	function get_suffix() {

		return $this->suffix;

	}


	function set_suffix( $suffix ) {

		$this->suffix = $suffix;

	}


	function get_placeholder() {

		if ( isset( $this->placeholder ) ) {
			return $this->placeholder;
		}

		return '';

	}


	function set_placeholder( $placeholder ) {

		$this->placeholder = $placeholder;

	}


	function admin_js_strings( $strings ) {

		$strings = array_merge( $strings, [
			"remover_confirm_text"	=> __( 'Do you really want to remove this instance?', 'tpl' ),
			"repeat_minimize"		=> __( 'Minimize', 'tpl' ),
			"repeat_maximize"		=> __( 'Maximize', 'tpl' ),
		] );

		return $strings;

	}


	function add_settings_field( $settings_page ) {

		add_settings_field(
			$this->get_name(),
			$this->get_title(),
			[ $this, 'settings_page_field' ],
			$settings_page->get_name(),
			$this->section->get_name()
		);

	}


	function get_settings_page() {
		global $tpl_fw;

		if ( $this->section->is_primary() ) {
			foreach ( $tpl_fw->get_settings_pages() as $settings_page ) {

				if ( $settings_page->get_post_type() && $this->section->has_post_type( $settings_page->get_post_type() ) ) {
					return $settings_page;
				}

			}
		}

		return false;

	}


	function settings_page_field() {

		$this->form_field();

		if ( $this->is_repeater() ) {
			$this->repeater_button();
		}

		if ( $this->get_description() ) {
			$this->field_description();
		}

	}


	function repeater_header() {

		if ( $this->is_repeater() ) {
			$option = $this;
			include TPL_ROOT_DIR . 'inc/templates/option/repeat-header.php';
		}

	}


	function repeater_button() {

		$option = $this;
		include TPL_ROOT_DIR . 'inc/templates/option/repeat-button.php';

	}


	function set_repeater( $repeat ) {

		$this->repeat = $repeat;

	}


	function is_repeater() {

		if ( isset( $this->repeat ) ) {
			return $this->repeat;
		}

		return false;

	}


	function set_repeat_button_title( $repeat_button_title ) {

		return $this->repeat_button_title = $repeat_button_title;

	}


	function get_repeat_button_title() {

		return $this->repeat_button_title;

	}


	function field_description() {

		$option = $this;
		include TPL_ROOT_DIR . 'inc/templates/option/field-description.php';

	}


	function metabox_row() {

		if ( !$this->post ) {
			return;
		}

		if ( get_post_ancestors( $this->post ) && $this->get_visibility_level() == 'parent' ) {
			return;
		}

		if ( get_children( [ "post_parent" => $this->post->ID ] ) && $this->get_visibility_level() == 'child' ) {
			return;
		}

		$option = $this;
		include TPL_ROOT_DIR . 'inc/templates/metabox/metabox-row.php';

	}


	function save_post_meta() {

		$form_reference = explode( '[', $this->form_ref() );
		$base_name = $form_reference[0];

		if ( is_object( $this->post ) ) {

			if ( isset( $_POST[$base_name] ) ) {

				if ( $this->is_repeater() == false ) {
					$data = $_POST[$base_name][0];
				}
				else {
					$data = $_POST[$base_name];
				}

				update_post_meta( $this->post->ID, $this->get_meta_key(), $data );

			}
			else {
				delete_post_meta( $this->post->ID, $this->get_meta_key() );
			}

		}

	}


	function set_post( $post = 0 ) {

		if ( is_numeric( $post ) && ( $post == intval( $post ) ) ) {

			if ( $post == 0 ) {
				global $post;
				$this->post = $post;
			}

			else {
				$this->post = get_post( $post );
			}

		}

		else if ( is_object( $post ) ) {
			$this->post = $post;
		}

	}


	function print_form_ref() {

		if ( !$this->is_bank_mode() ) {
			echo 'id="' . esc_attr( $this->form_ref() ) . '" name="' . esc_attr( $this->form_ref() ) . '"';
		}

	}


	function form_ref() {

		if ( $this->section->is_primary() ) {
			$settings_page = $this->get_settings_page();
			$form_ref = $settings_page->get_name() . '[' . $this->path[0] . ']';
		}
		else {
			$form_ref = $this->path[0];
		}

		if ( count( $this->path ) > 1 ) {
			foreach ( $this->path as $step => $step_name ) {
				if ( $step > 0 ) {
					$form_ref .= '[' . $step_name . ']';
				}
			}
		}

		return $form_ref;

	}


	function form_field() {

		$db_values = (array) $this->get_option();

		if ( $db_values ) {

			foreach ( $db_values as $instance => $value ) {

				if ( !$this->is_subitem() ) {
					$this->path[1] = $instance;
				}

				$option = $this;
				include TPL_ROOT_DIR . 'inc/templates/option/field.php';

			}

		}

	}


	function bank_form_field() {

		$this->set_bank_mode( true );

		$option = $this;
		include TPL_ROOT_DIR . 'inc/templates/option/field.php';

		$this->set_bank_mode( false );

	}


	function get_form_field_value() {

		if ( $this->is_bank_mode() ) {
			return $this->get_default();
		}

		return $this->get_single_option_by_path();

	}


	function set_bank_mode( bool $toggle ) {

		$this->for_bank = $toggle;

	}


	function is_bank_mode() {

		return $this->for_bank;

	}


	function form_field_content() {

		return $this->get_single_option_by_path();

	}


	function form_field_default() {

		if ( $this->form_default_value() != '' ) {
			$option = $this;
			include TPL_ROOT_DIR . 'inc/templates/option/default.php';
		}

	}


	function form_default_value() {

		if ( $this->get_default() === '' ) {
			return '';
		}

		return sprintf( __( '(default: %s)', 'tpl' ), $this->get_default() );

	}


	function form_field_admin_classes() {

		echo implode( ' ', $this->get_admin_classes() );

	}


	function get_admin_classes() {

		$admin_classes = [ 'tpl-field', 'tpl-dt-' . $this->get_type() ];

		if ( $this->is_subitem() ) {
			$admin_classes[] = 'tpl-subitem';
		}

		if ( $this->is_repeater() ) {
			$admin_classes[] = 'tpl-repeat';
		}

		if ( $this->get_prefix() != '' ) {
			$admin_classes[] = 'tpl-has-prefix';
		}

		if ( $this->get_suffix() != '' ) {
			$admin_classes[] = 'tpl-has-suffix';
		}

		if ( isset( $this->args["admin_class"] ) && $this->args["admin_class"] ) {
			if ( is_array( $this->args["admin_class"] ) ) {
				$admin_classes = array_merge( $admin_classes, $this->args["admin_class"] );
			}
			else {
				$admin_classes[] = $this->args["admin_class"];
			}
		}

		return $admin_classes;

	}


	function form_field_prefix() {

		if ( $this->get_prefix() ) {
			$option = $this;
			include TPL_ROOT_DIR . 'inc/templates/option/prefix.php';
		}

	}


	function form_field_suffix() {

		if ( $this->get_suffix() ) {
			$option = $this;
			include TPL_ROOT_DIR . 'inc/templates/option/suffix.php';
		}

	}


	function is_subitem() {

		if ( strpos( $this->get_multi_level_name(), '/' ) !== false ) {
			return true;
		}

		return false;

	}


	function get_current_instance() {

		if ( isset( $this->path[1] ) && is_numeric( $this->path[1] ) ) {
			$current_instance = $this->path[1];
		}
		else {
			$current_instance = 0;
		}

		return $current_instance;

	}


	function get_multi_level_name() {

		if ( count( $this->path ) > 2 ) {
			$name = '';
			foreach ( $this->path as $step => $value ) {
				if ( $step % 2 == 0 ) {
					$name .= $value . '/';
				}
			}
			$name = rtrim( $name, '/' );
		}
		else {
			$name = $this->get_name();
		}

		return $name;

	}


	function get_parent() {
		global $tpl_fw;

		if ( $this->is_subitem() ) {
			return $tpl_fw->get_option( $this->path[0] );
		}

		return false;

	}


	function get_level() {

		return substr_count( $this->get_multi_level_name(), '/' );

	}


	function get_conditions() {

		if ( isset( $this->conditions ) ) {
			return [
				$this->get_multi_level_name() => $this->conditions
			];
		}

		return false;

	}


	function set_conditions( $conditions ) {

		$this->conditions = $conditions;

	}


	function set_path( $path ) {

		$this->path = $path;

	}


	function get_option() {

		if ( $this->is_repeater() ) {
			return $this->get_repeater_option();
		}

		return $this->get_single_option_by_path();

	}


	function get_single_option_by_path() {

		$saved_values = $this->get_saved_values();

		if ( !is_array( $saved_values ) ) {
			return $this->get_default();
		}

		foreach ( $this->path as $step => $step_name ) {
			if ( isset( $saved_values[$step_name] ) ) {
				$saved_values = $saved_values[$step_name];
			}
		}

		if ( !is_array( $saved_values ) ) {
			return $saved_values;
		}

		return $this->get_default();

	}


	function get_repeater_option() {

		$saved_values = $this->get_saved_values();

		if ( isset( $saved_values[$this->get_name()] ) ) {
			return $saved_values[$this->get_name()];
		}

		return [];

	}


	function get_saved_values() {

		if ( $this->section->is_primary() ) {
			return $this->get_settings_page_db_values();
		}
		else {
			return $this->get_metabox_db_values();
		}

	}


	function get_settings_page_db_values() {

		$settings_page = $this->get_settings_page();
		$values = get_option( $settings_page->get_name() );
		return apply_filters( 'tpl_' . $settings_page->get_name() . '_db_values', $values );

	}


	function get_metabox_db_values() {

		if ( !$this->post ) {
			return false;
		}

		if ( !$this->section->has_post_type( get_post_type( $this->post ) ) ) {
			return false;
		}

		if ( metadata_exists( 'post', $this->post->ID, $this->get_meta_key() ) ) {

			$options = get_post_meta( $this->post->ID, $this->get_meta_key() );

			if ( $this->is_repeater() || ( $this->is_subitem() && $this->get_parent()->is_repeater() ) ) {
				return [ $this->get_meta_key( '' ) => $options[0] ];
			}
			else {
				return [ $this->get_meta_key( '' ) => $options ];
			}

		}
		else {
			return [ $this->get_default() ];
		}

	}


	function get_meta_key( $prefix = '_tpl_' ) {

		if ( $this->is_subitem() ) {
			$option_name = $this->get_parent()->get_name();
		}
		else {
			$option_name = $this->get_name();
		}

		return $prefix . $option_name;

	}


	function get_value() {

		if ( $this->is_repeater() ) {

			$option = $this->get_option();
			$return_values = [];
			$instance = 0;

			if ( is_array( $option ) ) {
				foreach ( $option as $saved_value ) {
					$this->path[1] = $instance;
					$return_values[] = $this->format_option( $saved_value );
					$instance++;
				}
			}

			return $return_values;

		}

		else {
			return $this->format_option( $this->get_single_option_by_path() );
		}

	}


	function value() {

		if ( $this->is_repeater() ) {

			$values = $this->get_value();

			if ( is_array( $values ) ) { ?>
				<ul>
					<?php foreach ( $values as $value ) { ?>
						<li><?php echo $value; ?></li>
					<?php } ?>
				</ul>
			<?php }

		}

		else {
			echo $this->get_value();
		}

	}


	function format_option( $value ) {

		return $this->prefix . $value . $this->suffix;

	}


}
