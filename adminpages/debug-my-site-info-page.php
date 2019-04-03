<?php
defined( 'ABSPATH' ) || exit;
include DEBUG_MY_SITE_PLUGIN_DIR_PATH . 'classes/debug-my-site-core.php';
?>

<div style="display:inline-block;">
	<h1><?php _e( 'Debug My Site' , 'debug-my-site'); ?></h1>
</div>
<div id="debug-my-site-download" style="display:inline-block;">
	<a class="button-primary" href="<?php echo Debug_My_Site_Core::build_download_url(); ?>"><?php _e( 'Download Text Log', 'debug-my-site' ); ?></a>
</div>

<?php do_action( 'dms_before_debug_information' ); ?>

<h2><?php _e( 'Short Debug Information', 'debug-my-site'); ?></h2>
<div id="debug-my-site-short">
	<?php echo Debug_My_Site_Core::short_debug_info(); ?>
</div>
<hr id="debug-my-site-hr"><br>

<h2><?php _e( 'Debug Information', 'debug-my-site' ); ?></h2>
<div id="debug-my-site-long"><?php echo Debug_My_Site_Core::debug_info(); ?></div>

<?php do_action( 'dms_after_debug_information' ); ?>
<br/><hr/>
<small><?php echo sprintf( __( 'Please consider to %s if you have found this plugin useful.', 'debug-my-site' ), "<a href='https://wordpress.org/support/plugin/debug-my-site/reviews/#new-post' target='_blank' rel='nofollow'>" . __( 'leave a review', 'debug-my-site' ) . "</a>" ) . " <strong><em>" . __( 'Delete this plugin when not in use.', 'debug-my-site' ) . "</em></strong>"; ?></small>