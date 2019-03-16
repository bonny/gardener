<?php

namespace EP\admin\relativize_links;

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
