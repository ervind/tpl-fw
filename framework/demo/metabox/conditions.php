<?php


$section_name = 'conditional_post_demos';


$tpl_option_args = [
	"name"			=> 'demo_post_conditional_text_enabler',
	"title"			=> __( 'Conditional Text Field Enabler', 'tpl' ),
	"description"	=> __( 'Enable/disable this option and see how the text field below shows/hides.', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'boolean',
	"default"		=> true,
];
TPL_FW()->register_option( $tpl_option_args );

$tpl_option_args = [
	"name"			=> 'demo_post_conditional_text_normal',
	"title"			=> __( 'Test Conditional Text Field', 'tpl' ),
	"description"	=> __( 'This field should only be visible when the "Conditional Text Field Enabler" boolean option is set to True.', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'text',
	"default"		=> __( 'Test text default value', 'tpl' ),
	"condition"		=> [
		[
			"type"			=> 'option',
			"name"			=> 'demo_post_conditional_text_enabler',
			"relation"		=> '=',
			"value"			=> true,
		]
	],
];
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_post_conditional_combined_enabler',
	"title"			=> __( 'Conditional Combined Field Enabler', 'tpl' ),
	"description"	=> __( 'Enable/disable this option and see how the combined field below shows/hides.', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'boolean',
	"default"		=> false,
];
TPL_FW()->register_option( $tpl_option_args );

$tpl_option_args = [
	"name"			=> 'demo_post_conditional_combined_normal',
	"title"			=> __( 'Test combined Field', 'tpl' ),
	"description"	=> __( 'This field should only be visible when the "Conditional Combined Field Enabler" boolean option is set to True.', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'combined',
	"parts"			=> [
		[
			"name"		=> 'demo_combined_image',
			"title"		=> __( 'Image subitem', 'tpl' ),
			"type"		=> 'image',
		],
		[
			"name"		=> 'demo_combined_text',
			"title"		=> __( 'Text subitem', 'tpl' ),
			"type"		=> 'text',
			"condition"		=> [
				[
					"type"			=> 'option',
					"name"			=> 'demo_post_conditional_text_enabler',
					"relation"		=> '=',
					"value"			=> true,
				],
				[
					"type"			=> 'option',
					"name"			=> '_THIS_/demo_combined_date',
					"relation"		=> '>',
					"value"			=> date( 'Y-m-d' ),
				],
				"logic"		=> 'or',
			],
		],
		[
			"name"		=> 'demo_combined_number',
			"title"		=> __( 'Number subitem', 'tpl' ),
			"type"		=> 'number',
		],
		[
			"name"		=> 'demo_combined_date',
			"title"		=> __( 'Date subitem', 'tpl' ),
			"type"		=> 'date',
			"description" => __( 'If you pass here a future date, a new conditional field should pop up below.', 'tpl' ),
		],
		[
			"name"		=> 'demo_combined_tinymce',
			"title"		=> __( 'Tinymce subitem', 'tpl' ),
			"type"		=> 'tinymce',
			"condition"		=> [
				[
					"type"			=> 'option',
					"name"			=> '_THIS_/demo_combined_date',
					"relation"		=> '>',
					"value"			=> date( 'Y-m-d' ),
				]
			],
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
	],
	"condition"		=> [
		[
			"type"			=> 'option',
			"name"			=> 'demo_post_conditional_combined_enabler',
			"relation"		=> '=',
			"value"			=> true,
		]
	],
];
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_post_conditional_repeater_disable',
	"title"			=> __( 'Disable the repeater field below', 'tpl' ),
	"description"	=> __( 'If true, the repeater field below disappears', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'boolean',
	"default"		=> true,
];
TPL_FW()->register_option( $tpl_option_args );

$tpl_option_args = [
	"name"			=> 'demo_post_conditional_text_repeater',
	"title"			=> __( 'Test Conditional Repeater Field', 'tpl' ),
	"description"	=> __( 'This field should only be visible when the "Disable the repeater field below" boolean option is set to False.', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'text',
	"repeat"		=> true,
	"default"		=> __( 'Test text default value', 'tpl' ),
	"condition"		=> [
		[
			"type"			=> 'option',
			"name"			=> 'demo_post_conditional_repeater_disable',
			"relation"		=> '!=',
			"value"			=> true,
		]
	],
];
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_post_conditional_icon_enabler',
	"title"			=> __( 'Conditional Repeater Icon Field Enabler', 'tpl' ),
	"description"	=> __( 'Enable/disable this option and see how the repeater icon field below shows/hides.', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'boolean',
	"default"		=> true,
];
TPL_FW()->register_option( $tpl_option_args );

$tpl_option_args = [
	"name"			=> 'demo_post_conditional_icon_repeater',
	"title"			=> __( 'Test Conditional Icon Field', 'tpl' ),
	"description"	=> __( 'This field should only be visible when the "Conditional Repeater Icon Field Enabler" boolean option is set to True.', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'icon',
	"repeat"		=> true,
	"condition"		=> [
		[
			"type"			=> 'option',
			"name"			=> 'demo_post_conditional_icon_enabler',
			"relation"		=> '=',
			"value"			=> true,
		]
	],
];
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_post_category_conditinal_text',
	"title"			=> __( 'Conditional Text Field by Category', 'tpl' ),
	"description"	=> __( 'This field should only be visible when you edit a Post and the category is Uncategorized.', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'text',
	"default"		=> __( 'Test text default value', 'tpl' ),
	"condition"		=> [
		[
			"type"			=> 'post',
			"name"			=> 'type',
			"relation"		=> '=',
			"value"			=> 'post',
		]
	],
];
TPL_FW()->register_option( $tpl_option_args );


$tpl_option_args = [
	"name"			=> 'demo_post_conditional_checkboxes',
	"title"			=> __( 'Test Conditional Checkboxes Field', 'tpl' ),
	"description"	=> __( 'This field should only be visible when the "Conditional Checkboxes Field Enabler" boolean option is set to True.', 'tpl' ),
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

$tpl_option_args = [
	"name"			=> 'demo_post_conditional_checkboxes_text',
	"title"			=> __( 'Test Conditional Text Field based on Checkboxes value', 'tpl' ),
	"description"	=> __( 'This field should only be visible when the second option is enabled above.', 'tpl' ),
	"section"		=> $section_name,
	"type"			=> 'text',
	"condition"		=> [
		[
			"type"			=> 'option',
			"name"			=> 'demo_post_conditional_checkboxes',
			"relation"		=> 'unlike',
			"value"			=> 'second:1',
		]
	],
];
TPL_FW()->register_option( $tpl_option_args );
