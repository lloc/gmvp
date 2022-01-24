<?php

namespace Gmvp;

class Plugin {

	public static function init() {
		add_action( 'plugins_loaded', [ __CLASS__, 'init_i18n_support' ] );

		add_shortcode( 'sc_msls_widget', [ __CLASS__, 'block_render' ] );
		add_action( 'widgets_init', [ __CLASS__, 'init_widget' ] );

		if ( function_exists( 'register_block_type' ) ) {
			add_action( 'init', [ __CLASS__, 'block_init' ] );
		}

		return new self();
	}

	public function init_i18n_support() {
		return load_plugin_textdomain( 'gmvp', false, self::dirname( '/languages/' ) );
	}

	public function init_widget() {
		register_widget( Widget::class );
	}

	public function block_init() {
		$handle   = 'gmvp-widget-block';

		wp_register_script(
			$handle,
			self::plugins_url( 'js/example-widget-block.js' ),
			[ 'wp-blocks', 'wp-element', 'wp-components', 'wp-editor' ]
		);

		register_block_type( 'gmvp/example-widget-block', [
			'attributes'      => [ 'title' => [ 'type' => 'string' ] ],
			'editor_script'   => $handle,
			'render_callback' => [ $this, 'block_render' ],
		] );
	}

	public function block_render() {
		ob_start();
		the_widget( Widget::class );
		return ob_get_clean();
	}

	public static function plugins_url( string $path ): string {
		return plugins_url( $path, self::file() );
	}

	public static function dirname( string $path ): string {
		return dirname( self::path() ) . $path;
	}

	public static function file(): string {
		return defined( 'GMVP_PLUGIN__FILE__' ) ? constant( 'GMVP_PLUGIN__FILE__' ) : '';
	}

	public static function path(): string {
		return defined( 'GMVP_PLUGIN_PATH' ) ? constant( 'GMVP_PLUGIN_PATH' ) : '';
	}

}
