<?php

/**
 * Modify login screen:
 *  - remove link to wordpress.org
 *  - add support for local client image above login fields
 */

namespace EP\frontend\login_screen;

/*
 * Change url of login logo to the url of the site
 * If not then there is a risk that the user gets lost at th wordpress.org site
 */
add_action("login_headerurl", function ($url) {
    $url = home_url();
    return $url;
});

/**
 * Change title of a element on logo to say that link goes to homepage of current site
 */
add_action("login_headertitle", function ($title) {
    $title = sprintf(__("Back to %s"), home_url());
    return $title;
});

/*
add_action("login_message", function($message) {
	$message = "Welcome! This site is proudly made by Earth People.";
	return $message;
});
*/

/**
 * Add client logo, if login-client-logo.png exists in theme folder
 */
add_action("login_head", function () {
    $image_filename = "login-client-logo.png";
    $image_and_path =
        trailingslashit(get_stylesheet_directory()) . $image_filename;

    if (file_exists($image_and_path)) {

        $image_uri =
            trailingslashit(get_stylesheet_directory_uri()) . $image_filename;
        $image_size = getimagesize($image_and_path);
        $css_width = "";
        $css_height = "";
        $css_background_size = "";
        if (false !== $image_size) {
            $css_width = "{$image_size[0]}px";
            $css_height = "{$image_size[1]}px";
            $css_background_size = "$css_width $css_height";
        }
        ?>
		<style>
			.login h1 a {
				background-image: url(<?php echo $image_uri; ?>);
				<?php if ($css_width && $css_height) { ?>
					width: <?php echo $css_width; ?>;
					height: <?php echo $css_height; ?>;
					background-size: <?php echo $css_background_size; ?>;
				<?php } ?>
			}
		</style>
		<?php
    }
});
