<?php

/*
TPL (Tiny Plugin Loom) Framework main file
For more information and documentation, visit [https://github.com/ervind/tpl-fw]
*/


if ( !function_exists( 'TPL_FW' ) ) {

	defined( 'TPL_VERSION' ) || define( 'TPL_VERSION', '2.3.1' );
	defined( 'TPL_ROOT_DIR' ) || define( 'TPL_ROOT_DIR', __DIR__ . '/' );
	defined( 'TPL_ROOT_URL' ) || define( 'TPL_ROOT_URL', plugin_dir_url( __FILE__ ) );


	require_once TPL_ROOT_DIR . 'inc/helper-functions.php';
	require_once TPL_ROOT_DIR . 'inc/classes/tpl-error.php';
	require_once TPL_ROOT_DIR . 'inc/classes/tpl-settings-page.php';
	require_once TPL_ROOT_DIR . 'inc/classes/tpl-post-type.php';
	require_once TPL_ROOT_DIR . 'inc/classes/tpl-section.php';
	require_once TPL_ROOT_DIR . 'inc/classes/tpl-option.php';
	require_once TPL_ROOT_DIR . 'inc/classes/tpl-framework.php';


	function TPL_FW() {
		return TPL_Framework::instance();
	}
	TPL_FW();


	/*
	 * DEMO Options
	 * ============
	 * Uncomment the following line to test how the different Data Types work.
	 * In this case you'll see a new item in your WP-Admin menu, called "TPL Demos", where you can find an instance of all data types.
	 * You can use it as the basis of your project's settings by copying the contents of the /demo folder in another folder inside your project (but outside /framework), and customizing it.
	 */
	// require_once TPL_ROOT_DIR . 'demo/tpl-demos.php';

}
