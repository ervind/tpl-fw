<?php



class TPL_Post extends TPL_Select {


	function initialize() {

		parent::initialize();

		$this->set_selectable_values( [] );
		add_action( 'wp_ajax_tpl_create_post', [ $this, 'ajax_create_post' ] );

	}


	function set_selectable_values( $values ) {

		$query_args = [
			"orderby"	=> 'ID',
			"order"		=> 'ASC',
		];

		$query_args["post_type"] = $this->get_post_type();

		if ( isset( $this->args["max"] ) ) {
			$query_args["posts_per_page"] = $this->args["max"];
		}
		else {
			$query_args["posts_per_page"] = -1;
		}

		$posts = get_posts( $query_args );

		if ( $posts ) {
			foreach ( $posts as $post ) {
				$this->values[$post->ID] = '(' . $post->ID . ') ' . wp_strip_all_tags( get_the_title( $post->ID ) );
			}
		}

	}


	function get_post_type() {

		if ( isset( $this->args["post_type"] ) && post_type_exists( $this->args["post_type"] ) ) {
			return $this->args["post_type"];
		}
		else {
			return 'post';
		}

	}


	function form_field_content() {

		$option = $this;
		include TPL_ROOT_DIR . 'inc/templates/option/data-types/post-field-content.php';

	}


	function get_single_option_by_path() {

		$single_option = parent::get_single_option_by_path();

		if ( get_post_type( $single_option ) != $this->get_post_type() ) {
			return '';
		}

		return $single_option;

	}


	function get_admin_edit_url( $template = false ) {

		if ( $template == true ) {

			$post_type_object = get_post_type_object( $this->get_post_type() );
		    if ( !$post_type_object ) {
		        return;
		    }

		    if ( $post_type_object->_edit_link ) {
		        return admin_url( $post_type_object->_edit_link . '&action=edit' );
			}

		}

		return get_edit_post_link( $this->get_single_option_by_path() );

	}


	function get_admin_posts_url() {

		return admin_url( 'edit.php?post_type=' . $this->get_post_type() );

	}


	function ajax_create_post() {

		$result = [];
		$result["success"] = false;

		if ( isset( $_REQUEST["_wpnonce"] ) && wp_verify_nonce( $_REQUEST["_wpnonce"], 'tpl-ajax-nonce' )
			&& isset( $_REQUEST["option_name"] )
		) {

			global $tpl_fw;
			$option = $tpl_fw->get_option( $_REQUEST["option_name"] );

			if ( $option->has_template() ) {

				$new_post_id = wp_insert_post( [
					"post_type"		=> $option->get_post_type(),
					"post_content"	=> $option->get_template_content(),
					"post_title"	=> $option->get_template_title(),
					"post_status"	=> 'publish',
				] );

				if ( !is_wp_error( $new_post_id ) ) {
					$result["post_id"] = $new_post_id;
					$result["select_label"] = '(' . $new_post_id . ') ' . wp_strip_all_tags( $option->get_template_title() );
					$result["success"] = true;
				}

			}

		}

		$result = json_encode( $result );
	    echo $result;

		die();

	}


	function get_template_content() {

		if ( $this->has_template() ) {
			ob_start();
			include $this->args["template"]["file"];
			return ob_get_clean();
		}

	}


	function get_template_title() {

		if ( isset( $this->args["template"]["title"] ) ) {
			return $this->args["template"]["title"];
		}
		else {
			return $this->get_title();
		}

	}


	function has_template() {

		if ( !isset( $this->args["template"]["file"] ) || $this->args["template"]["file"] == '' || !file_exists( $this->args["template"]["file"] ) ) {
			return false;
		}

		return true;

	}


}
