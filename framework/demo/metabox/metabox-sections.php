<?php


$tpl_section_args = [
	"name"			=> 'simple_post_demos',
	"title"			=> __( 'Metabox Simple Demo Fields', 'tpl' ),
	"description"	=> __( 'Testing simple (non-repeater) fields', 'tpl' ),
	"post_type"		=> [ 'post', 'chch_product' ],
];
TPL_FW()->register_section( $tpl_section_args );


$tpl_section_args = [
	"name"			=> 'repeater_post_demos',
	"title"			=> __( 'Metabox Repeater Demo Fields', 'tpl' ),
	"description"	=> __( 'Testing repeater fields', 'tpl' ),
	"post_type"		=> [ 'post', 'chch_product' ],
];
TPL_FW()->register_section( $tpl_section_args );


$tpl_section_args = [
	"name"			=> 'combined_post_demos',
	"title"			=> __( 'Metabox Combined Demo Fields', 'tpl' ),
	"description"	=> __( 'Testing combined fields', 'tpl' ),
	"post_type"		=> [ 'post', 'chch_product' ],
];
TPL_FW()->register_section( $tpl_section_args );


$tpl_section_args = [
	"name"			=> 'combined_repeater_post_demos',
	"title"			=> __( 'Metabox Combined Repeater Demo Fields', 'tpl' ),
	"description"	=> __( 'Testing combined repeater fields', 'tpl' ),
	"post_type"		=> [ 'post', 'chch_product' ],
];
TPL_FW()->register_section( $tpl_section_args );


$tpl_section_args = [
	"name"			=> 'conditional_post_demos',
	"title"			=> __( 'Conditional Demo Fields', 'tpl' ),
	"description"	=> __( 'Conditional fields\' visibilities are dependent on other fields.', 'tpl' ),
	"post_type"		=> [ 'post', 'chch_product' ],
];
TPL_FW()->register_section( $tpl_section_args );
