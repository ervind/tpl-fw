<?php // Main Framework class



class TPL_Framework {


	public $registered_settings_pages = [];
	public $registered_post_types = [];
	public $registered_sections = [];
	public $registered_options = [];


	function __construct() {

		$this->load_data_types();
		$this->setup_hooks();
		$this->load_textdomain();

	}


	function setup_hooks() {

		add_action( 'admin_menu', [ $this, 'setup_settings_pages' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'load_admin_scripts' ], 20 );

	}


	function load_data_types() {

		foreach ( $this->get_data_type_files() as $file ) {
			require_once $file;
		}

	}


	function get_data_type_names() {

		$data_types = [
			"static"	=> __( 'Static', 'tpl' ),
			"text"		=> __( 'Text', 'tpl' ),
			"textarea"	=> __( 'Text Area', 'tpl' ),
			"tinymce"	=> __( 'TinyMCE', 'tpl' ),
			"color"		=> __( 'Color', 'tpl' ),
			"image"		=> __( 'Image', 'tpl' ),
			"number"	=> __( 'Number', 'tpl' ),
			"boolean"	=> __( 'Boolean', 'tpl' ),
			"select"	=> __( 'Select', 'tpl' ),
			"font_awesome"	=> __( 'Font Awesome', 'tpl' ),
			"post"		=> __( 'Post', 'tpl' ),
			"user"		=> __( 'User', 'tpl' ),
			"date"		=> __( 'Date', 'tpl' ),
			"combined"	=> __( 'Combined', 'tpl' ),
			"icon"		=> __( 'Icon', 'tpl' ),
		];

		return apply_filters( 'tpl_data_type_names', $data_types );

	}


	function get_data_type_files() {

		$files = [];

		foreach ( $this->get_data_type_names() as $data_type_slug => $data_type_name ) {
			$files[] = TPL_ROOT_DIR . 'inc/data-types/type-' . $data_type_slug . '.php';
		}

		return apply_filters( 'tpl_data_type_files', $files );

	}


	function generate_data_type_class_name_from_slug( $data_type_slug ) {

		return 'TPL_' . ucfirst( $data_type_slug );

	}


	function is_data_type_registered( $data_type_slug ) {

		$class_name = $this->generate_data_type_class_name_from_slug( $data_type_slug );

		if ( class_exists( $class_name ) && in_array( 'TPL_Option', class_parents( $class_name ) ) ) {
			return true;
		}

		return false;

	}


	function load_textdomain() {

		$mo_filename = TPL_ROOT_DIR . 'languages/tpl-' . get_locale() . '.mo';
		if ( is_admin() && file_exists( $mo_filename ) ) {
			load_textdomain( 'tpl', $mo_filename );
		}

	}


	function setup_settings_pages() {

		foreach ( $this->get_settings_pages() as $settings_page ) {

			$settings_page->create_admin_menu_item();
			$settings_page->setup_sections();

			if ( get_option( $settings_page->get_name() ) == false && !empty( $settings_page->get_options() ) ) {
				add_option( $settings_page->get_name() );
			}

			register_setting(
				$settings_page->get_name(),
				$settings_page->get_name()
			);

		}

	}


	function load_admin_scripts() {

		// Scripts
		wp_enqueue_script( 'jquery-ui-tabs', '', [ 'jquery', 'jquery-ui-core' ] );
		wp_enqueue_script( 'tpl-admin-scripts', TPL_ROOT_URL . 'assets/admin-scripts.min.js', [ 'jquery', 'jquery-ui-tabs' ], TPL_VERSION );

		// Variables to be used in scripts
		wp_localize_script( 'tpl-admin-scripts', 'TPL_Admin', array_merge( apply_filters( 'tpl_admin_js_strings', [] ), $this->admin_vars_to_js() ) );

		// Styles
		self::load_font_awesome();
		wp_enqueue_style( 'tpl-admin-style', TPL_ROOT_URL . 'assets/admin.min.css', [ 'font-awesome' ], TPL_VERSION );

	}


