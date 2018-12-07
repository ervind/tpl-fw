<?php

/*
TPL (The Plugin Launcher) Framework main file
For more information and documentation, visit [https://a-idea.studio/tpl-framework]
*/



// Version number of the framework
define( 'TPL_VERSION', '1.3.2' );




// Firstly, adding the necessary action hooks

// Adding admin script...
add_action ( 'admin_enqueue_scripts', 'tpl_admin_scripts', 20 );


// Load data type components
add_action ( 'init', 'tpl_load_data_types' );


// Initial actions (menus, admin pages)
add_action ( 'admin_menu', 'tpl_admin_init' );


// Add metaboxes for post editor
add_action( 'add_meta_boxes', 'tpl_add_custom_box' );


// Save postmeta when saving a post
add_action( 'pre_post_update', 'tpl_save_postdata' );


// Adds the repeater field bank in the footer
add_action( 'admin_footer', 'tpl_repeater_bank' );


// Now setting up some global variables:

// The options array that stores all the options used by the plugin
$tpl_options_array = array();

// The sections array that stores the sections (tabs) on Options pages and in metaboxes in the post editor
$tpl_sections = array();

// Registered data types
$tpl_data_types = array();

// Register the settings pages used in the admin panel
global $tpl_settings_pages;
$tpl_settings_pages = apply_filters( 'tpl_settings_pages', array() );





/*
HELPER FUNCTIONS
*/

// Gets the path directory for the plugin root
function tpl_base_dir() {

	$x = plugin_basename( __FILE__ );
	$xa = explode( '/', $x );
	return WP_PLUGIN_DIR . '/' . $xa[0];

}



// Gets the URI for the plugin root
function tpl_base_uri() {

	$x = plugin_basename( __FILE__ );
	$xa = explode( '/', $x );
	return plugins_url() . '/' . $xa[0];

}



// Displays an error message in an alert box.
// $msg: the message to display
// If $global == true then it displays it as an admin notification. Else next to the option in the options flow
// $class can have 3 values: error, updated, notice-warning (https://codex.wordpress.org/Plugin_API/Action_Reference/admin_notices)
// $entity: you can change the default "TPL error/warning" text from the beginning of the message
function tpl_error ( $msg, $global = true, $class = "error", $entity = "TPL" ) {

	// Display the message next to the option
	if ( $global == false ) {

		echo '<p class="tpl-error">' . tpl_kses( $msg ) . '</p>';

	}

	// Or as an admin notice
	else {

		add_action( 'admin_notices', function() use ( $msg, $class, $entity ) {

			if ( $class == 'error' ) {
				$msg = '<strong>' . sprintf( __( '%s error', 'tpl' ), $entity ) . '</strong>: ' . $msg;
			}
			if ( $class == 'notice-warning' ) {
				$msg = '<strong>' . sprintf( __( '%s warning', 'tpl' ), $entity ) . '</strong>: ' . $msg;
			}
			echo '<div class="notice is-dismissible settings-error tpl-global-error notice-'. esc_attr( $class ) .'"><p>'. tpl_kses( $msg ) .'</p></div>';

		});

	}

}



// Safe loader for framework parts. Uses require_once if the file exists and is readable
function tpl_loader ( $filename ) {

	if ( file_exists ( $filename ) ) {

		require_once $filename;
		return $filename;

	}

	else {
		tpl_error ( __( 'File not exists', 'tpl' ) . ': ' . $filename, true );
	}

}




// Read all data types that are present in the 'framework/data-types' directory
function tpl_load_data_types () {

	global $tpl_data_types;

	// Defining the file names and the order they are loaded - important as Data Types can be dependent on other Data Types
	$files = array(
		"class-data_type",
		"type-static",
		"type-text",
		"type-textarea",
		"type-tinymce",
		"type-color",
		"type-image",
		"type-number",
		"type-boolean",
		"type-select",
		"type-font_awesome",
		"type-post",
		"type-user",
		"type-date",
		"type-combined",
		"type-icon",
		"type-font",
		"type-page_builder",
	);

	// Now run the load loop for Data Types
	foreach ( $files as $file ) {

		if ( file_exists ( tpl_base_dir() . '/framework/data-types/' . $file . '.php' ) ) {
			tpl_loader ( tpl_base_dir() . '/framework/data-types/' . $file . '.php' );
			$curtype = explode ( '-', $file );
			$tpl_data_types[] = $curtype[1];
		}

	}

}



