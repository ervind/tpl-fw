<?php


$section_name = 'combined_demos';


$tpl_option_args = [
	"name"			=> 'demo_combined_normal',
	"title"			=> __( 'Test combined Field', 'tpl' ),
	"description"	=> __( 'Description for Test combined Field', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'combined',
	"parts"			=> [
		[
			"name"		=> 'demo_combined_text',
			"title"		=> __( 'Text subitem', 'tpl' ),
			"type"		=> 'text',
		],
		[
			"name"		=> 'demo_combined_boolean',
			"title"		=> __( 'Boolean subitem', 'tpl' ),
			"type"		=> 'boolean',
			"default"	=> true,
		],
		[
			"name"		=> 'demo_combined_image',
			"title"		=> __( 'Image subitem', 'tpl' ),
			"type"		=> 'image',
		],
		[
			"name"		=> 'demo_combined_date',
			"title"		=> __( 'Date subitem', 'tpl' ),
			"type"		=> 'date',
		],
		[
			"name"		=> 'demo_combined_tinymce',
			"title"		=> __( 'Tinymce subitem', 'tpl' ),
			"type"		=> 'tinymce',
		],
		[
			"name"		=> 'demo_combined_color',
			"title"		=> __( 'Color subitem', 'tpl' ),
			"type"		=> 'color',
		],
		[
			"name"		=> 'demo_combined_font_awesome',
			"title"		=> __( 'Font Awesome subitem', 'tpl' ),
			"type"		=> 'font_awesome',
		],
		[
			"name"		=> 'demo_combined_page',
			"title"		=> __( 'Page subitem', 'tpl' ),
			"type"		=> 'post',
			"post_type"	=> 'page',
		],
		[
			"name"		=> 'demo_combined_user',
			"title"		=> __( 'User subitem', 'tpl' ),
			"type"		=> 'user',
		],
		[
			"name"			=> 'demo_combined_checkboxes',
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
	"name"			=> 'demo_icon_normal',
	"title"			=> __( 'Test icon Field', 'tpl' ),
	"description"	=> __( 'Description for Test icon Field', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'icon',
];
TPL_FW()->register_option( $tpl_option_args );
