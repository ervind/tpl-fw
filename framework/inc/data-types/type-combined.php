<?php



class TPL_Combined extends TPL_Option {

	public		$default		= [ 0 => '' ];
	public		$parts			= [];


	function __construct( $args ) {

		parent::__construct( $args );

		$this->setup_parts();

	}


	function setup_parts() {

		if ( !empty( $this->args["parts"] ) ) {

			foreach ( $this->args["parts"] as $part_args ) {
				$part_class = TPL_FW()->generate_data_type_class_name_from_slug( $part_args["type"] );
				$part_args["section"] = $this->args["section"];
				$this->parts[$part_args["name"]] = new $part_class( $part_args );

				if ( is_array( $this->default ) && isset( $this->default[$part_args["name"]] ) ) {
					$this->parts[$part_args["name"]]->set_default( $this->default[$part_args["name"]] );
				}

			}

			$this->set_parts_path();

		}

	}


	function set_parts_path() {

		foreach ( $this->parts as $part ) {
			$part->set_path( [
				0	=> $this->get_name(),
				1	=> $this->get_current_instance(),
				2	=> $part->get_name(),
			] );
		}

	}


	function set_parts_post() {

		foreach ( $this->parts as $part ) {
			$part->set_post( $this->post );
		}

	}


	function get_parts() {

		return $this->parts;

	}


	function get_admin_classes() {

		$admin_classes = parent::get_admin_classes();

		if ( !in_array( 'tpl-dt-combined', $admin_classes ) ) {
			$admin_classes[] = 'tpl-dt-combined';
		}

		return $admin_classes;

	}


	function form_field_content() {

		$this->set_parts_post();
		$this->set_parts_path();

		$option = $this;
		include TPL_ROOT_DIR . 'inc/templates/option/data-types/combined-field-content.php';

	}


	function form_default_value() {

		return '';

	}


	function get_single_option_by_path() {

		$this->set_parts_post();

		$values = [];

		foreach ( $this->get_parts() as $part ) {
			$values[$this->get_current_instance()][$part->get_name()] = $part->get_single_option_by_path();
		}

		return $values;

	}


	function get_value() {

		$values = [];
		$option = $this->get_option();
		$this->set_parts_post();

		if ( !empty( $option ) ) {

			foreach ( $option as $instance => $row ) {
				$this->path[1] = $instance;
				foreach ( $this->get_parts() as $part ) {
					$part->path[1] = $this->path[1];
					$values[$instance][$part->get_name()] = $part->format_option( $part->get_single_option_by_path() );
				}
			}

		}

		return $values;

	}


	function value() {

		$values = $this->get_value();

		if ( is_array( $values ) ) { ?>
			<ul>
				<?php
				if ( $this->is_repeater() ) {
					foreach ( $values as $row ) { ?>
						<li>
							<ul>
								<?php foreach ( $row as $value ) { ?>
									<li><?php echo $value; ?></li>
								<?php } ?>
							</ul>
						</li>
					<?php }
				}
				else {
					foreach ( $values[0] as $value ) { ?>
						<li><?php echo $value; ?></li>
					<?php }
				} ?>
			</ul>
		<?php }

	}


	function get_object() {

		return $this;

	}


	function get_conditions() {

		$conditions = [];

		if ( isset( $this->conditions ) ) {
			$conditions[$this->get_multi_level_name()] = $this->conditions;
		}

		foreach ( $this->get_parts() as $part ) {
			if ( $part->get_conditions() ) {
				$conditions[$part->get_multi_level_name()] = $part->get_conditions()[$part->get_multi_level_name()];
			}
		}

		if ( !empty( $conditions ) ) {
			return $conditions;
		}

		return false;

	}


}
