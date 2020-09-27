<?php
/*
HELPER FUNCTIONS for TPL framework
Everything that's accessible outside classes (mostly to keep compatibility with older versions)
*/



// Gets the unformatted values from wpdb
function tpl_get_option( $name, $post_id = 0 ) {

	$option_object = tpl_get_option_object( $name, $post_id );
	$option = $option_object->get_option();

	if ( is_array( $option ) && !$option_object->is_repeater() ) {
		return $option[0];
	}

	return $option;

}



// Gets the formatted values of an option
function tpl_get_value( $name, $post_id = 0 ) {

	$option_object = tpl_get_option_object( $name, $post_id );
	$value = $option_object->get_option();

	if ( is_array( $value ) && !$option_object->is_repeater() ) {
		return $value[0];
	}

	return $value;

}



// Prints the values of an option
function tpl_value( $name, $post_id = 0 ) {

	$option_object = tpl_get_option_object( $name, $post_id );
	$option_object->value();

}



// Gets the full option object for more advanced use. Devs can reach the full spectrum of data type functions with this function.
function tpl_get_option_object( $name, $post_id = 0 ) {

	$option_object = TPL_FW()->get_option( $name );

	if ( $post_id ) {
		$option_object->set_post( $post_id );
	}

	return $option_object;

}



// DEPRECATED - Displays an error message in an alert box.
function tpl_error( $msg, $global = true, $class = "error", $entity = "TPL" ) {

	_doing_it_wrong( 'tpl_error', __( 'The tpl_error() function has been deprecated in favor of using the TPL_Error class (and its show_message() method).', 'tpl' ), NULL );

	$error = new TPL_Error( [
		"message"	=> $msg,
		"global"	=> $global,
		"type"		=> $class,
		"entity"	=> $entity,
	] );

	$error->show_message();

}



// Escape non-permitted tags from outputs. An extended version of wp_kses() with some pre-defined values
function tpl_kses( $string, $additional_allowed_html = [] ) {

	$allowed_html = apply_filters( 'tpl_kses_allowed_html', [

		'a'		=> [
			'href'	=> [],
			'title'	=> [],
			'class'	=> [],
			'target'=> [],
		],
		'img'	=> [
			'src'	=> [],
			'title'	=> [],
			'alt'	=> [],
			'class'	=> [],
		],
		'br'	=> [],
		'hr'	=> [],
		'em'	=> [
			'class'	=> [],
		],
		'strong'=> [
			'class'	=> [],
		],
		'i'		=> [
			'class'	=> [],
		],
		'b'		=> [
			'class'	=> [],
		],
		'div'	=> [
			'class'	=> [],
			'id'	=> [],
		],
		'h1'	=> [],
		'h2'	=> [],
		'h3'	=> [],
		'h4'	=> [],
		'h5'	=> [],
		'h6'	=> [],
		'p'		=> [
			'class'	=> [],
		],
		'span'	=> [
			'class'	=> [],
		],
		'ul'	=> [
			'class'	=> [],
		],
		'li'	=> [
			'class'	=> [],
		],
		'pre'	=> [],

	] );

	$allowed_html = array_merge( $allowed_html, $additional_allowed_html );

	return wp_kses( $string, $allowed_html );

}
