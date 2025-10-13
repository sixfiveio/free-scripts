<?php
/**
 * Plugin Name: Pass in all URL params to any CRM iframe
 * Plugin URI: https://sixfive.io
 * Description: Passes in all URL params to any CRM iframe. Solves the issue that forms in iframes provided by CRMs like GoHighLevel, Hubspot and Salesforce Pardot cannot see params like gclid, fbid, or UTMs and thus conversion tracking of paid ads can seem impossible. 
 * Version: 1.1
 * Author: SixFive Pty Ltd
 * Author URI: https://sixfive.io
 */


defined( 'ABSPATH' ) || exit;

add_action( 'wp_footer', 'sf_mu_wp_footer_ghl' );
function sf_mu_wp_footer_ghl() {
	echo "<script>updateIframeParameter();
function updateIframeParameter() {

    // The iframe's src must START with one of these.
    const allowedPrefixes = [
        'https://app.',
        'https://api.'
        // Add more prefixes here (e.g., 'https://webinar.').
    ];

	// DO NOT alter after this line

    const iframes = document.getElementsByTagName('iframe'); // Find ALL iframe elements on the page
    const params = window.location.search; // Get the query parameters from the current page's URL
    
    // Check if any iframes were found or if there are no parameters to append
    if (iframes.length === 0 || !params) {
        return; 
    }

    const paramsToAppend = params.substring(1); // Remove leading '?' from parameters

    for (const iframe of iframes) { // Loop through each iframe found
        const originalIframeSrc = iframe.src; // Get the iframe's original src
        
        // Skip if the iframe has no src initially
        if (!originalIframeSrc) {
            continue; // Move to the next iframe
        }

        // Check if the originalIframeSrc starts with any of the allowed prefixes
        const isAllowedUrl = allowedPrefixes.some(prefix => 
            originalIframeSrc.startsWith(prefix)
        );

        if (isAllowedUrl) {
            let newIframeSrc;
            
            // Determine how to append the parameters
            if (originalIframeSrc.includes('?')) {
                // If the src already has parameters, append with '&'
                newIframeSrc = originalIframeSrc + '&' + paramsToAppend;
            } else {
                // If no existing parameters, append with '?' (using the full 'params' string)
                newIframeSrc = originalIframeSrc + params; 
            }
            
            iframe.src = newIframeSrc; // Update the iframe's src attribute
        }
    }
}</script>";
}
