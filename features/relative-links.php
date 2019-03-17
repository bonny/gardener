<?php

/*
 * Makes links and images added in Gutenberg och TinyMCE use relative paths, instead of absolute.
 *
 * This is a benefit when developing a website on several domains, so you don't have to change all
 * links from http://beta.example.com/ to http://example.com/.
 */

namespace Gardener;

add_filter(
    'rest_request_before_callbacks',
    __NAMESPACE__ . '\onRestRequestBeforeCallbacks',
    10,
    3
);

/**
 * Make permalinks from WP REST API search calls relative.
 * Called from filter.
 */
function onRestRequestBeforeCallbacks($response, $handler, $request)
{
    // Bail if not correct route.
    if ('/wp/v2/search' !== $request->get_route()) {
        return $response;
    }

    // Bail if API call is from another site,
    // because we only want relative links on same site.
    // string(18) "https://texttv.nu/"
    // string(74) "https://wp-playground.localhost/wp/wp-admin/post.php?post=1011&action=edit"
    $referer = $_SERVER['HTTP_REFERER'] ?? null;
    if ($referer) {
        $refererHost = parse_url($referer, PHP_URL_HOST);
        $siteHost = parse_url(get_home_url(), PHP_URL_HOST);
        if ($refererHost !== $siteHost) {
            // Call is from another site.
            return $response;
        }
    }

    // This looks like a call to the rest api with search as the callback.
    $arr_filters = array(
        "post_link",
        "post_type_link",
        "page_link",
        "term_link",
        "tag_link",
        "category_link",
        "wp_get_attachment_url",
        "wp_get_attachment_thumb_url",
        "attachment_link"
    );

    foreach ($arr_filters as $filter_name) {
        add_filter($filter_name, 'wp_make_link_relative');
    }

    return $response;
}

/**
 * Makes links and images added in TinyMCE use relative paths (instead of absolute)
 *
 * This is a benefit when developing a website on several domains, so you don't have to change all
 * links from http://beta.example.com/ to http://example.com/.
 */
function relativize_tinymce_links()
{
    if (
        // used when fetching posts to insert
        // used when fetching images to show in media editor
        // used when sending image from media browser to tiny editor
        (isset($_POST["action"]) && $_POST["action"] === "wp-link-ajax") ||
        (isset($_POST["action"]) && $_POST["action"] === "query-attachments") ||
        (isset($_POST["action"]) &&
            $_POST["action"] === "send-attachment-to-editor") ||
        // used when editing an image and then replacing the image in the tiny editor
        (isset($_POST["action"]) && $_POST["action"] === "get-attachment")
    ) {
        $arr_filters = array(
            "post_link",
            "post_type_link",
            "page_link",
            "term_link",
            "tag_link",
            "category_link",
            "wp_get_attachment_url",
            "wp_get_attachment_thumb_url",
            "attachment_link"
        );

        foreach ($arr_filters as $filter_name) {
            add_filter($filter_name, 'wp_make_link_relative');
        }
    }
}

add_action("admin_init", __NAMESPACE__ . '\relativize_tinymce_links');
