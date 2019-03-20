<?php

/**
 * Cleanup dashboard.
 */
namespace Gardener;

/**
 * Cleanup dashboard by removing dashboards meta boxes
 */
add_action("admin_init", function () {
    remove_meta_box('dashboard_quick_press', 'dashboard', 'normal');
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'normal');
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
    remove_meta_box('dashboard_plugins', 'dashboard', 'normal');

    // WordPress news and events.
    remove_meta_box('dashboard_primary', 'dashboard', 'normal');

    // remove_meta_box('dashboard_secondary', 'dashboard', 'normal');

    // Remove metabox for WPML.
    remove_meta_box('icl_dashboard_widget', "dashboard", "normal");
});

/**
 * Remove "Thank you for creating with WordPress"-text in bottom.
 */
add_action("admin_init", function () {
    add_filter("admin_footer_text", "__return_false");
});
