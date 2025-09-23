<?php
/**
 * Plugin Name: Usercentrics Privacy Plugin
 * Plugin URI: https://sixfive.io
 * Description: For use with Termageddon + Usercentrics + Google Tag Manager Consent Mode v2
 * Version: 1.0.1
 * Author: SixFive Pty Ltd
 * Author URI: https://sixfive.io
 */


defined( 'ABSPATH' ) || exit;

add_action( 'wp_head', 'sf_wp_head_uc', 9 );
if ( ! function_exists( 'sf_wp_head_uc' ) ) {
	function sf_wp_head_uc() {
		echo '<link rel="preconnect" href="//privacy-proxy.usercentrics.eu"> <link rel="preload" href="//privacy-proxy.usercentrics.eu/latest/uc-block.bundle.js" as="script"> 
<script type="application/javascript" src="https://privacy-proxy.usercentrics.eu/latest/uc-block.bundle.js"></script>
<script>uc.setCustomTranslations("https://termageddon.ams3.cdn.digitaloceanspaces.com/translations/");</script>
<!-- Ignore Blocking for GTM -->
<script>
 uc.deactivateBlocking([
	 "BJ59EidsWQ", // GTM is not blocked
 ]);
</script>';
	}
}