// Escape non-permitted tags from outputs. An extended version of wp_kses() with some pre-defined values
function tpl_kses( $string, $additional_allowed_html = array() ) {

	$allowed_html = apply_filters( 'tpl_kses_allowed_html', array(

		'a'		=> array(
			'href'	=> array(),
			'title'	=> array(),
			'class'	=> array(),
			'target'=> array(),
		),
		'img'	=> array(
			'src'	=> array(),
			'title'	=> array(),
			'alt'	=> array(),
			'class'	=> array(),
		),
		'br'	=> array(),
		'hr'	=> array(),
		'em'	=> array(
			'class'	=> array(),
		),
		'strong'=> array(
			'class'	=> array(),
		),
		'i'		=> array(
			'class'	=> array(),
		),
		'b'		=> array(
			'class'	=> array(),
		),
		'div'	=> array(
			'class'	=> array(),
			'id'	=> array(),
		),
		'h1'	=> array(),
		'h2'	=> array(),
		'h3'	=> array(),
		'h4'	=> array(),
		'h5'	=> array(),
		'h6'	=> array(),
		'p'		=> array(
			'class'	=> array(),
		),
		'span'	=> array(
			'class'	=> array(),
		),
		'ul'	=> array(
			'class'	=> array(),
		),
		'li'	=> array(
			'class'	=> array(),
		),
		'pre'	=> array(),

	) );

	$allowed_html = array_merge( $allowed_html, $additional_allowed_html );

	return wp_kses( $string, $allowed_html );

}



