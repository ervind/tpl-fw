<?php



class TPL_Textarea extends TPL_Text {

	protected	$size			= 8;		// Number of rows in wp-admin


	function form_field_content() {

		$option = $this;
		include TPL_ROOT_DIR . 'inc/templates/option/data-types/textarea-field-content.php';

	}


	function get_admin_classes() {

		$admin_classes = parent::get_admin_classes();

		if ( !in_array( 'tpl-dt-textarea', $admin_classes ) ) {
			$admin_classes[] = 'tpl-dt-textarea';
		}

		return $admin_classes;

	}


	function format_option( $value ) {

		return nl2br( $this->prefix . $value . $this->suffix );

	}


	function value( $post_id = 0 ) {

		if ( $this->is_repeater() ) {

			$values = $this->get_value( $post_id );

			if ( is_array( $values ) ) {
				echo '<ul>';
				foreach ( $values as $value ) {
					echo '<li>' . tpl_kses( $value ) . '</li>';
				}
				echo '</ul>';
				return;
			}

		}

		echo wpautop( tpl_kses( $this->get_value( $post_id ) ) );

	}


	public function editor_switch_buttons() {
	}


}
