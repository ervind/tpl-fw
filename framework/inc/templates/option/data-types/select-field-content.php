<div class="tpl-datatype-container">

	<?php $option->form_field_prefix(); ?>

	<select <?php $option->print_form_ref(); ?>
		data-preview="1"
		autocomplete="off">

		<?php $option->list_selectable_values(); ?>

	</select>

	<?php $option->form_field_suffix(); ?>

</div>
