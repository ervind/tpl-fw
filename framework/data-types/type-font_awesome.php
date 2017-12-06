<?php

// The file must have the type-[data-type].php filename format


class TPL_Font_Awesome extends TPL_Select {


	public		$key				= true;				// Should return the key (true) or the label (false)?


	// Sets up the object attributes while registering options
	public function __construct( $args ) {

		global $tpl_fa_json;

		if ( !isset( $tpl_fa_json ) ) {

			require_once ABSPATH . "wp-admin/includes/file.php";
			WP_Filesystem();
			global $wp_filesystem;

			$fa_json_file = tpl_base_dir() . '/framework/lib/font-awesome/icons.json';
			$tpl_fa_json = json_decode( $wp_filesystem->get_contents( $fa_json_file ), true );

		}

		foreach ( $tpl_fa_json["icons"] as $icon ) {
			$fa_icons[$icon["id"]] = $icon["name"];
		}

		$args["values"] = array_merge( array( '' => __( 'Select an Icon', 'tpl' ) ), $fa_icons );

		if ( !isset( $args["admin_class"] ) ) {
			$args["admin_class"] = '';
		}
		$args["admin_class"] .= ' tpl-dt-select';

		parent::__construct( $args );

	}


	// Formats the option into value
	public function format_option ( $id, $args = array() ) {

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

		$result .= '<i class="fa fa-' . esc_attr( $id );

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
