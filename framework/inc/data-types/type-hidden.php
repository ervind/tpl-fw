<?php



class TPL_Hidden extends TPL_Option {


	public function form_field_content() {

		$option = $this;
		include TPL_ROOT_DIR . 'inc/templates/option/data-types/hidden-field-content.php';

	}


}
