<?php
defined( 'ABSPATH' ) || exit;
include DEBUG_MY_SITE_PLUGIN_DIR_PATH . 'classes/debug-my-site-core.php';
?>

<h1><?php _e( 'Debug My Site' , 'debug-my-site'); ?></h1><br>

<h2><?php _e( 'Short Debug Information', 'debug-my-site'); ?></h2>
<div id="debug-my-site-short"><?php echo Debug_My_Site_Core::short_debug_info(); ?></div>
<hr id="debug-my-site-hr"><br>
<h2><?php _e( 'Debug Information', 'debug-my-site' ); ?></h2>
<div id="debug-my-site-long"><?php echo Debug_My_Site_Core::debug_info(); ?></div>

<h2><?php _e( 'Download site info', 'debug-my-site' ); ?></h2>
<div id="debug-my-site-download"><a href="<?php echo Debug_My_Site_Core::build_download_url(); ?>">Download</a></div>