	function admin_vars_to_js() {

		$to_js = [];
		$options = $this->get_options();

		if ( $options && is_admin() ) {

			foreach ( $options as $option ) {

				if ( $option->get_conditions() ) {

					foreach ( $option->get_conditions() as $key => $value ) {

						$to_js["Conditions"][$key] = $value;

					}

				}

			}

		}

		return $to_js;

	}


	static function load_font_awesome() {

		wp_enqueue_style( 'font-awesome', TPL_ROOT_URL . 'lib/font-awesome/fonts/fontawesome.min.css', [], TPL_VERSION );

		$fa_fonts_css = '
			@font-face{font-family:"Font Awesome 5 Free"; font-style:normal; font-weight:900; src:url(' . TPL_ROOT_URL . 'lib/font-awesome/fonts/fa-solid-900.woff) format("woff")} .fa,.fas{font-family:"Font Awesome 5 Free"; font-weight:900}
			@font-face{font-family:"Font Awesome 5 Free"; font-style:normal; font-weight:400; src:url(' . TPL_ROOT_URL . 'lib/font-awesome/fonts/fa-regular-400.woff) format("woff")} .far{font-family:"Font Awesome 5 Free"; font-weight:400}
			@font-face{font-family:"Font Awesome 5 Brands"; font-style:normal; font-weight:normal; src:url(' . TPL_ROOT_URL . 'lib/font-awesome/fonts/fa-brands-400.woff) format("woff")} .fab{font-family:"Font Awesome 5 Brands"}
		';
	    wp_add_inline_style( 'font-awesome', $fa_fonts_css );

	}


	function register_settings_page( $settings_page_args ) {

		$settings_page = new TPL_Settings_Page( $settings_page_args );
		$this->registered_settings_pages[$settings_page->get_name()] = $settings_page;

	}


	function get_settings_pages( $post_type = 'all' ) {

		if ( $post_type == 'all' ) {
			return $this->registered_settings_pages;
		}

		$settings_pages = [];

		if ( !empty( $this->registered_settings_pages ) ) {
			foreach ( $this->registered_settings_pages as $key => $settings_page ) {
				if ( $settings_page->get_post_type() == $post_type ) {
					$settings_pages[$key] = $settings_page;
				}
			}
		}

		return $settings_pages;

	}


	function get_settings_page( $settings_page_name ) {

		if ( isset( $this->registered_settings_pages[$settings_page_name] ) ) {
			return $this->registered_settings_pages[$settings_page_name];
		}

		return false;

	}


	function register_post_type( $post_type ) {

		$post_type_obj = new TPL_Post_Type( $post_type );
		$this->registered_post_types[$post_type] = $post_type_obj;

	}


	function register_section( $section_args ) {

		$check = $this->pre_register_section_error_check( $section_args );

		if ( !$check ) {
			return;
		}

		$section = new TPL_Section( $section_args );
		$this->registered_sections[$section->get_name()] = $section;

	}


	function pre_register_section_error_check( $section_args ) {

		$error = false;

		if ( !isset( $section_args["name"] ) || $section_args["name"] == '' ) {
			$error = new TPL_Error( [
				"message"	=> sprintf( __( 'Sections can\'t be registered without a section name. Section details: <br> %s', 'tpl' ), wpautop( print_r( $section_args, true ) ) ),
			] );
		}
		else if ( !isset( $section_args["title"] ) || $section_args["title"] == '' ) {
			$error = new TPL_Error( [
				"message"	=> sprintf( __( 'Sections must have a title. No title was defined for section "%s".', 'tpl' ), esc_html( $section_args["title"] ) ),
			] );
		}

		if ( is_a( $error, 'TPL_Error' ) ) {
		   $error->show_message();
		   return false;
	   }

	   return true;

	}


	function get_sections() {

		return $this->registered_sections;

	}


