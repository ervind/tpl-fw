<?php


$tpl_option_args = [
	"name"			=> 'demo_static_normal',
	"title"			=> __( 'Test Static Field', 'tpl' ),
	"description"	=> __( 'Description for Test Static Field', 'tpl' ),
	"section"		=> 'simple_demos',
	"type"			=> 'static',
	"default"		=> __( 'Test static default value', 'tpl' ),
];
$tpl_fw->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_text_normal',
	"title"			=> __( 'Test text Field', 'tpl' ),
	"description"	=> __( 'Description for Test text Field', 'tpl' ),
	"section"		=> 'simple_demos',
	"type"			=> 'text',
	"default"		=> __( 'Test text default value', 'tpl' ),
	"prefix"		=> __( 'DEMO-PREFIX: ', 'tpl' ),
];
$tpl_fw->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_textarea_normal',
	"title"			=> __( 'Test textarea Field', 'tpl' ),
	"description"	=> __( 'Description for Test textarea Field', 'tpl' ),
	"section"		=> 'simple_demos',
	"type"			=> 'textarea',
	"default"		=> __( 'Test textarea default value', 'tpl' ),
	"suffix"		=> 'x',
];
$tpl_fw->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_tinymce_normal',
	"title"			=> __( 'Test TinyMCE Field', 'tpl' ),
	"description"	=> __( 'Description for Test tinymce Field', 'tpl' ),
	"section"		=> 'simple_demos',
	"type"			=> 'tinymce',
	"default"		=> __( 'Test tinymce default value', 'tpl' ),
	"suffix"		=> 'x',
];
$tpl_fw->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_number_normal',
	"title"			=> __( 'Test number Field', 'tpl' ),
	"description"	=> __( 'Description for Test number Field', 'tpl' ),
	"section"		=> 'simple_demos',
	"type"			=> 'number',
	"default"		=> 4,
	"min"			=> 0,
	"max"			=> 10,
	"step"			=> 2,
	"suffix"		=> 'i',
];
$tpl_fw->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_select_normal',
	"title"			=> __( 'Test select Field', 'tpl' ),
	"description"	=> __( 'Description for Test select Field', 'tpl' ),
	"section"		=> 'simple_demos',
	"type"			=> 'select',
	"values"		=> [
		"first"			=> __( 'First Option', 'tpl' ),
		"second"		=> __( 'Second Option', 'tpl' ),
		"third"			=> __( 'Third Option', 'tpl' ),
		"group"			=> [
			"fourth"		=> __( 'Fourth Option', 'tpl' ),
			"fifth"			=> __( 'Fifth Option', 'tpl' ),
		],
	],
	"placeholder"	=> __( 'Choose Something', 'tpl' ),
	"prefix"		=> __( 'DEMO-PREFIX: ', 'tpl' ),
	"suffix"		=> 'x',
];
$tpl_fw->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_user_normal',
	"title"			=> __( 'Test user Field', 'tpl' ),
	"description"	=> __( 'Description for Test user Field', 'tpl' ),
	"section"		=> 'simple_demos',
	"type"			=> 'user',
	"placeholder"	=> __( 'Choose a User', 'tpl' ),
];
$tpl_fw->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_post_normal',
	"title"			=> __( 'Test post Field', 'tpl' ),
	"description"	=> __( 'Description for Test post Field', 'tpl' ),
	"section"		=> 'simple_demos',
	"type"			=> 'post',
	"placeholder"	=> __( 'Choose a Post', 'tpl' ),
	"post_type"		=> 'page',
];
$tpl_fw->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_font_awesome_normal',
	"title"			=> __( 'Test Font Awesome Field', 'tpl' ),
	"description"	=> __( 'Description for Test Font Awesome Field', 'tpl' ),
	"section"		=> 'simple_demos',
	"type"			=> 'font_awesome',
	"placeholder"	=> __( 'Choose a font icon', 'tpl' ),
	"default"		=> 'facebook'
];
$tpl_fw->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_boolean_normal',
	"title"			=> __( 'Test boolean Field', 'tpl' ),
	"description"	=> __( 'Description for Test boolean Field', 'tpl' ),
	"section"		=> 'simple_demos',
	"type"			=> 'boolean',
	"default"		=> false,
];
$tpl_fw->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_color_normal',
	"title"			=> __( 'Test color Field', 'tpl' ),
	"description"	=> __( 'Description for Test color Field', 'tpl' ),
	"section"		=> 'simple_demos',
	"type"			=> 'color',
];
$tpl_fw->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_image_normal',
	"title"			=> __( 'Test image Field', 'tpl' ),
	"description"	=> __( 'Description for Test image Field', 'tpl' ),
	"section"		=> 'simple_demos',
	"type"			=> 'image',
];
$tpl_fw->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_date_normal',
	"title"			=> __( 'Test date Field', 'tpl' ),
	"description"	=> __( 'Description for Test date Field', 'tpl' ),
	"section"		=> 'simple_demos',
	"type"			=> 'date',
];
$tpl_fw->register_option( $tpl_option_args );