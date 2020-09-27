<?php // Handles settings pages in admin



class TPL_Settings_Page {


	function __construct( $args ) {

		$this->args = $args;

		if ( isset( $_REQUEST["page"] ) && $_REQUEST["page"] == $this->get_menu_slug() ) {
			if ( isset( $_REQUEST["settings-updated"] ) && $_REQUEST["settings-updated"] == 'true' ) {
				$this->success_message();
			}
		}

	}


	function success_message() {

		$error = new TPL_Error( [
			"message"	=> __( 'Settings updated successfully', 'tpl' ),
			"type"		=> 'success',
			"entity"	=> '',
		] );

		$error->show_message();

	}


	function get( $prop ) {

		return $this->$prop;

	}


	function set( $prop, $value ) {

		$this->$prop = $value;

	}


	function get_name() {

		return $this->args["name"];

	}


	function get_title() {

		return $this->args["page_title"];

	}


	function get_menu_title() {

		return $this->args["menu_title"];

	}


	function get_menu_slug() {

		return $this->args["menu_slug"];

	}


	function get_capability() {

		return $this->args["capability"];

	}


	function get_content_function() {

		return $this->args["function"];

	}


	function get_post_type() {

		if ( isset( $this->args["post_type"] ) ) {
			return $this->args["post_type"];
		}

		return '';

	}


	function get_icon_url() {

		if ( isset( $this->args["icon_url"] ) ) {
			return $this->args["icon_url"];
		}

		return 'dashicons-admin-network';

	}


	function get_parent_slug() {

		if ( isset( $this->args["parent_slug"] ) ) {
			return $this->args["parent_slug"];
		}

		return '';

	}


	function get_menu_function() {

		if ( isset( $this->args["menu_func"] ) && $this->args["menu_func"] != '' ) {
			return $this->args["menu_func"];
		}
		else {
			return 'add_options_page';
		}

	}


	function create_admin_menu_item() {

	 	switch ( $this->get_menu_function() ) {
	 		case 'add_menu_page':
	 			$this->add_menu_page();
	 			break;

			case 'add_submenu_page':
	 			$this->add_submenu_page();
	 			break;

	 		default:
	 			$this->add_special_submenu_page();
	 			break;
	 	}

	}


	function add_menu_page() {

		add_menu_page(
			$this->get_title(),
			$this->get_menu_title(),
			$this->get_capability(),
			$this->get_menu_slug(),
			$this->get_content_function(),
			$this->get_icon_url()
		);

	}


	function add_submenu_page() {

		if ( !$this->get_parent_slug() ) {
			return;
		}

		add_submenu_page(
			$this->get_parent_slug(),
			$this->get_title(),
			$this->get_menu_title(),
			$this->get_capability(),
			$this->get_menu_slug(),
			$this->get_content_function()
		);

	}


	function add_special_submenu_page() {

		$menu_func = $this->get_menu_function();

		$menu_func(
			$this->get_title(),
			$this->get_menu_title(),
			$this->get_capability(),
			$this->get_menu_slug(),
			$this->get_content_function()
		);

	}


	function render_page() {

		$settings_page = $this;
		$sections = $this->get_sections();

		include TPL_ROOT_DIR . 'inc/templates/settings-page/settings-page.php';

		add_action( 'admin_footer', [ $this, 'build_repeater_bank' ] );

	}


	function render_sections() {

		$sections = $this->get_sections();
		$settings_page = $this;

		if ( $sections ) {
			foreach ( $sections as $section ) {
				if ( $section->is_primary() ) {
					include TPL_ROOT_DIR . 'inc/templates/settings-page/section.php';
				}
			}
		}

	}


	function setup_sections() {

		foreach ( $this->get_sections() as $section ) {

			if ( $section->is_primary() ) {

				add_settings_section(
					$section->get_name(),
					$section->get_title(),
					'',
					$this->get_name()
				);

				$section->setup_fields( $this );

			}

		}

	}


	function form_hidden_fields() {

		// settings_fields() is WP's function for outputting some closing hidden fields (e.g. nonces) into the settings field
		settings_fields( $this->get_name() );

	}


	function build_repeater_bank() {

		$options = $this->get_options();
		include TPL_ROOT_DIR . 'inc/templates/common/repeater-bank.php';

	}


	function get_sections() {

		return TPL_FW()->get_sections_by_post_type( $this->get_post_type() );

	}


	function get_options() {

		$sections = $this->get_sections();
		$options = [];

		foreach ( $sections as $section ) {
			$options = array_merge( $options, $section->get_options() );
		}

		return $options;

	}


}
