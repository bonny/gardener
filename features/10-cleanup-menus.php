<?php

/**
 * Remove + add some classes to the nav menu
 *
 * Before this action a menu item may look like this:
 * <li class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-56 current_page_item menu-item-has-children menu-item-58">
 *
 * After this action the same menu item looks like this:
 * <li class="menu-item current-menu-item menu-item-has-children">
 */
add_action("nav_menu_css_class", function (
    $classes,
    $item = null,
    $args = null
) {
    // Always keep classes in this array
    $arr_keepers = array("menu-item-has-children");

    foreach ($classes as &$one_class) {
        if (in_array($one_class, $arr_keepers)) {
            continue;
        }

        // Remove menu-item-type-post_type, i.e. classes that begin with menu-item-type-
        if (strpos($one_class, "menu-item-type-") !== false) {
            $one_class = "";
        }

        // Remove menu-item-type-post_type, i.e. classes that begin with menu-item-object-
        if (strpos($one_class, "menu-item-object-") !== false) {
            $one_class = "";
        }

        // Remove page_item and current_page_item, that is there for compatibility reason with list_pages
        if ("page_item" == $one_class || "current_page_item" == $one_class) {
            $one_class = "";
        }

        // Dito for current_page_parent and current_page_ancestor
        if (
            "current_page_parent" == $one_class ||
            "current_page_ancestor" == $one_class
        ) {
            $one_class = "";
        }

        // Remove page-item-56 or menu-item-nn, i.e. classes that begin with page-item- or menu-item-
        if (strpos($one_class, "page-item-") !== false) {
            $one_class = "";
        }

        // Remove menu-item-11, but keep custom ones we have added like menu-item-coffee
        if (strpos($one_class, "menu-item-") !== false) {
            if (preg_match('/menu-item-[\d]+/', $one_class)) {
                $one_class = "";
            }
        }
    }

    // Remove empty classes
    $classes = array_filter($classes);

    return $classes;
});

/**
 * Remove id-attributes from nav menu items
 *
 * Before this action a menu item may look like this:
 * <li id="menu-item-58" class=...
 *
 * After this action the same item looks like this:
 * <li class=...
 */
add_action("nav_menu_item_id", function () {
    return "";
});
