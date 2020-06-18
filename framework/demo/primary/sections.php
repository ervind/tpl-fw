<?php


$tpl_section_args = [
	"name"			=> 'simple_demos',
	"tab"			=> __( 'Simple', 'tpl' ),
	"title"			=> __( 'Simple Demo Fields', 'tpl' ),
	"description"	=> __( 'Testing simple (non-repeater) fields', 'tpl' ),
	"post_type"		=> [ 'tpl-demos', 'tpl_demos' ],
];
$tpl_fw->register_section( $tpl_section_args );


$tpl_section_args = [
	"name"			=> 'repeater_demos',
	"tab"			=> __( 'Repeater', 'tpl' ),
	"title"			=> __( 'Repeater Demo Fields', 'tpl' ),
	"description"	=> __( 'Testing repeater fields', 'tpl' ),
	"post_type"		=> [ 'tpl-demos', 'tpl_demos' ],
];
$tpl_fw->register_section( $tpl_section_args );


$tpl_section_args = [
	"name"			=> 'combined_demos',
	"tab"			=> __( 'Combined', 'tpl' ),
	"title"			=> __( 'Combined Demo Fields', 'tpl' ),
	"description"	=> __( 'Testing combined fields', 'tpl' ),
	"post_type"		=> [ 'tpl-demos', 'tpl_demos' ],
];
$tpl_fw->register_section( $tpl_section_args );


$tpl_section_args = [
	"name"			=> 'combined_repeater_demos',
	"tab"			=> __( 'Combined Repeater', 'tpl' ),
	"title"			=> __( 'Combined Repeater Demo Fields', 'tpl' ),
	"description"	=> __( 'Testing combined repeater fields', 'tpl' ),
	"post_type"		=> [ 'tpl-demos', 'tpl_demos' ],
];
$tpl_fw->register_section( $tpl_section_args );


$tpl_section_args = [
	"name"			=> 'conditional_demos',
	"tab"			=> __( 'Conditional', 'tpl' ),
	"title"			=> __( 'Conditional Demo Fields', 'tpl' ),
	"description"	=> __( 'Conditional fields\' visibilities are dependent on other fields.', 'tpl' ),
	"post_type"		=> [ 'tpl-demos', 'tpl_demos' ],
];
$tpl_fw->register_section( $tpl_section_args );
