<?php
/**
 * Plugin Name: Pass URL params to CRM forms and funnel links
 * Plugin URI: https://github.com/sixfiveio/free-scripts/tree/main/wordpress/crm
 * Description: Carries the visitor's landing URL parameters (gclid, fbclid, UTMs and any others) into embedded CRM form iframes and onto links to your funnel pages, so paid ad leads keep their attribution. Works with GoHighLevel, HubSpot, Salesforce Pardot and any CRM that embeds forms in an iframe.
 * Version: 2.0
 * Author: SixFive Pty Ltd
 * Author URI: https://sixfive.io
 * License: MIT
 */

defined( 'ABSPATH' ) || exit;

/*
 * Configuration. Edit these, or set them from another plugin or your theme
 * with the filters named below, so an update to this file doesn't undo them.
 */

// Iframes whose src STARTS with one of these get the parameters.
// Filter: sf_passthrough_iframe_prefixes
function sf_passthrough_iframe_prefixes() {
	return apply_filters( 'sf_passthrough_iframe_prefixes', array(
		'https://app.',
		'https://api.',
		'https://link.',
		// Add more here, e.g. 'https://forms.mycrm.com/'.
	) );
}

// Links whose href STARTS with one of these get the parameters.
// Filter: sf_passthrough_link_prefixes
function sf_passthrough_link_prefixes() {
	return apply_filters( 'sf_passthrough_link_prefixes', array(
		'https://go.',
		'https://link.',
		// Add your funnel or booking domains here, e.g. 'https://offers.example.com/'.
	) );
}

// Parameters never passed on: WordPress's own.
// Filter: sf_passthrough_skip_params
function sf_passthrough_skip_params() {
	return apply_filters( 'sf_passthrough_skip_params', array(
		'p', 'page_id', 'post_type', 's', 'preview', 'preview_id', 'preview_nonce',
		'replytocom', 'amp', 'doing_wp_cron', 'elementor-preview', 'ver',
	) );
}

// DO NOT alter after this line.

add_action( 'wp_footer', 'sf_mu_wp_footer_ghl', 99 );
function sf_mu_wp_footer_ghl() {
	$config = array(
		'iframes' => array_values( sf_passthrough_iframe_prefixes() ),
		'links'   => array_values( sf_passthrough_link_prefixes() ),
		'skip'    => array_map( 'strtolower', array_values( sf_passthrough_skip_params() ) ),
	);
	?>
<script>
(function (config) {
	/*
	 * Capture: every parameter on the landing URL except WordPress's own.
	 * Kept for this visit only (sessionStorage), so a reader who moves to a
	 * second page before clicking still carries them. A later landing with
	 * parameters replaces the set; a page with none never blanks it.
	 */
	var KEY = 'sf_passthrough';
	var params = [];
	new URLSearchParams(window.location.search).forEach(function (value, key) {
		if (config.skip.indexOf(key.toLowerCase()) === -1 && value !== '') params.push([key, value]);
	});
	try {
		if (params.length) sessionStorage.setItem(KEY, JSON.stringify(params));
		else params = JSON.parse(sessionStorage.getItem(KEY) || '[]');
	} catch (e) { /* storage blocked: use this page's own URL only */ }
	if (!params.length) return;

	function starts(value, prefixes) {
		for (var i = 0; i < prefixes.length; i++) if (value.indexOf(prefixes[i]) === 0) return true;
		return false;
	}

	// Incoming values replace same-named ones already on the URL (no
	// duplicates), and every other parameter on it is kept, hash included.
	function withParams(raw) {
		var url;
		try { url = new URL(raw, window.location.href); } catch (e) { return raw; }
		params.forEach(function (p) { url.searchParams.set(p[0], p[1]); });
		return url.toString();
	}

	function doIframe(frame) {
		var src = frame.getAttribute('src');
		if (!src || frame.getAttribute('data-sf-passthrough') || !starts(src, config.iframes)) return;
		frame.setAttribute('data-sf-passthrough', '1');
		var next = withParams(src);
		if (next !== src) frame.setAttribute('src', next);
	}

	function doLink(a) {
		var href = a.getAttribute('href');
		if (!href || !starts(a.href, config.links)) return;
		var next = withParams(a.href);
		if (next !== a.href) a.href = next;
	}

	function scan(root) {
		if (!root.querySelectorAll) return;
		if (root.tagName === 'IFRAME') doIframe(root);
		if (root.tagName === 'A') doLink(root);
		var frames = root.querySelectorAll('iframe[src]');
		for (var i = 0; i < frames.length; i++) doIframe(frames[i]);
		var links = root.querySelectorAll('a[href]');
		for (var j = 0; j < links.length; j++) doLink(links[j]);
	}

	scan(document);

	// Forms and CTAs that load later (lazy embeds, popups), and lazy-loaders
	// that swap an iframe's src in after the page has loaded.
	if (window.MutationObserver) {
		new MutationObserver(function (changes) {
			changes.forEach(function (c) {
				if (c.type === 'attributes') { doIframe(c.target); return; }
				for (var i = 0; i < c.addedNodes.length; i++) scan(c.addedNodes[i]);
			});
		}).observe(document.body, { childList: true, subtree: true, attributes: true, attributeFilter: ['src'] });
	}

	// Links rewritten by something else after load: fix at the moment of
	// click. pointerdown covers left, middle and right click; focusin covers
	// keyboard users.
	function onInteract(e) {
		var a = e.target && e.target.closest ? e.target.closest('a[href]') : null;
		if (a) doLink(a);
	}
	document.addEventListener('pointerdown', onInteract, true);
	document.addEventListener('focusin', onInteract, true);
})(<?php echo wp_json_encode( $config ); ?>);
</script>
	<?php
}
