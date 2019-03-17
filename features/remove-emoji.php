<?php

namespace Gardener;

add_action('init', __NAMESPACE__ . '\removeEmojis');

/**
 * Remove emoji related things.
 * Called from init action.
 */
function removeEmojis()
{
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
}