// Removes empty P tags from content. Might be used by some Data Types
function tpl_remove_empty_p ( $content ) {
	$content = force_balance_tags( $content );
    return preg_replace( '#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content );
}




/*
OPTION HANDLING
*/

// Register an option in the framework
function tpl_register_option ( $narr ) {

	// Use the global $tpl_options_array that builds up the Plugin Settings panel
	global $tpl_options_array, $tpl_data_types;

	$narr = apply_filters( 'tpl_before_register_option', $narr );

	// Prevent the site frome freezing if an option has no name
	if ( !isset( $narr["name"] ) ) {
		tpl_error(
			apply_filters( 'tpl_option_noname_errormsg', __( 'You forgot to set name for an option. Please check your options files.', 'tpl' ) ), true
		);
		return;
	}

	$already_registered = false;
	$narr_name = $narr["name"];

	if ( isset( $tpl_options_array[$narr_name] ) ) {
		$already_registered = true;
	}

	// If not registered yet, register it
	if ( !$already_registered ) {

		if ( !isset( $narr["type"] ) || !in_array( $narr["type"], $tpl_data_types ) ) {

			tpl_error(
				sprintf(
					__( 'You forgot to set the type of %s. Using static to avoid errors...', 'tpl' ),
					esc_html( $narr["name"] )
				), true
			);

			$narr["type"] = "static";

		}

		$type_class = tpl_get_type_class( $narr["type"] );
		if ( class_exists( $type_class ) ) {
			$tpl_options_array[$narr_name] = new $type_class( $narr );
		}
		else {
			tpl_error(
				sprintf( __( 'Data type %s doesn\'t exists', 'tpl' ),
					'<strong>'. esc_html( $narr["type"] ) .'</strong>'
				), true );
		}
	}

	// Otherwise drop an error message about the duplicate
	else {
		tpl_error(
			sprintf( __( 'Option with name %1$s was defined more than once in your options files. Using the first instance (%2$s)', 'tpl' ),
				'<strong>'. esc_html( $narr["name"] ) .'</strong>',
				esc_html( $tpl_options_array[$narr_name]->title )
			), true );
	}

}



// Registers sections and post metaboxes for the framework
function tpl_register_section ( $narr ) {

	// Use the global $tpl_sections that builds up the Plugin Settings panel's sections and the post metaboxes
	global $tpl_sections;

	$narr_name = $narr["name"];

	// If no post_type was set, it goes automatically to the Theme Options page »» This needs to be addressed in future versions!!!
	if ( !isset( $narr["post_type"] ) ) {
		$narr["post_type"] = 'theme_options';
	}

	$tpl_sections[$narr_name] = $narr;

}



// Checks if a data type is present in the Framework
function tpl_type_registered ( $type ) {

	global $tpl_data_types;

	if ( in_array ( $type, $tpl_data_types ) ) {
		return true;
	}
	else {
		return false;
	}

}



// Checks if a section is registered
function tpl_section_registered ( $section ) {

	global $tpl_sections;

	if ( array_key_exists ( $section, $tpl_sections ) ) {
		return true;
	}
	else {
		return false;
	}

}



// Checks if an option is registered
function tpl_option_registered ( $name ) {

	global $tpl_options_array;

	if ( array_key_exists ( $name, $tpl_options_array ) ) {
		return true;
	}
	else {
		return false;
	}

}



// Collects the sections for the $post_type. If no post type is specified, it returns the Theme Options sections.
// For future reference »» it should drop an error message in future versions
function tpl_get_sections ( $post_type = "theme_options" ) {

	global $tpl_sections;

	$output_sections = array();

	foreach ( $tpl_sections as $section ) {

		if ( tpl_has_section_post_type( $section["name"], $post_type ) ) {
			$output_sections[] = $section;
		}

	}

	return $output_sections;

}



// Gets the class name for the specified data type
function tpl_get_type_class( $type ) {

	return 'TPL_' . ucfirst( $type );

}



// Gets all options for $section and returns an array of them.
function tpl_options_by_section ( $section ) {

    global $tpl_options_array;

    $result = array();

    foreach ( $tpl_options_array as $option ) {

		if ( $option->section == $section ) {
			$result[] = $option;
		}

    }

    return $result;

}



// Initializes the Plugin Settings pages
// Need to remove theme-related parts from future versions
function tpl_admin_init () {

    global $tpl_options_array, $tpl_sections, $tpl_settings_pages;

	// Set up the admin settings pages
	foreach ( $tpl_settings_pages as $key => $settings_page ) {

		if ( isset( $settings_page["menu_func"] ) ) {
			$menu_func = $settings_page["menu_func"];
		}
		else {
			$menu_func = 'add_theme_page';
		}

		if ( $key != 'tpl_framework_options' || ( !defined( 'HIDE_FRAMEWORK_OPTIONS' ) || HIDE_FRAMEWORK_OPTIONS == false ) ) {

			$menu_func (
				$settings_page["page_title"],
				$settings_page["menu_title"],
				$settings_page["capability"],
				$settings_page["menu_slug"],
				$settings_page["function"]
			);

		}

		if ( get_option( $key ) == false ) {
			add_option( $key );
		}

		register_setting (
			$key,
			$key
		);

	}

	// Now start loading the sections
	$loaded_sections = array();

	// Add the option fields
	foreach ( $tpl_options_array as $option ) {

		// Making it foolproof - if the developer forgot to register the section, we're registering it for him, but sending a warning, too...
		if ( !tpl_section_registered ( $option->section ) ) {

			tpl_register_section ( array(
				"name"			=> $option->section,
				"title"			=> $option->section,
				"description"	=> "",
				"tab"			=> $option->section
			) );

			tpl_error (
				sprintf( __( 'Section "%s" hasn\'t been registered properly. Please register it first with the tpl_register_section() function.', 'tpl' ),
				esc_html( $option->section )
			), true, 'notice-warning' );

		}

		// Setting up which page it has to appear on
		if ( tpl_is_primary_section( $option->section ) ) {

			if ( empty( $tpl_sections[$option->section]['post_type'] ) ) {
				$page = 'tpl_theme_options';
			}
			else {
				foreach ( $tpl_settings_pages as $key => $settings_page ) {
					if ( $settings_page["post_type"] == $tpl_sections[$option->section]["post_type"] ) {
						$page = $key;
						break;
					}
				}
			}

			if ( !in_array ( $option->section, $loaded_sections ) ) {
				add_settings_section(
					$option->section,
					tpl_section_name ( $option->section ),
					'tpl_section_info',
					$page
				);
			}

		}

		// Dynamically create sections if not registered yet.
		if ( !in_array ( $option->section, $loaded_sections ) ) {

			$loaded_sections[] = $option->section;

		}

		if ( !isset ( $option->type ) ) {
			$option->type = "";
		}

		if ( tpl_is_primary_section( $option->section ) ) {

			add_settings_field (
				$option->name,
				$option->title,
				'tpl_settings_page_callback',
				$page,
				$option->section,
				(array) $option
			);

		}

	}


	// Load remaining registered sections
	foreach ( $tpl_sections as $section ) {

		if ( tpl_is_primary_section( $section["name"] ) ) {

			if ( empty( $tpl_sections[$section['name']]['post_type'] ) ) {
				$page = 'tpl_theme_options';
			}
			else {
				foreach ( $tpl_settings_pages as $key => $settings_page ) {
					if ( $settings_page["post_type"] == $tpl_sections[$section['name']]['post_type'] ) {
						$page = $key;
						break;
					}
				}
			}

			if ( !in_array( $section["name"], $loaded_sections ) ) {

				add_settings_section(
					$section["name"],
					tpl_section_name ( $section["name"] ),
					'tpl_section_info',
					$page
				);

			}

		}

		if ( !in_array( $section["name"], $loaded_sections ) ) {
			$loaded_sections[] = $section["name"];
		}

	}

}



// Section callback function
function tpl_section_info ( $arg ) {

	global $tpl_sections;

	if ( !tpl_section_registered ( $arg["id"] ) ) {
		return;
	}

	echo '<p>' . tpl_kses( $tpl_sections[$arg["id"]]["description"] ) . '</p>';

}



// Section callback function
function tpl_section_name ( $section_slug ) {

	global $tpl_sections;

	if ( !tpl_section_registered ( $section_slug ) ) {
		return $section_slug;
	}

	return $tpl_sections[$section_slug]["title"];

}



// Returns true if $section_name is connected to $post_type
function tpl_has_section_post_type ( $section_name, $post_type ) {

	global $tpl_sections;

	if ( isset( $tpl_sections[$section_name] ) ) {
		if ( is_array( $tpl_sections[$section_name]["post_type"] ) ) {
			if ( in_array( $post_type, $tpl_sections[$section_name]["post_type"] ) ) {
				return true;
			}
		}
		else {
			if ( $post_type == $tpl_sections[$section_name]["post_type"] ) {
				return true;
			}
		}
	}

	return false;

}



// This function puts an option input field on the settings page
function tpl_settings_page_callback ( $args ) {

	global $tpl_options_array;

	$name = $args["name"];
	$type = $args["type"];

	if ( $type == "" ) {
		tpl_error (
			sprintf( __( 'No data type was set up for option: %s', 'tpl' ),
				esc_html( $name )
			), false );
	}

	elseif ( !tpl_type_registered ( $type ) ) {
		tpl_error (
			sprintf( __( 'Invalid data type (%1$s) was set for option: %2$s', 'tpl' ),
				esc_html( $type ),
				esc_html( $name )
			), false );
	}

	else {

		$tpl_options_array[$name]->form_field();

		if ( $tpl_options_array[$name]->repeat !== false && !isset( $tpl_options_array[$name]->repeat["number"] ) ) {
			echo '</td></tr><tr class="tpl-button-row"><td></td><td><div class="tpl-button-container"><button class="tpl-repeat-add" data-for="' . esc_attr( $tpl_options_array[$name]->data_name ) . '">' . esc_html( $tpl_options_array[$name]->repeat_button_title ) . '</button></div>';
		}

		if ( !isset( $args["description"] ) ) {
			$args["description"] = "";
		}
		echo '</td></tr><tr><td class="tpl-optiondesc clearfix" colspan="2">'. tpl_kses( $args["description"] );

	}

}



// Gets the unformatted values from wpdb
function tpl_get_option ( $name, $post_id = 0 ) {

	global $tpl_options_array;

	if ( is_array( $name ) ) {
		$path = explode( '/', $name["name"] );
		$name["name"] = $path[0];
		$name["path"] = $path;
		if ( isset ( $tpl_options_array[$name["name"]]->type ) ) {
			return $tpl_options_array[$name["name"]]->get_option( $name, $post_id );
		}
		else {
			return '';
		}
	}

	else {
		$path = explode( '/', $name );
		$name = $path[0];
		if ( isset ( $tpl_options_array[$name]->type ) ) {
			return $tpl_options_array[$name]->get_option( array( 'path' => $path ), $post_id );
		}
		else {
			return '';
		}
	}

}



// Gets the formatted values of an option
function tpl_get_value ( $name, $post_id = 0 ) {

    global $tpl_options_array;

	if ( is_array( $name ) ) {
		$path = explode( '/', $name["name"] );
		$name["name"] = $path[0];
		$name["path"] = $path;
		if ( isset ( $tpl_options_array[$name["name"]]->type ) ) {
			return $tpl_options_array[$name["name"]]->get_value( $name, $post_id );
		}
		else {
			return '';
		}
	}

	else {
		$path = explode( '/', $name );
		$name = $path[0];
		if ( isset ( $tpl_options_array[$name]->type ) ) {
			return $tpl_options_array[$name]->get_value( array( 'path' => $path ), $post_id );
		}
		else {
			return '';
		}
	}

}



// Prints the values of an option
function tpl_value ( $name, $post_id = 0 ) {

    global $tpl_options_array;

	if ( is_array( $name ) ) {
		$path = explode( '/', $name["name"] );
		$name["name"] = $path[0];
		$name["path"] = $path;
		if ( isset ( $tpl_options_array[$name["name"]]->type ) ) {
			return $tpl_options_array[$name["name"]]->value( $name, $post_id );
		}
		else {
			return '';
		}
	}

	else {
		$path = explode( '/', $name );
		$name = $path[0];
		if ( isset ( $tpl_options_array[$name]->type ) ) {
			return $tpl_options_array[$name]->value( array( 'path' => $path ), $post_id );
		}
		else {
			return '';
		}
	}

}



// Gets the full option object for more advanced use. Devs can reach the full spectrum of data type functions with this function.
function tpl_get_option_object ( $name, $post_id = 0 ) {

	global $tpl_options_array;

	if ( is_array( $name ) ) {
		$path = explode( '/', $name["name"] );
		$name["name"] = $path[0];
		$name["path"] = $path;
		if ( isset ( $tpl_options_array[$name["name"]]->type ) ) {
			return $tpl_options_array[$name["name"]]->get_object( $name, $post_id );
		}
		else {
			return '';
		}
	}

	else {
		$path = explode( '/', $name );
		$name = $path[0];
		if ( isset( $tpl_options_array[$name] ) && isset ( $tpl_options_array[$name]->type ) ) {
			return $tpl_options_array[$name]->get_object( array( 'path' => $path ), $post_id );
		}
		else {
			return '';
		}
	}

}



// Checks if this is primary (Plugin Settings, etc.) or secondary (e.g. Post Metabox) section
function tpl_is_primary_section ( $section ) {

	global $tpl_sections, $tpl_settings_pages;

	if ( isset( $tpl_sections[$section]["post_type"] ) && !is_array( $tpl_sections[$section]["post_type"] ) ) {
		foreach ( $tpl_settings_pages as $key => $settings_page ) {
			if ( $settings_page["post_type"] == $tpl_sections[$section]["post_type"] ) {
				return true;
			}
		}
	}

	if ( !isset( $tpl_sections[$section]["post_type"] ) || $tpl_sections[$section]["post_type"] == '' ) {
		return true;
	}

	return false;

}



// This is the modified version of WP's do_settings_sections that allows us to use jQuery UI tabs in the settings pages.
function tpl_settings_sections ( $page ) {
	global $wp_settings_sections, $wp_settings_fields;

	if ( !isset( $wp_settings_sections[$page] ) ) {
		return;
	}

	foreach ( (array) $wp_settings_sections[$page] as $section ) {

		if ( tpl_is_primary_section ( $section["id"] ) == true ) {

			echo '<div id="' . esc_attr( $section["id"] ) . '">';

			if ( $section["title"] ) {
				echo '<h3>' . esc_html( $section["title"] ) . '</h3>';
			}

			if ( $section["callback"] ) {
				call_user_func( $section["callback"], $section );
			}

			if ( ! isset( $wp_settings_fields ) || !isset( $wp_settings_fields[$page] ) || !isset( $wp_settings_fields[$page][$section["id"]] ) ) {
				continue;
			}

			echo '<table class="form-table">';
			do_settings_fields( $page, $section["id"] );
			echo '</table>
			</div>';

		}
	}
}



// General function for creating TPL settings pages in the back end
function tpl_settings_page ( $settings_page ) {

	global $tpl_sections, $tpl_settings_pages;

	// Make the base structure of the Settings page
	echo '<div id="' . esc_attr( $tpl_settings_pages[$settings_page]["menu_slug"] ) . '_wrap" class="wrap tpl_settings_page_wrap">
            <h2 id="tpl-options-main-title">' . esc_html( $tpl_settings_pages[$settings_page]["page_title"] ) . '</h2>
            <form method="post" action="options.php">';

	// The number of sections to be created for Plugin Settings page
	$settings_page_sections = tpl_get_sections ( $tpl_settings_pages[$settings_page]["post_type"] );

	// Launch the tabbed layout only if there are more than 1 sections defined
	if ( count ( $settings_page_sections ) > 1 ) {
		echo '<div id="tpl-settings-tabs" data-store="' . esc_attr( $settings_page ) . '_activetab">
				<ul class="nav-tab-wrapper">';

		foreach ( $settings_page_sections as $section ) {
			echo '<li><a class="nav-tab" href="#' . esc_attr( $section["name"] ) . '">' . esc_html( $section["tab"] ) . '</a></li>';
		}

		echo '</ul>
		';
    }

	// Output the sections
	tpl_settings_sections ( $settings_page );

	// There was an open div if we used the tabbed layout
    if ( count ( $settings_page_sections ) > 1 ) {
		echo '</div>';
	}

	settings_fields ( $settings_page );
    echo get_submit_button() . '</form>
        </div>';

	do_action( 'tpl_after_primary_sections' );

}



// Adds the post metaboxes from the registered sections
function tpl_add_custom_box ( $post_type ) {

    $sections = tpl_get_sections ( $post_type );

    foreach ( $sections as $section ) {

        add_meta_box(
            $section["name"],
            $section["title"],
            'tpl_inner_custom_box',
            $post_type,
            'normal',
            'low',
            array ( "section" => $section["name"], "description" => $section["description"] )
        );

    }
}



// Display contents of custom metabox for post types
function tpl_inner_custom_box ( $post, $metabox ) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field ( 'tpl_inner_custom_box', 'tpl_inner_custom_box_nonce' );

	if ( $metabox["args"]["description"] != '' ) {
		echo tpl_kses( $metabox["args"]["description"] );
	}


	// Selects all options from $tpl_options_array which are in the current section
	$options = tpl_options_by_section ( $metabox["args"]["section"] );

	foreach ( $options as $option ) {

		$meta_key = '_tpl_' . $option->get_data_section();

		if ( get_post_meta ( $post->ID, $meta_key ) == "" ) {
			$values = array();
		}
		else {
			$values = get_post_meta ( $post->ID, $meta_key );
		}

		if ( !isset ( $values[0][$option->name] ) ) {
			$values[0][$option->name] = "";
		}

		$data_connected = '';
		if ( $option->condition_connected != '' ) {
			$data_connected = ' data-connected="' . esc_attr( $option->condition_connected ) . '"';
		}

		echo '<div class="clearfix tpl-meta-option"' . $data_connected . '>';

		echo '<span class="tpl-meta-option-label">' . tpl_kses( $option->title ) . '</span>';

		if ( !isset( $option->type ) || $option->type == "" ) {
			tpl_error(
				sprintf( __( 'No data type was set up for option: %s', 'tpl' ),
				esc_html( $option->name )
			), false );
		}

		elseif ( !tpl_type_registered ( $option->type ) ) {
			tpl_error (
				sprintf( __( 'Invalid data type (%1$s) was set for option: %2$s', 'tpl' ),
					esc_html( $option->type ),
					esc_html( $option->name )
				), false );
		}

		else {

			echo '<div class="tpl-meta-option-wrapper">';
			$option->form_field();
			echo '</div>';
			if ( $option->repeat !== false && !isset( $option->repeat["number"] ) ) {
				echo '<div class="tpl-button-container"><button class="tpl-repeat-add" data-for="' . esc_attr( $option->data_name ) . '">' . esc_html( $option->repeat_button_title ) . '</button></div>';
			}

		}

		echo '</div><p class="tpl-optiondesc clearfix">'. tpl_kses( $option->description ) .'</p><div class="clearfix"></div>';

	}

	echo '<div class="clearfix"></div>';

}



