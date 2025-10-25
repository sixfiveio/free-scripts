<?php 
/*
 * Plugin Name: Patch Yoast SEO Bug with Fortress's per-capability session timeouts.
 * Plugin URI: https://sixfive.io
 * Description: This snippet needs to be added as a must-use plugin to patch a bug in Yoast SEO, when Fortress Security is installed.  
 * Version: 1.0.1
 * Author: SixFive
 * Author URI: https://sixfive.io
 */

/**
 * Yoast adds the {@see WPSEO_Register_Capabilities::map_meta_cap_for_seo_manager()} filter
 * before the current user has determined, however, that callback relies on a call to {@see wp_get_current_user}
 * which will cause an infinite loop if any plugin/theme/custom-code uses {@see user_can()} during the creation of the
 * user session in order to determine per-user configurations of sessions.
 *
 * The correct hook to add the callback would probably be the {@see set_current_user} hook, otherwise
 * the callback to {@see WPSEO_Register_Capabilities::map_meta_cap_for_seo_manager()} also always receives the user id
 * which means it would actually also work if {@see user_can()} is called on a user that's not the currently logged in
 * one, which is pretty common as well.
 *
 * https://community.gridpane.com/t/yoast-seo-bug-conflics-with-per-capability-session-timeouts-third-party-issue/3898/1
 *
 */
add_action('plugin_loaded', function (string $plugin_slug) {
    if ( ! str_contains($plugin_slug, 'wordpress-seo')) {
        return;
    }
    
    $filter = $GLOBALS['wp_filter']['map_meta_cap'] ?? null;
    
    if (null === $filter) {
        return;
    }
    
    $callbacks_at_priority_10 = $filter->callbacks[10] ?? [];
    
    foreach (array_keys($callbacks_at_priority_10) as $function) {
        if (str_contains($function, 'map_meta_cap_for_seo_manager')) {
            $hook = $callbacks_at_priority_10[$function]['function'] ?? null;
            
            if (null === $hook) {
                return;
            }
            
            remove_filter('map_meta_cap', $hook);
            
            add_action('set_current_user', function () use ($hook) {
                add_filter('map_meta_cap', $hook, 10, 2);
            });
            
            return;
        }
    }
});
