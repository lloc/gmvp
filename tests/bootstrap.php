<?php

namespace GmvpTests;

use PHPUnit\Framework\TestCase;
use Brain\Monkey;

class Gmvp_UnitTestCase extends TestCase {

	protected function setUp(): void {
		parent::setUp();
		Monkey\setUp();
	}

	protected function tearDown(): void {
		Monkey\tearDown();
		parent::tearDown();
	}

}
