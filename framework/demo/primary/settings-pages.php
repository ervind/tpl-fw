<?php


TPL_FW()->register_settings_page( [
	"name"			=> 'tpl_demos',
	"page_title"	=> __( 'TPL Dummy Settings Page', 'tpl' ),
	"menu_title"	=> __( 'TPL Demos', 'tpl' ),
	"capability"	=> 'manage_options',
	"menu_slug"		=> 'tpl-demos',
	"function"		=> function() {
		$settings_page = TPL_FW()->get_settings_page( 'tpl_demos' );
		$settings_page->render_page();
	},
	"menu_func"		=> 'add_menu_page',
	"icon_url"		=> '',
	"post_type"		=> 'tpl_demos',
] );
