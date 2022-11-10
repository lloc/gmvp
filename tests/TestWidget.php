<?php

namespace GmvpTests;

use Gmvp\Widget;
use Brain\Monkey\Functions;

class TestWidget extends Gmvp_UnitTestCase {

	protected $sut;

	public function setUp(): void {
		parent::setUp();

		\Mockery::mock( '\WP_Widget' );

		$this->sut = \Mockery::mock( Widget::class )->makePartial();
		$this->sut->shouldReceive( 'get_field_id' )->andReturn( 'widget-gmvpwidget-0-title' );
		$this->sut->shouldReceive( 'get_field_name' )->andReturn( 'widget-gmvpwidget[0][title]' );
	}

	public function test_widget() {
		$expected = "<div><h3>test-title</h3>Good news, everyone! There's a report on TV with some very bad news!</div>";
		$arr = [
			'before_widget' => '<div>',
			'after_widget'  => '</div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		];

		Functions\expect( 'wp_parse_args' )->once()->andReturn( $arr );

		$this->expectOutputString( $expected );
		$this->sut->widget( [], [ 'title' => 'test-title' ] );
	}

	public function test_update() {
		$result = $this->sut->update( [], [] );
		$this->assertEquals( [], $result );

		$result = $this->sut->update( [ 'title' => 'abc' ], [] );
		$this->assertEquals( [ 'title' => 'abc' ], $result );

		$result = $this->sut->update( [ 'title' => 'xyz' ], [ 'title' => 'abc' ] );
		$this->assertEquals( [ 'title' => 'xyz' ], $result );
	}

	public function test_form() {
		$expected = '<p><label for="widget-gmvpwidget-0-title">Title:</label> <input class="widefat" id="widget-gmvpwidget-0-title" name="widget-gmvpwidget[0][title]" type="text" value="test-title" /></p>';

		$this->expectOutputString( $expected );
		$this->assertEquals( 'gmvpwidget', $this->sut->form( [ 'title' => 'test-title' ] ) );
	}
}