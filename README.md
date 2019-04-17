# Gardener – Opinionated cleanup for WordPress

**Note: work in progress, don't use on a production site!**

Add theme support for cleaning up WordPress admin + frontend.
Opinionated.

No feature is added or modified by default. Support for each feature must be added manually.

Will not break anything if uninstalled.

Gardener:

> one employed to care for the gardens or grounds of a home, business concern, or other property
> -- https://www.merriam-webster.com/dictionary/gardener

- Cleans up dirty WordPress admin and frontend. It's your WordPress Gardener.
- The admin/code is cleaner on the other side.

## Name suggestions

_Gardener_ – because cleans up frontend and backend of WordPress.

## Installation and usage

Install using composer:

    composer require bonny/gardener

Add support for wanted features in your `functions.php`:

    add_theme_support('gardener-remove-emoji');
    add_theme_support('gardener-relative-links');
    add_theme_support('gardener-cleanup-upload-filenames');
    add_theme_support('gardener-cleanup-dashboard');
    add_theme_support('gardener-hide-posts');
    add_theme_support('gardener-enhance-login-screen', [
        'message' => "Welcome to ACME Co website. Please login!",
        'image' =>
            '84x84px-login-image.png'
    ]);

## Todo

- [ ] Add all wanted features
- [ ] Document features incl. screenshots

## Features

### Relative links

- Makes links and images added in Gutenberg och TinyMCE use relative paths, instead of absolute.
  This is a benefit when developing a website on several domains, so you don't have to change all
  links from http://beta.example.com/ to http://example.com/.

<details>
  <summary>Screenshot</summary>
  "Coming soon."
</details>

### Remove emoji

- Remove emoji related things.
- Removes print_emoji_detection_script, print_emoji_styles.

### Cleanup-upload-filenames

- Make file names of media attachments work better with more server configs.
- Only keep keeping basic printable ASCII characters
- Remove chars like åäö
- Remove percent signs "%"
- Make file names lowercase

### Cleanup dashboard

- Remove unwanted dashboard meta boxes, like quickpress, plugins, recent drafts, incoming links, news and events, WPML meta box if WPML is installed.
- Removes the text "Thank you for creating with WordPress" at the bottom.

### Hide posts

- Hide posts links from admin menu and from admin bar (New -> Post).

### Enhance login screen

- Remove link to wordpress.org.
- Add support for local client image above login fields.

## Changelog

- 0.2 Add support for feature hide posts.
- 0.1 First version
