<div id="tpl_repeater_bank" class="tpl-admin-hide">

<?php foreach ( $options as $option ) {
	if ( $option->is_repeater() ) {
		$option->bank_form_field();
	}
} ?>

</div>