// Saves post meta into the database
function tpl_save_postdata( $post_id ) {

	// Check if our nonce is set.
	if ( ! isset( $_POST['tpl_inner_custom_box_nonce'] ) ) {
		return $post_id;
	}

	$nonce = $_POST['tpl_inner_custom_box_nonce'];

	// Verify that the nonce is valid.
	if ( !wp_verify_nonce ( $nonce, 'tpl_inner_custom_box' ) ) {
		return $post_id;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}

	// Check the user's permissions.
	if ( 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		}
	}
	else {
		if ( !current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}
	}

	/* OK, its safe for us to save the data now. */

	// Update the meta field in the database.

	$sections = tpl_get_sections ( get_post_type ( $post_id ) );

	foreach ( $sections as $section ) {

		$options = tpl_options_by_section ( $section["name"] );

		foreach ( $options as $option ) {

			$sn = $option->form_ref();
			$sn = explode( '[', $sn );
			$sn = $sn[0];

			if ( $option->repeat == false ) {
				$data = $_POST[$sn][0];
			}
			else {
				$data = $_POST[$sn];
			}

			update_post_meta( $post_id, '_tpl_' . $option->name, $data );

		}

	}

}



// Build up a bank of repeater fields in the footer to help repeater fields work faster
function tpl_repeater_bank() {

	global $tpl_options_array;

	$screen = get_current_screen();
	$post_type = str_replace( array( 'appearance_page_', 'settings_page_', 'tpl_', 'toplevel_page_' ), '', $screen->id );

	echo '<div id="tpl_repeater_bank" class="tpl-admin-hide">';

	foreach ( $tpl_options_array as $option ) {

		if ( tpl_has_section_post_type ( $option->section, $post_type ) ) {
			$option->form_field( array( "for_bank" => true ) );
		}

	}

	echo '</div>';

}





