<?php
/*
* Plugin Name: Debug My Site
* Plugin URI: https://yoohooplugins.com
* Description: Get debug information for your WordPress website.
* Version: 1.0.1
* Author: YooHoo Plugins
* Author URI: https://yoohooplugins.com
* Text Domain: debug-my-site
*
* Debug My Site is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 2 of the License, or
* any later version.
*
* Debug My Site is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with Debug My Site. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/
defined( 'ABSPATH' ) or exit;

class Debug_My_Site{

	private static $instance = null;

	public function __construct(){

		add_action( 'admin_menu', array( $this, 'debug_my_site_add_page' ) );

	}

	public static function get_instance() {

		if ( null == self::$instance ) {
		    self::$instance = new self;
		}

	return self::$instance;

	}

	/**
	* General functions go below
	*/

	public static function debug_my_site_add_page(){
		add_submenu_page( 'tools.php', 'Debug My Site Information', 'Debug My Site', 'manage_options', 'debug-my-site-info', array( 'Debug_My_Site', 'debug_my_site_info_page' ) );
	}

	public static function debug_my_site_info_page(){
		include 'adminpages/debug-my-site-info-page.php';
	}


} //class ends here

Debug_My_Site::get_instance();
