<?php
/**
 * Gutenberg MVP
 *
 * Plugin Name: Gutenberg MVP
 * Version: 0.0.1
 * Plugin URI: http://motork.io/
 * Description: MVP - Using Gutenberg from a PHP developer's perspective
 * Author: Dennis Ploetner
 * Author URI: http://lloc.de/
 * Text Domain: gmvp
 * Domain Path: /languages/
 * License: GPLv2 or later
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require __DIR__ . '/vendor/autoload.php';
}

define( 'GMVP_PLUGIN_PATH', plugin_basename( __FILE__ ) );
define( 'GMVP_PLUGIN__FILE__', __FILE__ );

Gmvp\Plugin::init();
