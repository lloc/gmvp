<?php

namespace Gmvp;

class Widget extends \WP_Widget {

	public $id_base = 'gmvpwidget';
	public $name    = 'Gutenberg MVP';

	/**
	 * Constructor
	 *
	 * @codeCoverageIgnore
	 */
	public function __construct() {
		parent::__construct( $this->id_base, $this->name );
	}

	/**
	 * Output of the widget in the frontend
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		$args = wp_parse_args(
			$args,
			[
				'before_widget' => '',
				'after_widget'  => '',
				'before_title'  => '',
				'after_title'   => '',
			]
		);

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $instance['title'] ?? '', $instance, $this->id_base );
		if ( $title ) {
			$title = $args['before_title'] . esc_attr( $title ) . $args['after_title'];
		}

		$content = __( "Good news, everyone! There's a report on TV with some very bad news!", 'gmvp' );

		echo $args['before_widget'], $title, $content, $args['after_widget'];
	}

	/**
	 * Update widget in the backend
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		if ( isset( $new_instance['title'] ) ) {
			$instance['title'] = strip_tags( $new_instance['title'] );
		}

		return $instance;
	}

	/**
	 * Display an input-form in the backend
	 *
	 * @param array $instance
	 *
	 * @return string
	 */
	public function form( $instance ): string {
		printf(
			'<p><label for="%1$s">%2$s:</label> <input class="widefat" id="%1$s" name="%3$s" type="text" value="%4$s" /></p>',
			$this->get_field_id( 'title' ),
			__( 'Title', 'gmvp' ),
			$this->get_field_name( 'title' ),
			( isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '' )
		);

		return $this->id_base;
	}

}
