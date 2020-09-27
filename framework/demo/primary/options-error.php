<?php // Testing error handling


$tpl_option_args = [
	"title"			=> __( 'No option name error', 'tpl' ),
	"section"		=> 'simple_demos',
	"type"			=> 'text',
];
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_text_normal',
	"title"			=> __( 'Option name already in use', 'tpl' ),
	"section"		=> 'simple_demos',
	"type"			=> 'color',
];
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'no_section_error',
	"title"			=> __( 'No section error', 'tpl' ),
	"type"			=> 'text',
];
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'invalid_section_error',
	"title"			=> __( 'Invalid section error', 'tpl' ),
	"section"		=> 'invalid_section',
	"type"			=> 'text',
];
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'no_type_error',
	"title"			=> __( 'No option type error', 'tpl' ),
	"section"		=> 'simple_demos',
];
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'invalid_type_error',
	"title"			=> __( 'Invalid option type error', 'tpl' ),
	"section"		=> 'simple_demos',
	"type"			=> 'c783fh3fb38yvbd3',
];
TPL_FW()->register_option( $tpl_option_args );
