<?php



class TPL_Font_Awesome extends TPL_Select {


	function __construct( $args ) {
		global $tpl_fa_icons, $tpl_fw;

		if ( !isset( $tpl_fa_icons ) ) {

			require_once ABSPATH . "wp-admin/includes/file.php";
			WP_Filesystem();
			global $wp_filesystem;

			$tpl_fa_json = json_decode( $wp_filesystem->get_contents( TPL_ROOT_DIR . 'lib/font-awesome/icons.json' ), true );
			$tpl_fa_icons = [];

			foreach ( $tpl_fa_json["icons"] as $icon ) {
				$tpl_fa_icons[$icon["key"]] = $icon;
			}

		}

		if ( !is_admin() ) {
			add_action( 'wp_enqueue_scripts', [ $tpl_fw, 'load_font_awesome' ], 20 );
		}

		parent::__construct( $args );

	}


	function initialize() {

		parent::initialize();

		$this->set_selectable_values( [] );

	}


	function form_field_content() {

		parent::form_field_content();

		echo '<span class="tpl-admin-hide" data-preview="3">' . $this->get_icon_type() . '</span>';

	}


	function get_icon_type() {
		global $tpl_fa_icons;

		$icon_type = '';

		if ( isset( $tpl_fa_icons[$this->get_single_option_by_path()]["type"] ) ) {
			$icon_type = $tpl_fa_icons[$this->get_single_option_by_path()]["type"];
		}

		return $icon_type;

	}


	function form_default_value() {
		global $tpl_fa_icons;

		if ( $this->get_default() == '' ) {
			return '';
		}

		return sprintf( __( '(default: %1$s %2$s)', 'tpl' ), $this->format_option( $this->get_default() ), $tpl_fa_icons[$this->get_default()]["name"] );

	}


	function set_selectable_values( $values ) {
		global $tpl_fa_icons;

		$fa_icons_select2 = [];

		foreach ( $tpl_fa_icons as $icon ) {
			$fa_icons_select2[$icon["key"]] = '<i class="' . $icon["type"] . ' fa-lg fa-fw fa-' . $icon["id"] . '" data-type="' . $icon["type"] . '"></i> ' . $icon["name"];
		}

		$this->values = $fa_icons_select2;

	}


	function format_option( $value ) {
		global $tpl_fa_icons;

		if ( isset( $tpl_fa_icons[$value] ) ) {
			return '<i class="' . esc_attr( $tpl_fa_icons[$value]["type"] ) . ' fa-' . esc_attr( $tpl_fa_icons[$value]["id"] ) . '"></i>';
		}

		return '';

	}


	function admin_js_strings( $strings ) {
		global $tpl_fa_icons;

		$strings = array_merge( $strings, [
			'tpl-dt-font_awesome_preview-template'	=> '[tpl-preview-1]',
		] );

		return $strings;

	}


}
