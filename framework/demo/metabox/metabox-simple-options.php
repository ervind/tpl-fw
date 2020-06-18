<?php


$tpl_option_args = [
	"name"			=> 'demo_post_static_normal',
	"title"			=> __( 'Test Static Field', 'tpl' ),
	"description"	=> __( 'Description for Test Static Field', 'tpl' ),
	"section"		=> 'simple_post_demos',
	"type"			=> 'static',
	"default"		=> __( 'Test static default value', 'tpl' ),
];
$tpl_fw->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_post_text_normal',
	"title"			=> __( 'Test text Field', 'tpl' ),
	"description"	=> __( 'Description for Test text Field', 'tpl' ),
	"section"		=> 'simple_post_demos',
	"type"			=> 'text',
	"default"		=> __( 'Test text default value', 'tpl' ),
];
$tpl_fw->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_post_textarea_normal',
	"title"			=> __( 'Test textarea Field', 'tpl' ),
	"description"	=> __( 'Description for Test textarea Field', 'tpl' ),
	"section"		=> 'simple_post_demos',
	"type"			=> 'textarea',
	"default"		=> __( 'Test textarea default value', 'tpl' ),
];
$tpl_fw->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_post_tinymce_normal',
	"title"			=> __( 'Test tinymce Field', 'tpl' ),
	"description"	=> __( 'Description for Test tinymce Field', 'tpl' ),
	"section"		=> 'simple_post_demos',
	"type"			=> 'tinymce',
	"default"		=> __( 'Test tinymce default value', 'tpl' ),
];
$tpl_fw->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_post_number_normal',
	"title"			=> __( 'Test number Field', 'tpl' ),
	"description"	=> __( 'Description for Test number Field', 'tpl' ),
	"section"		=> 'simple_post_demos',
	"type"			=> 'number',
	"default"		=> 4,
	"min"			=> 0,
	"max"			=> 10,
	"step"			=> 2,
];
$tpl_fw->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_post_select_normal',
	"title"			=> __( 'Test select Field', 'tpl' ),
	"description"	=> __( 'Description for Test select Field', 'tpl' ),
	"section"		=> 'simple_post_demos',
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
];
$tpl_fw->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_post_user_normal',
	"title"			=> __( 'Test user Field', 'tpl' ),
	"description"	=> __( 'Description for Test user Field', 'tpl' ),
	"section"		=> 'simple_post_demos',
	"type"			=> 'user',
	"placeholder"	=> __( 'Choose a User', 'tpl' ),
];
$tpl_fw->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_post_post_normal',
	"title"			=> __( 'Test post Field', 'tpl' ),
	"description"	=> __( 'Description for Test post Field', 'tpl' ),
	"section"		=> 'simple_post_demos',
	"type"			=> 'post',
	"placeholder"	=> __( 'Choose a Post', 'tpl' ),
	"post_type"		=> 'page',
];
$tpl_fw->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_post_font_awesome_normal',
	"title"			=> __( 'Test Font Awesome Field', 'tpl' ),
	"description"	=> __( 'Description for Test Font Awesome Field', 'tpl' ),
	"section"		=> 'simple_post_demos',
	"type"			=> 'font_awesome',
	"placeholder"	=> __( 'Choose a font icon', 'tpl' ),
	"default"		=> 'facebook'
];
$tpl_fw->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_post_boolean_normal',
	"title"			=> __( 'Test boolean Field', 'tpl' ),
	"description"	=> __( 'Description for Test boolean Field', 'tpl' ),
	"section"		=> 'simple_post_demos',
	"type"			=> 'boolean',
	"default"		=> true,
];
$tpl_fw->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_post_color_normal',
	"title"			=> __( 'Test color Field', 'tpl' ),
	"description"	=> __( 'Description for Test color Field', 'tpl' ),
	"section"		=> 'simple_post_demos',
	"type"			=> 'color',
];
$tpl_fw->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_post_image_normal',
	"title"			=> __( 'Test image Field', 'tpl' ),
	"description"	=> __( 'Description for Test image Field', 'tpl' ),
	"section"		=> 'simple_post_demos',
	"type"			=> 'image',
];
$tpl_fw->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_post_date_normal',
	"title"			=> __( 'Test date Field', 'tpl' ),
	"description"	=> __( 'Description for Test date Field', 'tpl' ),
	"section"		=> 'simple_post_demos',
	"type"			=> 'date',
];
$tpl_fw->register_option( $tpl_option_args );
