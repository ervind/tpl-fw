<?php

// The file must have the type-[data-type].php filename format


class TPL_Font_Awesome extends TPL_Select {


	public		$key				= true;				// Should return the key (true) or the label (false)?


	// Sets up the object attributes while registering options
	public function __construct( $args ) {

		global $tpl_fa_json, $tpl_fa_icons, $tpl_fa_icons_s2;

		if ( !isset( $tpl_fa_json ) || !isset( $tpl_fa_icons ) || !isset( $tpl_fa_icons_s2 ) ) {

			require_once ABSPATH . "wp-admin/includes/file.php";
			WP_Filesystem();
			global $wp_filesystem;

			$fa_json_file		= tpl_base_dir() . '/framework/lib/font-awesome/icons.json';
			$tpl_fa_json		= json_decode( $wp_filesystem->get_contents( $fa_json_file ), true );
			$$tpl_fa_icons		= array();
			$$tpl_fa_icons_s2	= array();

			foreach ( $tpl_fa_json["icons"] as $icon ) {
				$tpl_fa_icons[$icon["id"]] = array(
					"id"	=> $icon["id"],
					"type"	=> $icon["type"],
					"name"	=> $icon["name"],
				);

				$tpl_fa_icons_s2[$icon["id"]] = '<i class="' . $icon["type"] . ' fa-lg fa-fw fa-' . $icon["id"] . '" data-type="' . $icon["type"] . '"></i> ' . $icon["name"];
			}

		}

		$args["values"] = array_merge( array( '' => __( 'Select an Icon', 'tpl' ) ), $tpl_fa_icons_s2 );

		if ( !isset( $args["admin_class"] ) ) {
			$args["admin_class"] = '';
		}
		$args["admin_class"] .= ' tpl-dt-select';

		parent::__construct( $args );

	}


	// Writes the form field in wp-admin
	public function form_field_content ( $args ) {
		global $tpl_fa_icons;

		parent::form_field_content( $args );

		if ( is_admin() ) {
			$icon_type = '';

			if ( isset( $tpl_fa_icons[$this->get_option()]["type"] ) ) {
				$icon_type = $tpl_fa_icons[$this->get_option()]["type"];
			}

			echo '<input type="hidden" class="tpl-preview-3" value="' . $icon_type . '">';
		}

	}


	// Formats the option into value
	public function format_option ( $id, $args = array() ) {
		global $tpl_fa_icons;

		$result = '';

		if ( isset( $args["url"] ) && $args["url"] != '' ) {
			$result .= '<a href="' . esc_url( $args["url"] ) . '"';

			if ( isset( $args["title"] ) ) {
				$result .= ' title="' . esc_attr( $args["title"] ) . '"';
			}

			if ( isset( $args["newtab"] ) && $args["newtab"] == true ) {
				$result .= ' target="_blank"';
			}

			$result .= '>';
		}

		$result .= '<i class="fa ' . $tpl_fa_icons[$id]["type"] . ' fa-' . esc_attr( $id );

		if ( isset( $args["size"] ) && $args["size"] != '' ) {
			$result .= ' fa-' . esc_attr( $args["size"] );
		}

		if ( isset( $args["class"] ) && $args["class"] != '' ) {
			$result .= ' ' . esc_attr( $args["class"] );
		}

		$result .= '"';

		if ( isset( $args["color"] ) ) {
			$result .= ' style="color: ' . esc_attr( $args["color"] ) . '"';
		}

		$result .= '></i>';

		if ( isset( $args["url"] ) && $args["url"] != '' ) {
			$result .= '</a>';
		}

		return $result;

	}


}