/*
SCRIPT HANDLING
*/

// Load the scripts needed in TPL Admin
function tpl_admin_scripts() {

	// Scripts
	wp_enqueue_script( 'jquery-ui-tabs', '', array( 'jquery', 'jquery-ui-core' ) );
	wp_enqueue_script( 'tpl-admin-scripts', tpl_base_uri() . '/framework/script/admin-scripts.min.js', array( 'jquery', 'jquery-ui-tabs' ), TPL_VERSION );

	// Variables to be used in scripts
	wp_localize_script( 'tpl-admin-scripts', 'TPL_Admin', array_merge( apply_filters( 'tpl_admin_js_strings', array() ), tpl_admin_vars_to_js() ) );

	// Styles
	tpl_load_font_awesome();
	wp_enqueue_style( 'tpl-admin-style', tpl_base_uri() . '/framework/style/admin.min.css', array( 'font-awesome' ), TPL_VERSION );

}



// Load Font Awesome fonts and styles
function tpl_load_font_awesome() {

	wp_enqueue_style( 'font-awesome', tpl_base_uri() . '/framework/lib/font-awesome/fonts/font-awesome.min.css', array(), TPL_VERSION );

	$fa_fonts_css = '
		@font-face{font-family:"Font Awesome 5 Free"; font-style:normal; font-weight:900; src:url(' . tpl_base_uri() . '/framework/lib/font-awesome/fonts/fa-solid-900.woff) format("woff")} .fa,.fas{font-family:"Font Awesome 5 Free"; font-weight:900}
		@font-face{font-family:"Font Awesome 5 Free"; font-style:normal; font-weight:400; src:url(' . tpl_base_uri() . '/framework/lib/font-awesome/fonts/fa-regular-400.woff) format("woff")} .far{font-family:"Font Awesome 5 Free"; font-weight:400}
		@font-face{font-family:"Font Awesome 5 Brands"; font-style:normal; font-weight:normal; src:url(' . tpl_base_uri() . '/framework/lib/font-awesome/fonts/fa-brands-400.woff) format("woff")} .fab{font-family:"Font Awesome 5 Brands"}
	';
    wp_add_inline_style( 'font-awesome', $fa_fonts_css );

}



