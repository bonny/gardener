<?php

/**
 * Remove comments from admin menu.
 */
namespace Gardener;

/**
 * Remove comments menu item.
 */
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});
