<?php

/**
 * Make file names of media attachments work better with more server configs.
 * When activated this feature will:
 * - Only keep keeping basic printable ASCII characters
 * - Remove chars like åäö
 * - Remove percent signs "%"
 * - Make file names lowercase
 */

namespace Gardener;

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
        // non case sensitive file system and live server having case sensitive.
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
