<?php

namespace GmvpTests;

use PHPUnit\Framework\TestCase;
use Brain\Monkey;
use Brain\Monkey\Functions;

class Gmvp_UnitTestCase extends TestCase {

	protected function setUp(): void {
		parent::setUp();
		Monkey\setUp();

		Functions\when( 'plugins_url' )->justReturn( 'test/abc' );
		Functions\when( 'esc_attr' )->returnArg();
		Functions\when( '__' )->returnArg();

	}

	protected function tearDown(): void {
		Monkey\tearDown();
		parent::tearDown();
	}

}
