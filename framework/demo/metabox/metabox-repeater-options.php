<?php


$section_name = 'repeater_post_demos';


$tpl_option_args = [
	"name"			=> 'demo_post_static_repeater',
	"title"			=> __( 'Test Static Repeater Field', 'tpl' ),
	"description"	=> __( 'Description for Test Static Repeater Field', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'static',
	"default"		=> __( 'Test static default value', 'tpl' ),
	"repeat"		=> true,
];
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_post_text_repeater',
	"title"			=> __( 'Test text Repeater Field', 'tpl' ),
	"description"	=> __( 'Description for Test text Repeater Field', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'text',
	"default"		=> __( 'Test text default value', 'tpl' ),
	"repeat"		=> true,
];
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_post_textarea_repeater',
	"title"			=> __( 'Test textarea Repeater Field', 'tpl' ),
	"description"	=> __( 'Description for Test textarea Repeater Field', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'textarea',
	"default"		=> __( 'Test textarea default value', 'tpl' ),
	"repeat"		=> true,
];
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_post_tinymce_repeater',
	"title"			=> __( 'Test tinymce Repeater Field', 'tpl' ),
	"description"	=> __( 'Description for Test tinymce Repeater Field', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'tinymce',
	"default"		=> __( 'Test tinymce default value', 'tpl' ),
	"repeat"		=> true,
	"repeat_button_title" => __( 'Add TinyMCE row', 'tpl' ),
];
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_post_number_repeater',
	"title"			=> __( 'Test number Repeater Field', 'tpl' ),
	"description"	=> __( 'Description for Test number Repeater Field', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'number',
	"default"		=> 4,
	"min"			=> 0,
	"max"			=> 10,
	"step"			=> 2,
	"repeat"		=> true,
];
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_post_select_repeater',
	"title"			=> __( 'Test select Repeater Field', 'tpl' ),
	"description"	=> __( 'Description for Test select Repeater Field', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'select',
	"values"		=> [
		"first"			=> __( 'First Option', 'tpl' ),
		"second"		=> __( 'Second Option', 'tpl' ),
		"third"			=> __( 'Third Option', 'tpl' ),
	],
	"default"		=> 'second',
	"repeat"		=> true,
];
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_post_user_repeater',
	"title"			=> __( 'Test user Repeater Field', 'tpl' ),
	"description"	=> __( 'Description for Test user Repeater Field', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'user',
	"placeholder"	=> __( 'Choose a User', 'tpl' ),
	"repeat"		=> true,
];
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_post_post_repeater',
	"title"			=> __( 'Test post Repeater Field', 'tpl' ),
	"description"	=> __( 'Description for Test post Repeater Field', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'post',
	"placeholder"	=> __( 'Choose a Post', 'tpl' ),
	"repeat"		=> true,
	"repeat_button_title" => __( 'Add Post', 'tpl' ),
];
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_post_font_awesome_repeater',
	"title"			=> __( 'Test Font Awesome Repeater Field', 'tpl' ),
	"description"	=> __( 'Description for Test Font Awesome Repeater Field', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'font_awesome',
	"placeholder"	=> __( 'Choose a font icon', 'tpl' ),
	"repeat"		=> true,
	"default"		=> 'burn',
];
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_post_boolean_repeater',
	"title"			=> __( 'Test boolean Repeater Field', 'tpl' ),
	"description"	=> __( 'Description for Test boolean Repeater Field', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'boolean',
	"repeat"		=> true,
];
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_post_color_repeater',
	"title"			=> __( 'Test color Repeater Field', 'tpl' ),
	"description"	=> __( 'Description for Test color Repeater Field', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'color',
	"repeat"		=> true,
	"default"		=> '#880000',
];
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_post_image_repeater',
	"title"			=> __( 'Test image Repeater Field', 'tpl' ),
	"description"	=> __( 'Description for Test image Repeater Field', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'image',
	"repeat"		=> true,
];
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_post_date_repeater',
	"title"			=> __( 'Test date Repeater Field', 'tpl' ),
	"description"	=> __( 'Description for Test date Repeater Field', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'date',
	"repeat"		=> true,
	"default"		=> date( 'Y-m-d' ),
];
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_post_checkboxes_repeater',
	"title"			=> __( 'Test checkboxes repeater Field', 'tpl' ),
	"description"	=> __( 'Description for Test checkboxes repeater Field', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'checkboxes',
	"repeat"		=> true,
	"values"		=> [
		"first"			=> __( 'First Option', 'tpl' ),
		"second"		=> __( 'Second Option', 'tpl' ),
		"third"			=> __( 'Third Option', 'tpl' ),
		"fourth"		=> __( 'Fourth Option', 'tpl' ),
		"fifth"			=> __( 'Fifth Option', 'tpl' ),
	],
	"default"		=> [
		"first"			=> 1,
		"second"		=> 1,
	],
];
TPL_FW()->register_option( $tpl_option_args );
