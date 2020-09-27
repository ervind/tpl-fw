<?php // Testing error handling


$tpl_section_args = [
	"tab"			=> __( 'No name', 'tpl' ),
	"title"			=> __( 'Section without a name', 'tpl' ),
	"post_type"		=> [ 'tpl-demos', 'tpl_demos' ],
];
TPL_FW()->register_section( $tpl_section_args );


$tpl_section_args = [
	"name"			=> 'no_tab_name',
	"title"			=> __( 'Without a tab name', 'tpl' ),
	"description"	=> __( 'Using the section title as a fallback.', 'tpl' ),
	"post_type"		=> [ 'tpl-demos', 'tpl_demos' ],
];
TPL_FW()->register_section( $tpl_section_args );
