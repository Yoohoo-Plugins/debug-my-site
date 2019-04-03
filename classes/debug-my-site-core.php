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

		$wp            = $wp_version;
		$php           = phpversion();
		$mysql         = $wpdb->db_version();
		$plugins 	   = self::get_plugins();
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

		$versions = apply_filters( 'dms_debug_info_array_start', array() );

		$versions['WordPress Version']           = $wp;
		$versions['PHP Version']                 = $php;
		$versions['MySQL Version']               = $mysql;
		$versions['JQuery Version']			     = $wp_scripts->registered['jquery']->ver;
		$versions['Server Software']             = $_SERVER['SERVER_SOFTWARE'];
		$versions['Your User Agent']             = $_SERVER['HTTP_USER_AGENT'];
		$versions['Session Save Path']           = session_save_path();
		$versions['Session Save Path Exists']    = ( file_exists( session_save_path() ) ? 'Yes' : 'No' );
		$versions['Session Save Path Writeable'] = ( is_writable( session_save_path() ) ? 'Yes' : 'No' );
		$versions['Session Max Lifetime']        = ini_get( 'session.gc_maxlifetime' );
		$versions['Opcode Cache']                = $opcode_cache;
		$versions['Object Cache']                = $object_cache;
		$versions['WPDB Prefix']                 = $wpdb->prefix;
		$versions['WP Multisite Mode']           = ( is_multisite() ? 'Yes' : 'No' );
		$versions['WP Memory Limit']             = WP_MEMORY_LIMIT;
		$versions['Currently Active Theme']      = $theme_name . ': ' . $theme_version;
		$versions['Parent Theme']				 = $theme->template;
		$versions['Currently Active Plugins']    = $plugins;

		$versions = apply_filters( 'dms_debug_info_array', $versions );

		if ( $html ) {
			// String to generate debug log information.
			$debug = '';
			foreach ( $versions as $what => $version ) {
				$debug .= '<p><strong>' . esc_attr( $what ) . '</strong>: ';
				if ( is_array( $version ) ) {
					$debug .= '</p><ul class="ul-disc">';
					foreach ( $version as $what_v => $v ) {
						$debug .= '<li><strong>' . esc_attr( $what_v ) . '</strong>: ' . esc_attr( $v ) . '</li>';
					}
					$debug .= '</ul>';
				} else {
					$debug .= esc_attr( $version ) . '</p>';
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