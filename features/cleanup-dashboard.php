<?php

/**
 * Cleanup in admin area
 */
namespace EP\admin\cleanup;

/**
 * Make file names of media attachments work better with more server configs:
 * - Remove chars like åäö
 * - Remove percent signs
 * - Make file names lowercase
 */
add_filter(
    'sanitize_file_name',
    function ($filename, $filename_raw) {
        // By default WP does allow chars like åäöÅÄÖ in filenames,
        // but I've had enough problems with that to know that I want them removed
        //
        // This will hopefully be fixed by default in future WP version:
        // https://core.trac.wordpress.org/ticket/22363
        // https://core.trac.wordpress.org/ticket/24661
        $filename = remove_accents($filename);

        // Remove percent signs. Very simple replace, does not care that space = "%20", just removed the "%"
        $filename = str_replace('%', '', $filename);

        // Also make all filenames lowercase, just to minimize risk of problems with dev server having
        // non case sensitive file system and live server having case sensitive
        $filename = mb_strtolower($filename);

        // Filter away any remaining strange chars by just keeping basic printable ASCII characters
        // This will also remove the wierd "å" inside the filename below. It is not a regular swedish å, it's
        // 'CC 8A' is the UTF-8 representation of Unicode U+030A (COMBINING RING ABOVE)
        // $filename = "Ingen-ko-på-isen-1b 2.jpg";
        // http://stackoverflow.com/questions/1176904/php-how-to-remove-all-non-printable-characters-in-a-string
        $filename = preg_replace('/[^[:print:]]/', '', $filename);

        return $filename;
    },
    10,
    2
);

/**
 * Cleanup dashboard by removing dashboards meta boxes
 */
add_action("admin_init", function () {
    // remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
    remove_meta_box('dashboard_quick_press', 'dashboard', 'normal'); // quick press
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'normal'); // recent drafts
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
    remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
    remove_meta_box('dashboard_primary', 'dashboard', 'normal');
    remove_meta_box('dashboard_secondary', 'dashboard', 'normal');

    // Remove metabox for WPML
    $wpml_dasbhboard_widget_id = "icl_dashboard_widget";
    remove_meta_box($wpml_dasbhboard_widget_id, "dashboard", "normal");
});

/**
 * Remove "Thank you for creating with WordPress"-text in bottom
 */
add_action("admin_init", function () {
    add_filter("admin_footer_text", "__return_false");
});

/**
 * Cleanup admin menu by removing menu items like posts and comments
 * Enable this if a site is not using any blog functionality
 * using the built in posts post type
 */
add_action("admin_menu", function () {
    // Remove (blog) posts menu
    remove_menu_page("edit.php");

    // Remove comments menu
    remove_menu_page("edit-comments.php");
});

/**
 * Remove WordPress-logo from admin bar
 */
add_action(
    'wp_before_admin_bar_render',
    function () {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('wp-logo');
    },
    0
);

/**
 * Add default, empty, values to options that wordpress, jetpack, and maybe other plugins tries to load
 * and causing unneeded sql calls
 */
add_action("admin_init", function () {
    $arr_options = array(
        "widget_pages",
        "widget_calendar",
        "widget_tag_cloud",
        "widget_facebook-likebox",
        "widget_grofile",
        "widget_jetpack_readmill_widget",
        "widget_rss_links",
        "widget_twitter_timeline",
        "widget_jetpack_display_posts_widget",
        "jetpack_id",
        "gplus_authors",
        "simple_fields_options"
    );

    foreach ($arr_options as $one_option) {
        $option_val = get_option($one_option);

        if (false === $option_val) {
            update_option($one_option, "");
        }
    }
});
