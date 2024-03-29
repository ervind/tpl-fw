<?php


$section_name = 'combined_repeater_demos';


$tpl_option_args = [
	"name"			=> 'demo_combined_repeater',
	"title"			=> __( 'Test combined Repeater Field', 'tpl' ),
	"description"	=> __( 'Description for Test combined Repeater Field', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'combined',
	"repeat"		=> true,
	"parts"			=> [
		[
			"name"		=> 'demo_combined_repeater_text',
			"title"		=> __( 'Text subitem', 'tpl' ),
			"type"		=> 'text',
		],
		[
			"name"		=> 'demo_combined_repeater_boolean',
			"title"		=> __( 'Boolean subitem', 'tpl' ),
			"type"		=> 'boolean',
			"default"	=> true,
		],
		[
			"name"		=> 'demo_combined_repeater_image',
			"title"		=> __( 'Image subitem', 'tpl' ),
			"type"		=> 'image',
		],
		[
			"name"		=> 'demo_combined_repeater_date',
			"title"		=> __( 'Date subitem', 'tpl' ),
			"type"		=> 'date',
		],
		[
			"name"		=> 'demo_combined_repeater_tinymce',
			"title"		=> __( 'Tinymce subitem', 'tpl' ),
			"type"		=> 'tinymce',
		],
		[
			"name"		=> 'demo_combined_repeater_color',
			"title"		=> __( 'Color subitem', 'tpl' ),
			"type"		=> 'color',
		],
		[
			"name"		=> 'demo_combined_repeater_font_awesome',
			"title"		=> __( 'Font Awesome subitem', 'tpl' ),
			"type"		=> 'font_awesome',
		],
		[
			"name"		=> 'demo_combined_repeater_page',
			"title"		=> __( 'Page subitem', 'tpl' ),
			"type"		=> 'post',
			"post_type"	=> 'page',
		],
		[
			"name"		=> 'demo_combined_repeater_user',
			"title"		=> __( 'User subitem', 'tpl' ),
			"type"		=> 'user',
		],
		[
			"name"			=> 'demo_combined_repeater_checkboxes',
			"title"			=> __( 'Checkboxes subitem', 'tpl' ),
			"type"			=> 'checkboxes',
			"values"		=> [
				"first"			=> __( 'First Option', 'tpl' ),
				"second"		=> __( 'Second Option', 'tpl' ),
				"third"			=> __( 'Third Option', 'tpl' ),
				"fourth"		=> __( 'Fourth Option', 'tpl' ),
				"fifth"			=> __( 'Fifth Option', 'tpl' ),
			],
		],
	]
];
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_icon_repeater',
	"title"			=> __( 'Test icon Repeater Field', 'tpl' ),
	"description"	=> __( 'Description for Test icon Repeater Field', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'icon',
	"repeat"		=> true,
];
TPL_FW()->register_option( $tpl_option_args );
