<?php
/**
 * Gardener plugin for WordPress
 *
 * @category  Plugin
 * @package   Gardener
 * @author    Pär Thernström <par.thernstrom@gmail.com>
 * @copyright 2009-2019 Pär Thernström
 * @license   GPL v2 or later
 * @link      https://github.com/bonny/gardener
 *
 * Plugin Name:  Gardener
 * Description:  Cleanup WordPress frontend and backend
 * Version:      0.1
 * Plugin URI:   https://github.com/bonny/gardener/
 * Author:       Pär Thernström
 * Author URI:   https://eskapism.se/
 * Text Domain:  gardener
 * Domain Path:  /languages/
 * Requires PHP: 7.0
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

namespace Gardener;

defined('ABSPATH') || die();

/*
Nothing is modified by default. Add different cleanup things by calling
'add_theme_support'
for example
add_theme_support('gardener-relative-links');
or add all opinionated by using wildcard *
add_theme_support('gardener-*');
*/

/**
 * Check for enabled features on init.
 * We can detect all features added with add_theme_support(), for example
 * add_theme_support('gardener-cleanup-dashboard');
 *
 * Call with prio 1 so executed earlier than most things.
 */
add_action('init', __NAMESPACE__ . '\checkForEnabledFeatures', 1);

/**
 * Check for enabled features and load required files.
 *
 * Called from init action.
 */
function checkForEnabledFeatures()
{
    $features = getFeatures();

    array_walk($features, function ($feature, $featureKey) {
        // Load feature if support has been requested.
        $featureKeyWithPrefix = "gardener-{$featureKey}";
        if (($support = get_theme_support($featureKeyWithPrefix)) !== false) {
            $featureArguments = [];
            if (is_array($support) && isset($support[0])) {
                $featureArguments = $support[0];
            }
            // error_log("user has added support for $featureKey");
            loadFeature($featureKey, $featureArguments);
        }
    });
}

/**
 * Get features.
 *
 * @return array Array with features. Key is feature slug.
 * Array as value to make room for any future customiziation or informaton.
 */
function getFeatures()
{
    return [
        'remove-emoji' => [],
        'relative-links' => [],
        'cleanup-upload-filenames' => [],
        'cleanup-dashboard' => [],
        // Supports argument "message" and "image".
        'enhance-login-screen' => [],
        'cleanup-frontend' => []
    ];
}

/**
 * Load a feature.
 *
 * @param string $featureKey.
 */
function loadFeature($featureKey, array $featureArguments = [])
{
    $featureFile = __DIR__ . '/features/' . "{$featureKey}.php";
    // error_log("loading feature file $featureFile");
    @include $featureFile;
}
