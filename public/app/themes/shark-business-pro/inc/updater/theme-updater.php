<?php
/**
 * Theme Updater
 *
 * @package shark_business_pro
 */

// Includes the files needed for the theme updater
if ( !class_exists( 'EDD_Theme_Updater_Admin' ) ) {
	require get_template_directory() . '/inc/updater/theme-updater-admin.php';
}

// Loads the updater classes
$updater = new EDD_Theme_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' => 'http://sharkthemes.com', // Site where EDD is hosted
		'item_name'      => 'Shark Business Pro', // Name of theme
		'theme_slug'     => 'shark-business-pro', // Theme slug
		'version'        => '1.0.2', // The current version of this theme
		'author'         => 'Shark Themes', // The author of this theme
		'download_id'    => '', // Optional, used for generating a license renewal link
		'renew_url'      => 'http://sharkthemes.com/my-account' // Optional, allows for a custom license renewal link
	),

	// Strings
	$strings = array(
		'theme-license'             => __( 'Theme License', 'shark-business-pro' ),
		'enter-key'                 => __( 'Enter your theme license key.', 'shark-business-pro' ),
		'license-key'               => __( 'License Key', 'shark-business-pro' ),
		'license-action'            => __( 'License Action', 'shark-business-pro' ),
		'deactivate-license'        => __( 'Deactivate License', 'shark-business-pro' ),
		'activate-license'          => __( 'Activate License', 'shark-business-pro' ),
		'status-unknown'            => __( 'License status is unknown.', 'shark-business-pro' ),
		'renew'                     => __( 'Renew?', 'shark-business-pro' ),
		'unlimited'                 => __( 'unlimited', 'shark-business-pro' ),
		'license-key-is-active'     => __( 'License key is active.', 'shark-business-pro' ),
		'expires%s'                 => __( 'Expires %s.', 'shark-business-pro' ),
		'%1$s/%2$-sites'            => __( 'You have %1$s / %2$s sites activated.', 'shark-business-pro' ),
		'license-key-expired-%s'    => __( 'License key expired %s.', 'shark-business-pro' ),
		'license-key-expired'       => __( 'License key has expired.', 'shark-business-pro' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'shark-business-pro' ),
		'license-is-inactive'       => __( 'License is inactive.', 'shark-business-pro' ),
		'license-key-is-disabled'   => __( 'License key is disabled.', 'shark-business-pro' ),
		'site-is-inactive'          => __( 'Site is inactive.', 'shark-business-pro' ),
		'license-status-unknown'    => __( 'License status is unknown.', 'shark-business-pro' ),
		'update-notice'             => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'shark-business-pro' ),
		'update-available'          => __('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4$s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'shark-business-pro' )
	)

);
