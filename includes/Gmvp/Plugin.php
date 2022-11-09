<?php

namespace Gmvp;

class Plugin {

	/**
	 * @return Plugin
	 */
	public static function init(): Plugin {
		add_action( 'plugins_loaded', [ __CLASS__, 'init_i18n_support' ] );
		add_action( 'widgets_init', [ __CLASS__, 'init_widget' ] );
		add_action( 'init', [ __CLASS__, 'block_init' ] );

		add_shortcode( 'sc_msls_widget', [ __CLASS__, 'block_render' ] );

		return new self();
	}

	/**
	 * @return bool
	 */
	public function init_i18n_support(): bool {
		return load_plugin_textdomain( 'gmvp', false, self::dirname( '/languages/' ) );
	}

	/**
	 * @codeCoverageIgnore
	 *
	 * @return void
	 */
	public function init_widget(): void {
		register_widget( Widget::class );
	}

	/**
	 * @return bool
	 */
	public function block_init(): bool {
		if ( ! function_exists( 'register_block_type' ) ) {
			return false;
		}

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

		return true;
	}

	/**
	 * @return string
	 */
	public function block_render(): string {
		ob_start();
		the_widget( Widget::class );
		return ob_get_clean();
	}

	/**
	 * @param string $path
	 *
	 * @return string
	 */
	public static function plugins_url( string $path ): string {
		return plugins_url( $path, self::file() );
	}

	/**
	 * @param string $path
	 *
	 * @return string
	 */
	public static function dirname( string $path ): string {
		return dirname( self::path() ) . $path;
	}

	/**
	 * @return string
	 */
	public static function file(): string {
		return defined( 'GMVP_PLUGIN__FILE__' ) ? constant( 'GMVP_PLUGIN__FILE__' ) : '';
	}

	/**
	 * @return string
	 */
	public static function path(): string {
		return defined( 'GMVP_PLUGIN_PATH' ) ? constant( 'GMVP_PLUGIN_PATH' ) : '';
	}

}
