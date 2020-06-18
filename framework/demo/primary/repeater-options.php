<?php


$tpl_option_args = [
	"name"			=> 'demo_static_repeater',
	"title"			=> __( 'Test Static Repeater Field', 'tpl' ),
	"description"	=> __( 'Description for Test Static Repeater Field', 'tpl' ),
	"section"		=> 'repeater_demos',
	"type"			=> 'static',
	"default"		=> __( 'Test static default value', 'tpl' ),
	"repeat"		=> true,
];
$tpl_fw->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_text_repeater',
	"title"			=> __( 'Test text Repeater Field', 'tpl' ),
	"description"	=> __( 'Description for Test text Repeater Field', 'tpl' ),
	"section"		=> 'repeater_demos',
	"type"			=> 'text',
	"default"		=> __( 'Test text default value', 'tpl' ),
	"repeat"		=> true,
	"suffix"		=> ' good',
];
$tpl_fw->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_textarea_repeater',
	"title"			=> __( 'Test textarea Repeater Field', 'tpl' ),
	"description"	=> __( 'Description for Test textarea Repeater Field', 'tpl' ),
	"section"		=> 'repeater_demos',
	"type"			=> 'textarea',
	"default"		=> __( 'Test textarea default value', 'tpl' ),
	"repeat"		=> true,
];
$tpl_fw->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_tinymce_repeater',
	"title"			=> __( 'Test tinymce Repeater Field', 'tpl' ),
	"description"	=> __( 'Description for Test tinymce Repeater Field', 'tpl' ),
	"section"		=> 'repeater_demos',
	"type"			=> 'tinymce',
	"default"		=> __( 'Test tinymce default value', 'tpl' ),
	"repeat"		=> true,
	"repeat_button_title" => __( 'Add TinyMCE row', 'tpl' ),
];
$tpl_fw->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_number_repeater',
	"title"			=> __( 'Test number Repeater Field', 'tpl' ),
	"description"	=> __( 'Description for Test number Repeater Field', 'tpl' ),
	"section"		=> 'repeater_demos',
	"type"			=> 'number',
	"default"		=> 4,
	"min"			=> 0,
	"max"			=> 10,
	"step"			=> 2,
	"repeat"		=> true,
];
$tpl_fw->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_select_repeater',
	"title"			=> __( 'Test select Repeater Field', 'tpl' ),
	"description"	=> __( 'Description for Test select Repeater Field', 'tpl' ),
	"section"		=> 'repeater_demos',
	"type"			=> 'select',
	"values"		=> [
		"first"			=> __( 'First Option', 'tpl' ),
		"second"		=> __( 'Second Option', 'tpl' ),
		"third"			=> __( 'Third Option', 'tpl' ),
	],
	"default"		=> 'second',
	"repeat"		=> true,
];
$tpl_fw->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_user_repeater',
	"title"			=> __( 'Test user Repeater Field', 'tpl' ),
	"description"	=> __( 'Description for Test user Repeater Field', 'tpl' ),
	"section"		=> 'repeater_demos',
	"type"			=> 'user',
	"placeholder"	=> __( 'Choose a User', 'tpl' ),
	"repeat"		=> true,
];
$tpl_fw->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_post_repeater',
	"title"			=> __( 'Test post Repeater Field', 'tpl' ),
	"description"	=> __( 'Description for Test post Repeater Field', 'tpl' ),
	"section"		=> 'repeater_demos',
	"type"			=> 'post',
	"placeholder"	=> __( 'Choose a Post', 'tpl' ),
	"repeat"		=> true,
	"repeat_button_title" => __( 'Add Post', 'tpl' ),
];
$tpl_fw->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_font_awesome_repeater',
	"title"			=> __( 'Test Font Awesome Repeater Field', 'tpl' ),
	"description"	=> __( 'Description for Test Font Awesome Repeater Field', 'tpl' ),
	"section"		=> 'repeater_demos',
	"type"			=> 'font_awesome',
	"placeholder"	=> __( 'Choose a font icon', 'tpl' ),
	"repeat"		=> true,
	"default"		=> 'burn',
];
$tpl_fw->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_boolean_repeater',
	"title"			=> __( 'Test boolean Repeater Field', 'tpl' ),
	"description"	=> __( 'Description for Test boolean Repeater Field', 'tpl' ),
	"section"		=> 'repeater_demos',
	"type"			=> 'boolean',
	"repeat"		=> true,
];
$tpl_fw->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_color_repeater',
	"title"			=> __( 'Test color Repeater Field', 'tpl' ),
	"description"	=> __( 'Description for Test color Repeater Field', 'tpl' ),
	"section"		=> 'repeater_demos',
	"type"			=> 'color',
	"repeat"		=> true,
	"default"		=> '#880000',
];
$tpl_fw->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_image_repeater',
	"title"			=> __( 'Test image Repeater Field', 'tpl' ),
	"description"	=> __( 'Description for Test image Repeater Field', 'tpl' ),
	"section"		=> 'repeater_demos',
	"type"			=> 'image',
	"repeat"		=> true,
];
$tpl_fw->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_date_repeater',
	"title"			=> __( 'Test date Repeater Field', 'tpl' ),
	"description"	=> __( 'Description for Test date Repeater Field', 'tpl' ),
	"section"		=> 'repeater_demos',
	"type"			=> 'date',
	"repeat"		=> true,
	"default"		=> date( 'Y-m-d' ),
];
$tpl_fw->register_option( $tpl_option_args );