// JS vars, admin version
function tpl_admin_vars_to_js() {

	global $tpl_options_array;
	$to_js = array();

	if ( is_admin() ) {
		$screen		= get_current_screen();
		$post_type	= str_replace( array( 'appearance_page_', 'settings_page_', 'tpl_', 'toplevel_page_' ), '', $screen->id );
	}

	foreach ( $tpl_options_array as $option ) {

		if ( tpl_has_section_post_type ( $option->section, "framework_options" ) ) {

			if ( isset ( $option->js ) && ( $option->js == true ) ) {

				$func_name = $option->js_func;
				$to_js[$option->name] = $option->$func_name();

			}

		}

		// Add the conditional options as they will be used in admin
		if ( $option->get_conditions() !== false ) {

			if ( tpl_has_section_post_type ( $option->section, $post_type ) ) {

				foreach ( $option->get_conditions() as $key => $value ) {

					$to_js["Conditions"][$key] = $value;

				}

			}

		}

	}

	return $to_js;

}





/*
DEALING WITH IMAGE SIZES
*/

// Sets up added image sizes
function tpl_images_setup () {

	$image_sizes = apply_filters( 'tpl_image_sizes', array() );

	// Registering new image sizes
	if ( !empty( $image_sizes ) ) {

		// Add extra image sizes
		foreach ( $image_sizes as $name => $image_size ) {

			add_image_size( $name, $image_size["width"], $image_size["height"], $image_size["crop"] );

		}

	}

}
add_action ( 'after_setup_theme', 'tpl_images_setup', 20 );



// If you defined the "select" attribute of an image size as TRUE in $tpl_image_sizes, this function will add it to the image size selector menu in the post editor
function tpl_image_selector_sizes( $sizes ) {

	$image_sizes = apply_filters( 'tpl_image_sizes', array() );

	$addsizes = array();

	foreach ( $image_sizes as $name => $image_size ) {
		if ( $image_size["select"] == true ) {
			$addsizes[$name] = $image_size["title"];
		}
	}

	$newsizes = array_merge( $sizes, $addsizes );
	return $newsizes;

}
add_filter( 'image_size_names_choose', 'tpl_image_selector_sizes' );
