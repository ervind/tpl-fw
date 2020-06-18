<?php



class TPL_Image extends TPL_Option {

	public	$size		= 'medium';
	public	$css_class	= '';
	public	$alt		= '';


	function __construct( $args ) {
		global $tpl_image_added;

 		parent::__construct( $args );

		if ( $tpl_image_added !== true ) {
			add_filter( 'tpl_admin_js_strings', [ $this, 'admin_js_strings' ] );
			add_action( 'admin_print_scripts', 'wp_enqueue_media' );
			$tpl_image_added = true;
		}

	}


	function initialize() {

		parent::initialize();

		if ( isset( $this->args["css_class"] ) ) {
			$this->set_css_class( $this->args["css_class"] );
		}

		if ( isset( $this->args["alt"] ) ) {
			$this->set_alt( $this->args["alt"] );
		}

		if ( isset( $this->args["size"] ) ) {
			$this->set_size( $this->args["size"] );
		}

	}


	function get_admin_classes() {

		$admin_classes = parent::get_admin_classes();

		if ( !in_array( 'tpl-uploader', $admin_classes ) ) {
			$admin_classes[] = 'tpl-uploader';
		}

		return $admin_classes;

	}


	function set_css_class( $css_class ) {

		$this->css_class = $css_class;

	}


	function get_css_class() {

		return $this->css_class;

	}


	function set_alt( $alt ) {

		$this->alt = $alt;

	}


	function get_alt() {

		return $this->alt;

	}


	function set_size( $size ) {

		$this->size = $size;

	}


	function get_size() {

		return $this->size;

	}


	function form_field_content() {

		$option = $this;
		include TPL_ROOT_DIR . 'inc/templates/option/data-types/image-field-content.php';

	}


	function format_option( $value ) {

		$atts = [];

		if ( $this->get_css_class() != '' ) {
			$atts["class"] = $this->get_css_class();
		}
		if ( $this->get_alt() != '' ) {
			$atts["alt"] = $this->get_alt();
		}
		if ( $this->get_title() != '' ) {
			$atts["title"] = $this->get_title();
		}

		return wp_get_attachment_image( intval( $value ), $this->get_size(), false, $atts );

	}


	function form_default_value() {

		return '';

	}


	function get_image_url() {

		return wp_get_attachment_image_src( intval( $this->get_option() ), $this->get_size() );

	}


	public function admin_js_strings( $strings ) {

		$strings = array_merge( $strings, [
			"uploader_title"		=> __( 'Choose Image', 'tpl' ),
			"uploader_button"		=> __( 'Choose Image', 'tpl' ),
			"tpl-dt-image_preview-template"	=> '<img src="[tpl-preview-0]" class="tpl-image-preview">',
		] );

		return $strings;

	}


}
