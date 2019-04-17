<?php

/**
 * Remove posts from admin menu and from admin bar (New -> Post)
 */
namespace Gardener;

/**
 * Remove New -> Post from admin bar.
 */
add_action(
    "admin_bar_menu",
    function ($wpAdminBar = null) {
        if (!isset($wpAdminBar) || empty($wpAdminBar)) {
            return;
        }

        $wpAdminBar->remove_node('new-post');
    },
    99,
    1
);

/**
 * Remove posts menu.
 */
add_action('admin_menu', function () {
    remove_menu_page('edit.php');
});
