<?php

/**
 * Modify login screen:
 *  - remove link to wordpress.org
 *  - add support for local client image above login fields
 */

namespace Gardener;

/*
 * Change url of login logo to the url of the site instead of wordpress.org.
 * If not then there is a risk that the user gets lost at th wordpress.org site.
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

/**
 * Show a message above login box if arguments "message" is set.
 */
if (!empty($featureArguments['message'])) {
    $loginMessage = $featureArguments['message'];
    add_action("login_message", function ($message) use ($loginMessage) {
        $message = "<p>$loginMessage</p>";
        return $message;
    });
}

/**
 * Add client logo, if login-client-logo.png exists in theme folder.
 * Size should be 84px x 84px (same as default WordPress logo).
 */
$loginImage = false;
if (!empty($featureArguments['image'])) {
    $loginImage = $featureArguments['image'];
}
add_action("login_head", function () use ($loginImage) {
    $image_uri = false;
    if ($loginImage) {
        $image_and_path = $loginImage;
        $image_uri = $image_and_path;
    } else {
        $image_filename = "login-client-logo.png";
        $image_uri =
            trailingslashit(get_stylesheet_directory_uri()) . $image_filename;
    }

    if ($image_uri) { ?>
		<style>
			.login h1 a {
				background-image: url(<?php echo esc_url($image_uri); ?>);
                background-position: center;
			}
		</style>
		<?php }
});
