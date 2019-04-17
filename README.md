# 🏡🌳🌻 Gardener – Opinionated cleanup for WordPress

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
    add_theme_support('gardener-enhance-login-screen', [
        'message' => "Welcome to ACME Co website. Please login!",
        'image' =>
            '84x84px-login-image.png'
    ]);

## TODO

- [ ] Add all wanted features
- [ ] Test composer.json
- [ ] Document features incl. screenshots

## Features

### Relative links

<details>
  <summary>Screenshot</summary>
  "Coming soon."
</details>

### Remove emoji

### Cleanup-upload-filenames

### Cleanup dashboard

### Cleanup frontend

### Enhance login screen
