<?php


$section_name = 'simple_demos';


$tpl_option_args = [
	"name"			=> 'demo_static_normal',
	"title"			=> __( 'Test Static Field', 'tpl' ),
	"description"	=> __( 'Description for Test Static Field', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'static',
	"default"		=> __( 'Test static default value', 'tpl' ),
];
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_text_normal',
	"title"			=> __( 'Test text Field', 'tpl' ),
	"description"	=> __( 'Description for Test text Field', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'text',
	"default"		=> __( 'Test text default value', 'tpl' ),
	"prefix"		=> __( 'DEMO-PREFIX: ', 'tpl' ),
];
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_textarea_normal',
	"title"			=> __( 'Test textarea Field', 'tpl' ),
	"description"	=> __( 'Description for Test textarea Field', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'textarea',
	"default"		=> __( 'Test textarea default value', 'tpl' ),
	"suffix"		=> 'x',
];
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_tinymce_normal',
	"title"			=> __( 'Test TinyMCE Field', 'tpl' ),
	"description"	=> __( 'Description for Test tinymce Field', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'tinymce',
	"default"		=> __( 'Test tinymce default value', 'tpl' ),
	"suffix"		=> 'x',
];
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_number_normal',
	"title"			=> __( 'Test number Field', 'tpl' ),
	"description"	=> __( 'Description for Test number Field', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'number',
	"default"		=> 4,
	"min"			=> 0,
	"max"			=> 10,
	"step"			=> 2,
	"suffix"		=> 'i',
];
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_select_normal',
	"title"			=> __( 'Test select Field', 'tpl' ),
	"description"	=> __( 'Description for Test select Field', 'tpl' ),
	"section"		=> $section_name,
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
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_user_normal',
	"title"			=> __( 'Test user Field', 'tpl' ),
	"description"	=> __( 'Description for Test user Field', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'user',
	"placeholder"	=> __( 'Choose a User', 'tpl' ),
];
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_post_normal',
	"title"			=> __( 'Test post Field', 'tpl' ),
	"description"	=> __( 'Description for Test post Field', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'post',
	"placeholder"	=> __( 'Choose a Post', 'tpl' ),
	"post_type"		=> 'page',
];
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_font_awesome_normal',
	"title"			=> __( 'Test Font Awesome Field', 'tpl' ),
	"description"	=> __( 'Description for Test Font Awesome Field', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'font_awesome',
	"placeholder"	=> __( 'Choose a font icon', 'tpl' ),
	"default"		=> 'facebook'
];
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_boolean_normal',
	"title"			=> __( 'Test boolean Field', 'tpl' ),
	"description"	=> __( 'Description for Test boolean Field', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'boolean',
	"default"		=> false,
];
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_color_normal',
	"title"			=> __( 'Test color Field', 'tpl' ),
	"description"	=> __( 'Description for Test color Field', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'color',
];
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_image_normal',
	"title"			=> __( 'Test image Field', 'tpl' ),
	"description"	=> __( 'Description for Test image Field', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'image',
];
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_date_normal',
	"title"			=> __( 'Test date Field', 'tpl' ),
	"description"	=> __( 'Description for Test date Field', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'date',
];
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_checkboxes_normal',
	"title"			=> __( 'Test checkboxes Field', 'tpl' ),
	"description"	=> __( 'Description for Test checkboxes Field', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'checkboxes',
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
