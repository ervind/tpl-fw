<?php



class TPL_Post extends TPL_Select {


	function initialize() {

		parent::initialize();

		$this->set_selectable_values( [] );

	}


	function set_selectable_values( $values ) {

		$query_args = [];

		if ( isset( $this->args["post_type"] ) ) {
			$query_args["post_type"] = $this->args["post_type"];
		}

		if ( isset( $this->args["max"] ) ) {
			$query_args["posts_per_page"] = $this->args["max"];
		}
		else {
			$query_args["posts_per_page"] = -1;
		}

		$posts = get_posts( $query_args );

		if ( $posts ) {
			foreach ( $posts as $post ) {
				$this->values[$post->ID] = '(' . $post->ID . ') ' . wp_strip_all_tags( get_the_title( $post->ID ) );
			}
		}

	}


}
