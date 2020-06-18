<?php



class TPL_User extends TPL_Select {


	function initialize() {

		parent::initialize();

		$this->set_selectable_values( [] );

	}


	function set_selectable_values( $values ) {

		$query_args = [];

		if ( isset( $this->args["role"] ) ) {
			$query_args["role"] = $this->args["role"];
		}

		if ( isset( $this->args["max"] ) ) {
			$query_args["number"] = $this->args["max"];
		}

		$users = get_users( $query_args );

		if ( !empty( $users ) ) {
			foreach ( $users as $user ) {
				$this->values[$user->ID] = get_user_meta( $user->ID, 'first_name', true ) . ' ' . mb_strtoupper( get_user_meta( $user->ID, 'last_name', true ) );
			}
		}

	}


}