	function get_sections_by_post_type( $post_type ) {

		$output_sections = [];

		foreach ( $this->registered_sections as $section ) {

			if ( $section->has_post_type( $post_type ) ) {
				$output_sections[] = $section;
			}

		}

		return $output_sections;

	}


	function get_section( $section_name ) {

		if ( isset( $this->registered_sections[$section_name] ) ) {
			return $this->registered_sections[$section_name];
		}

		return false;

	}


	function is_section_registered( $section_name ) {

		if ( array_key_exists ( $section_name, $this->registered_sections ) ) {
			return true;
		}

		return false;

	}


	function register_option( $option_args ) {

		$check = $this->pre_register_option_error_check( $option_args );

		if ( !$check ) {
			return;
		}

		$class_name = $this->generate_data_type_class_name_from_slug( $option_args["type"] );
		$option = new $class_name( $option_args );

		if ( !$option->is_subitem() && $this->is_option_registered( $option->get_name() ) ) {
			$error = new TPL_Error( [
				"message"	=> sprintf( __( 'Duplicate option name "%1$s". Options must have unique names.', 'tpl' ), esc_html( $option_args["name"] ) )
			] );
			$error->show_message();
			return;
		}

		$this->registered_options[$option->get_name()] = $option;

	}


	function pre_register_option_error_check( $option_args ) {

		$error = false;

		if ( !isset( $option_args["name"] ) || $option_args["name"] == '' ) {
			$error = new TPL_Error( [
				"message"	=> sprintf( __( 'Options can\'t be registered without an option name. Option details: <br> %s', 'tpl' ), wpautop( print_r( $option_args, true ) ) ),
			] );
		}
		else if ( !isset( $option_args["section"] ) || $option_args["section"] == '' ) {
			$error = new TPL_Error( [
				"message"	=> sprintf( __( 'No section name was specified for option "%s". Option isn\'t registered.', 'tpl' ), esc_html( $option_args["name"] ) ),
			] );
		}
		else if ( isset( $option_args["section"] ) && !$this->is_section_registered( $option_args["section"] ) ) {
			$error = new TPL_Error( [
				"message"	=> sprintf( __( 'Invalid section name was specified for option "%1$s". Please make sure that you have a section registered with the "%2$s" section name.', 'tpl' ), esc_html( $option_args["name"] ), esc_html( $option_args["section"] ) ),
			] );
		}
		else if ( !isset( $option_args["type"] ) || $option_args["type"] == '' ) {
			$error = new TPL_Error( [
				"message"	=> sprintf( __( 'No option type was specified for option "%s". Option isn\'t registered.', 'tpl' ), esc_html( $option_args["name"] ) ),
			] );
		}
		else if ( isset( $option_args["type"] ) && !$this->is_data_type_registered( $option_args["type"] ) ) {
			$error = new TPL_Error( [
				"message"	=> sprintf( __( 'Invalid data type (%2$s) was specified for option "%1$s". Please make sure that you use one of the data types listed in the <a href="%3$s" target="_blank">documentation</a>.', 'tpl' ), esc_html( $option_args["name"] ), $option_args["type"], 'https://github.com/ervind/tpl-fw' ),
			] );
		}

 		if ( is_a( $error, 'TPL_Error' ) ) {
			$error->show_message();
			return false;
		}

		return true;

	}


	function get_options() {

		return $this->registered_options;

	}


	function get_options_by_section( $section_name ) {

		$options_by_section = [];

		foreach ( $this->get_options() as $option_name => $option ) {
			if ( $option->get_section()->get_name() == $section_name ) {
				$options_by_section[] = $option;
			}
		}

		return $options_by_section;

	}


	function get_option( $option_name ) {

		if ( isset( $this->registered_options[$option_name] ) ) {
			return $this->registered_options[$option_name];
		}

		return false;

	}


	function is_option_registered( $option_name ) {

		if ( array_key_exists( $option_name, $this->registered_options ) ) {
			return true;
		}

		return false;

	}


}
