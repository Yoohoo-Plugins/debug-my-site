<?php 

/**
*  Code used and altered from Caldera Forms (www.calderaforms.com) - Thanks Josh! (https://profiles.wordpress.org/shelob9/)
*/

defined( 'ABSPATH' ) || exit;

class Debug_My_Site_Core {

	/**
	 * Return an array of plugin names and versions
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function get_plugins() {
		$plugins     = array();
		include_once ABSPATH . '/wp-admin/includes/plugin.php';
		$all_plugins = get_plugins();
		foreach ( $all_plugins as $plugin_file => $plugin_data ) {
			if ( is_plugin_active( $plugin_file ) ) {
				$plugins[ $plugin_data['Name'] ] = $plugin_data['Version'];
			}
		}

		return $plugins;
	}


	/**
	 * Debug Information
	 *
	 * @since 1.0.0
	 *
	 * @param bool $html Optional. Return as HTML or not
	 *
	 * @return string
	 */
	public static function debug_info( $html = true ) {
		global $wp_version, $wpdb, $wp_scripts;
		$wp          = $wp_version;
		$php         = phpversion();
		$mysql       = $wpdb->db_version();
		$plugins = self::get_plugins();
		$stylesheet    = get_stylesheet();
		$theme         = wp_get_theme( $stylesheet );
		$theme_name    = $theme->get( 'Name' );
		$theme_version = $theme->get( 'Version' );
		$opcode_cache  = array(
			'Apc'       => function_exists( 'apc_cache_info' ) ? 'Yes' : 'No',
			'Memcached' => class_exists( 'eaccelerator_put' ) ? 'Yes' : 'No',
			'Redis'     => class_exists( 'xcache_set' ) ? 'Yes' : 'No',
		);
		$object_cache  = array(
			'Apc'       => function_exists( 'apc_cache_info' ) ? 'Yes' : 'No',
			'Apcu'      => function_exists( 'apcu_cache_info' ) ? 'Yes' : 'No',
			'Memcache'  => class_exists( 'Memcache' ) ? 'Yes' : 'No',
			'Memcached' => class_exists( 'Memcached' ) ? 'Yes' : 'No',
			'Redis'     => class_exists( 'Redis' ) ? 'Yes' : 'No',
		);
		$versions      = array(
			'WordPress Version'           => $wp,
			'PHP Version'                 => $php,
			'MySQL Version'               => $mysql,
			'JQuery Version'			  => $wp_scripts->registered['jquery']->ver,
			'Server Software'             => $_SERVER['SERVER_SOFTWARE'],
			'Your User Agent'             => $_SERVER['HTTP_USER_AGENT'],
			'Session Save Path'           => session_save_path(),
			'Session Save Path Exists'    => ( file_exists( session_save_path() ) ? 'Yes' : 'No' ),
			'Session Save Path Writeable' => ( is_writable( session_save_path() ) ? 'Yes' : 'No' ),
			'Session Max Lifetime'        => ini_get( 'session.gc_maxlifetime' ),
			'Opcode Cache'                => $opcode_cache,
			'Object Cache'                => $object_cache,
			'WPDB Prefix'                 => $wpdb->prefix,
			'WP Multisite Mode'           => ( is_multisite() ? 'Yes' : 'No' ),
			'WP Memory Limit'             => WP_MEMORY_LIMIT,
			'Currently Active Theme'      => $theme_name . ': ' . $theme_version,
			'Parent Theme'				  => $theme->template,
			'Currently Active Plugins'    => $plugins,
		);
		if ( $html ) {
			$debug = '';
			foreach ( $versions as $what => $version ) {
				$debug .= '<p><strong>' . $what . '</strong>: ';
				if ( is_array( $version ) ) {
					$debug .= '</p><ul class="ul-disc">';
					foreach ( $version as $what_v => $v ) {
						$debug .= '<li><strong>' . $what_v . '</strong>: ' . $v . '</li>';
					}
					$debug .= '</ul>';
				} else {
					$debug .= $version . '</p>';
				}
			}
			return $debug;
		} else {
			return $versions;
		}
	}

	public static function short_debug_info( $html = true ) {
		global $wp_version, $wpdb;

		$data = array(
			'WordPress Version'     => $wp_version,
			'PHP Version'           => phpversion(),
			'MySQL Version'         => $wpdb->db_version(),
			'WP_DEBUG'              => WP_DEBUG,
		);
		if ( $html ) {
			$html = '';
			foreach ( $data as $what_v => $v ) {
				$html .= '<li style="display: inline;"><strong>' . $what_v . '</strong>: ' . $v . ' </li>';
			}

			return '<ul>' . $html . '</ul>';
		} else {
			return $data;
		}
	}

	public static function build_download_url() {
		return add_query_arg( 'download', 'true', admin_url( 'tools.php?page=debug-my-site-info' ) );
	}

}