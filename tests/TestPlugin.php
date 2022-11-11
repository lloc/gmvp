<?php

namespace GmvpTests;

use Gmvp\Plugin;
use Brain\Monkey\Functions;

class TestPlugin extends Gmvp_UnitTestCase {

	public function test_init() {
		Functions\expect( 'add_shortcode' )->once();

		$obj = Plugin::init();

		$this->assertInstanceOf( Plugin::class, $obj );

		$this->assertEquals( 10, has_action( 'plugins_loaded', [ $obj, 'init_i18n_support' ] ) );
		$this->assertEquals( 10, has_action( 'widgets_init', [ $obj, 'init_widget' ] ) );
		$this->assertEquals( 10, has_action( 'init', [ $obj, 'block_init' ] ) );
	}

	public function test_init_i18n_support() {
		Functions\expect( 'load_plugin_textdomain' )->once()->andReturn( true );

		$obj = new Plugin();

		$this->assertTrue( $obj->init_i18n_support() );
	}

	public function test_helpers() {
		$this->assertEquals( 'abc', Plugin::dirname( 'abc' ) );
		$this->assertEquals( '', Plugin::file() );
		$this->assertEquals( '', Plugin::path() );
	}

	public function test_block_render() {
		$expected = 'Yeah, this is the widget output.';

		Functions\when( 'the_widget' )->justEcho( $expected );

		$this->assertEquals( $expected, ( new Plugin() )->block_render() );
	}

	public function test_block_init_false() {
		$this->assertFalse( ( new Plugin() )->block_init() );
	}

	public function test_block_init_true() {
		Functions\when( 'plugins_url' )->justReturn( 'test/abc' );
		Functions\expect( 'register_block_type' )->once();
		Functions\expect( 'wp_register_script' )->once();

		$this->assertTrue( ( new Plugin() )->block_init() );
	}

}