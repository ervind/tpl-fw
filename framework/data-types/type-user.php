<?php

// The file must have the type-[data-type].php filename format


class TPL_User extends TPL_Select {


	public		$key				= true;				// Should return the key (true) or the label (false)?


	// Sets up the object attributes while registering options
	public function __construct( $args ) {

		$query_args = array();

		if ( isset( $args["role"] ) ) {
			$query_args["role"] = $args["role"];
		}

		if ( isset( $args["max"] ) ) {
			$query_args["number"] = $args["max"];
		}

		$users_query = new WP_User_Query( $query_args );
		$users = $users_query->get_results();

		if ( !empty( $users ) ) {
			foreach ( $users as $user ) {
				$id = $user->ID;
				$userdata = get_userdata( $id );
				$args["values"][$id] = $userdata->first_name . ' ' . mb_strtoupper( $userdata->last_name );
			}
		}

		if ( !isset( $args["admin_class"] ) ) {
			$args["admin_class"] = '';
		}
		$args["admin_class"] .= ' tpl-dt-select';

		parent::__construct( $args );

	}


}
