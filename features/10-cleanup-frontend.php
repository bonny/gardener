<?php

/**
 * Cleanup <head> by removing lots of things
 */
namespace EP\frontend\cleanup;

add_action("init", function () {
    remove_filter("wp_head", "wp_generator");
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'index_rel_link'); // index link
    remove_action('wp_head', 'parent_post_rel_link', 10, 0); // prev link
    remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    remove_action('wp_head', 'rel_canonical');
    add_filter("show_recent_comments_widget_style", "__return_false");

    /**
     * Removes Yoast SEO comment in head
     */
    if (
        isset($GLOBALS['wpseo_front']) &&
        is_a($GLOBALS['wpseo_front'], "WPSEO_Frontend")
    ) {
        remove_action(
            'wpseo_head',
            array($GLOBALS['wpseo_front'], 'debug_marker'),
            2
        );
    }

    /**
     * Removes the sitepress/wpml generator tag from head
     */
    global $sitepress;
    if (isset($sitepress) && is_object($sitepress)) {
        remove_filter("wp_head", array($sitepress, "meta_generator_tag"));

        // Don't load css for wpml
        define("ICL_DONT_LOAD_LANGUAGE_SELECTOR_CSS", true);
    }
});

/**
 * Remove x pingback from headers
 */
add_filter('wp_headers', function ($headers) {
    unset($headers['X-Pingback']);
    return $headers;
});
