<?php // Testing demo fields in the front end



function tpl_all_demos_shortcode() {
	global $tpl_fw, $post;

	$sections = $tpl_fw->get_sections();

	ob_start();

	foreach ( $sections as $section ) {

		if ( strpos( $section->get_name(), 'demos' ) ) { ?>
			<h3><?php echo $section->get_title(); ?></h3>
			<?php

			$options = $section->get_options();

			foreach ( $options as $option ) {
				if ( !$section->is_primary() && $post ) {
					$option->set_post( $post );
				}
				?>
				<p>
					<strong><?php printf( '"%s" raw value:', $option->get_title() ); ?></strong> <?php var_dump( $option->get_option() ); ?><br>
					<strong><?php printf( '"%s" formatted value:', $option->get_title() ); ?></strong> <?php var_dump( $option->get_value() ); ?><br>
					<strong><?php printf( '"%s" print value:', $option->get_title() ); ?></strong> <?php $option->value(); ?>
				</p>
				<hr>
			<?php }

		}


	}

	return ob_get_clean();

}
add_shortcode( 'tpl-all-demos', 'tpl_all_demos_shortcode' );
