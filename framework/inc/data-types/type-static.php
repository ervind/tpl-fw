<?php


class TPL_Static extends TPL_Option {


	function form_field_content() {

		echo $this->prefix . $this->get_option() . $this->suffix;

	}


	function get_option( $post_id = 0 ) {

		return $this->get_default();

	}


	function form_field_default() {

		return '';

	}


	function set_repeater( $repeat ) {

		return false;

	}


}
