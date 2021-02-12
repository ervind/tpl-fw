<tr class="<?php echo $class; ?>">
	<th scope="row" class="tpl-primary-label">
		<?php if ( !empty( $field["args"]["label_for"] ) ) { ?>
			<label for="<?php echo esc_attr( $field["args"]["label_for"] ); ?>"><?php echo $field["title"]; ?></label>
		<?php } else { ?>
			<?php echo $field["title"];
		} ?>
		<div class="tpl-option-desc">
			<?php echo tpl_kses( $option->get_description() ); ?>
		</div>
	</th>
	<td>
		<?php call_user_func( $field["callback"], $field["args"] ); ?>
	</td>
</tr>
