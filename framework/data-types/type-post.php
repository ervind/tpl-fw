<?php

// The file must have the type-[data-type].php filename format


class TPL_Post extends TPL_Select {


	public		$key				= true;				// Should return the key (true) or the label (false)?


	// Sets up the object attributes while registering options
	public function __construct( $args ) {

		$query_args = array();

		if ( isset( $args["post_type"] ) ) {
			$query_args["post_type"] = $args["post_type"];
		}

		if ( isset( $args["max"] ) ) {
			$query_args["posts_per_page"] = $args["max"];
		}

		$posts = new WP_Query( $query_args );

		if ( $posts->have_posts() ) {
			while ( $posts->have_posts() ) {
				$posts->the_post();
				$id = get_the_ID();
				$args["values"][$id] = get_the_title();
			}
			wp_reset_postdata();
		}

		if ( !isset( $args["admin_class"] ) ) {
			$args["admin_class"] = '';
		}
		$args["admin_class"] .= ' tpl-dt-select';

		parent::__construct( $args );

	}


}
