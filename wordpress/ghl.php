<?php
/**
 * Plugin Name: GHL script
 * Plugin URI: https://sixfive.io
 * Description:
 * Version: 1.0
 * Author: SixFive Pty Ltd
 * Author URI: https://sixfive.io
 */


defined( 'ABSPATH' ) || exit;

add_action( 'wp_footer', 'sf_mu_wp_footer_ghl' );
function sf_mu_wp_footer_ghl() {
	echo "<script>updateIframeParameter();
function updateIframeParameter() {
    let iframes = document.getElementsByTagName('iframe'),// Find ALL iframe elements on the page
        params = window.location.search,// Get the query parameters from the current page's URL
        i;
    // Check if any iframes were found
    if (iframes.length === 0) {
        return; // Exit if no iframes
    }

    for (const iframe of iframes) {// Loop through each iframe found
        const originalIframeSrc = iframe.src;// Get the iframe's original src
        // Skip if the iframe has no src initially (might be set later by other scripts)
        if (!originalIframeSrc) {
            return; // Continue to the next iframe in the loop
        }
        let newIframeSrc,
            pardot = originalIframeSrc.indexOf('https://app.', originalIframeSrc),
            pardot2 = originalIframeSrc.indexOf('https://api.', originalIframeSrc);
        const paramsToAppend = params.substring(1); // Remove leading '?'
        if (pardot === 0 || pardot2 === 0) {
            if (originalIframeSrc.includes('?')) {
                newIframeSrc = originalIframeSrc + '&' + paramsToAppend;
            } else {
                // If no, append the new params with the original '?' from parentUrlParams
                newIframeSrc = originalIframeSrc + params; // Use the full string including '?'
            }
            iframe.src = newIframeSrc;// Update the iframe's src attribute
        }
    }
}</script>";
}
