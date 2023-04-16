<?php // Post type management class



class TPL_Post_Type {


	protected $post_type;


	function __construct( $post_type ) {

		$this->post_type = $post_type;
		$this->setup_hooks();

	}


	function setup_hooks() {

		add_action( 'add_meta_boxes', [ $this, 'setup_metaboxes' ] );
		add_action( 'pre_post_update', [ $this, 'save_metabox_fields' ] );
		add_action( 'admin_footer', [ $this, 'build_repeater_bank' ] );

	}


	function setup_metaboxes() {

		$sections = $this->get_sections();

		foreach ( $sections as $section ) {

			add_meta_box(
				$section->get_name(),
				$section->get_title(),
				[ $section, 'render_metabox_fields' ],
				$this->get_post_type()
			);

		}

	}


	function get_post_type() {

		return $this->post_type;

	}


	function save_metabox_fields( $post_id ) {

		if ( !$this->is_safe_to_save_metabox( $post_id ) ) {
			return;
		}

		$sections = $this->get_sections();

		foreach ( $sections as $section ) {
			$options = $section->get_options();
			foreach ( $options as $option ) {
				$option->set_post( $post_id );
				$option->save_post_meta();
			}
		}

	}


	function is_safe_to_save_metabox( $post_id ) {

		if ( !isset( $_POST["tpl_metabox_nonce"] ) ) {
			return false;
		}

		if ( !wp_verify_nonce( $_POST["tpl_metabox_nonce"], 'tpl_metabox' ) ) {
			return false;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return false;
		}

		if ( 'page' == $_POST["post_type"] ) {
			if ( !current_user_can( 'edit_page', $post_id ) ) {
				return false;
			}
		}
		else {
			if ( !current_user_can( 'edit_post', $post_id ) ) {
				return false;
			}
		}

		return true;

	}


	function build_repeater_bank() {
		global $post;

		if ( $this->get_post_type() == get_post_type( $post ) ) {

			$options = $this->get_options();
			include TPL_ROOT_DIR . 'inc/templates/common/repeater-bank.php';

		}

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
