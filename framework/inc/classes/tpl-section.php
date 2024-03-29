<?php // Section management class



class TPL_Section {


	protected $name			= '';
	protected $tab			= '';
	protected $title		= '';
	protected $description	= '';
	protected $post_types	= [];
	protected $priority		= 10;


	function __construct( $args ) {

		$this->args = $args;
		$this->initialize();
		$this->maybe_register_post_types();

	}


	function initialize() {

		if ( isset( $this->args["name"] ) ) {
			$this->set_name( $this->args["name"] );
		}

		if ( isset( $this->args["tab"] ) ) {
			$this->set_tab( $this->args["tab"] );
		}
		else if ( $this->args["title"] ) {
			$this->set_tab( $this->args["title"] );
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

		if ( isset( $this->args["post_type"] ) ) {
			$this->set_post_type( $this->args["post_type"] );
		}

		if ( isset( $this->args["priority"] ) ) {
			$this->set_priority( $this->args["priority"] );
		}

	}


	function get_name() {

		return $this->name;

	}


	function set_name( $name ) {

		$this->name = $name;

	}


	function get_tab() {

		return $this->tab;

	}


	function set_tab( $tab_name ) {

		$this->tab = $tab_name;

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


	function maybe_register_post_types() {

		if ( $this->is_primary() ) {
			return;
		}

		$post_types = $this->get_post_types();

		foreach ( $post_types as $post_type ) {

			if ( !isset( TPL_FW()->registered_post_types[$post_type] ) && $this->has_post_type( $post_type ) ) {
				TPL_FW()->register_post_type( $post_type );
			}

		}

	}


	function get_post_types() {

		if ( isset( $this->post_types ) ) {
			return $this->post_types;
		}

		return [];

	}


	function has_post_type( $post_type ) {

		if ( in_array( $post_type, $this->post_types ) ) {
			return true;
		}

		return false;

	}


	function set_post_type( $post_types ) {

		if ( is_array( $post_types ) ) {
			$this->post_types = $post_types;
		}
		else if ( is_string( $post_types ) ) {
			$this->post_types = [ $post_types ];
		}

	}


	function get_priority() {

		return $this->priority;

	}


	function set_priority( $priority ) {

		$this->priority = $priority;

	}


	// A section is primary when is on a WordPress Admin Settings page. Secondary if it's in a post edit metabox
	function is_primary() {

		if ( !empty( $this->get_post_types() ) ) {

			foreach ( TPL_FW()->registered_settings_pages as $key => $settings_page ) {

				if ( $settings_page->get_post_type() && $this->has_post_type( $settings_page->get_post_type() ) ) {
					return true;
				}

			}

		}

		return false;

	}


	function setup_fields( $container = '' ) {

		if ( $this->is_primary() ) {
			$this->setup_primary_fields( $container );
		}

	}


	function setup_primary_fields( $settings_page ) {

		if ( is_a( $settings_page, 'TPL_Settings_Page' ) ) {

			foreach ( $this->get_options() as $option ) {
				$option->add_settings_field( $settings_page );
			}

		}

	}


	function render_primary_fields( $settings_page ) {
	    global $wp_settings_fields;

		if ( is_a( $settings_page, 'TPL_Settings_Page' ) ) {
			$settings_page_name = $settings_page->get_name();
		}
		else {
			return;
		}

	    if ( !isset( $wp_settings_fields[$settings_page_name][$this->get_name()] ) || !$this->is_primary() ) {
	        return;
	    }

		$fields = $this->arrange_primary_fields( (array) $wp_settings_fields[$settings_page_name][$this->get_name()] );

		foreach ( $fields as $field ) {

		    $option = TPL_FW()->get_option( $field["id"] );

			$class = 'tpl-primary-form-row';
	        if ( !empty( $field["args"]["class"] ) ) {
	            $class .= ' ' . esc_attr( $field["args"]["class"] );
	        }

			include TPL_ROOT_DIR . 'inc/templates/settings-page/field-container.php';

	    }

	}


	function arrange_primary_fields( $fields ) {

		usort( $fields, function( $a, $b ) {

			$a_option = TPL_FW()->get_option( $a["id"] );
			$b_option = TPL_FW()->get_option( $b["id"] );

			return $a_option->get_priority() <=> $b_option->get_priority();

		} );

		return $fields;

	}


	function render_metabox_fields( $post ) {

		wp_nonce_field( 'tpl_metabox', 'tpl_metabox_nonce' );
		echo tpl_kses( $this->get_description() );

		$options = $this->arrange_metabox_options( $this->get_options() );

		foreach ( $options as $option ) {
			$option->set_post( $post );
			$option->metabox_row();
		}

	}


	function arrange_metabox_options( $options ) {

		usort( $options, function( $a, $b ) {
			return $a->get_priority() <=> $b->get_priority();
		} );

		return $options;

	}


	function get_options() {

	    return TPL_FW()->get_options_by_section( $this->get_name() );

	}


}
