<?php // Handling of TPL error messages



class TPL_Error {


	protected $message	= '';
	protected $global	= true;
	protected $type		= 'error';
	protected $entity	= 'TPL';
	protected $possible_types;


	function __construct( $args ) {

		$this->args = $args;

		$this->set_possible_types();
		$this->initialize();

	}


	function initialize() {

		if ( isset( $this->args["message"] ) ) {
			$this->set_message( $this->args["message"] );
		}

		if ( isset( $this->args["global"] ) ) {
			if ( $this->args["global"] === true ) {
				$this->set_as_global();
			}
			else if ( $this->args["global"] === false ) {
				$this->set_as_local();
			}
		}

		if ( isset( $this->args["type"] ) ) {
			$this->set_type( $this->args["type"] );
		}

		if ( isset( $this->args["entity"] ) ) {
			$this->set_entity( $this->args["entity"] );
		}

	}


	function get_message( $filtered = false ) {

		if ( $filtered ) {
			return tpl_kses( $this->message );
		}

		return $this->message;

	}


	function set_message( $message ) {

		$this->message = $message;

	}


	function is_global() {

		if ( $this->global == true ) {
			return true;
		}

		return false;

	}


	function set_as_global() {

		$this->global = true;

	}


	function set_as_local() {

		$this->global = false;

	}


	function set_possible_types() {

		$this->possible_types = apply_filters( 'tpl_possible_error_types', [
			"error"		=> __( 'error', 'tpl' ),
			"warning"	=> __( 'warning', 'tpl' ),
			"success"	=> __( 'OK', 'tpl' ),
			"info"		=> __( 'notification', 'tpl' ),
		] );

	}


	function get_possible_types() {

		return $this->possible_types;

	}


	function get_type() {

		return $this->type;

	}


	function get_type_title() {

		return $this->possible_types[$this->type];

	}


	function set_type( $type ) {

		if ( array_key_exists( $type, $this->get_possible_types() ) ) {
			$this->type = $type;
		}

	}


	function get_entity() {

		return $this->entity;

	}


	function set_entity( $entity ) {

		$this->entity = $entity;

	}


	function get_intro() {

		return sprintf( _x( '%1$s %2$s: ', 'Global error message intro text', 'tpl' ), $this->get_entity(), $this->get_type_title() );

	}


	function show_message() {

		if ( $this->is_global() ) {
			add_action( 'admin_notices', [ $this, 'show_global_message' ] );
		}
		else {
			$this->show_local_message();
		}

	}


	function show_global_message() {

		$tpl_error = $this;
		include TPL_ROOT_DIR . 'inc/templates/error-message/global-message.php';

	}


	function show_local_message() {

		$tpl_error = $this;
		include TPL_ROOT_DIR . 'inc/templates/error-message/local-message.php';

	}


}
