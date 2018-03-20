<?php
/**
 * Example file for using FA Lite, all the options are optional!
 */

include '../src/falite.php';

$faLite = new Innovato\FaLite();

/**
 * You can enable or disable the cache writing function
 * Default = true (on)
 */
$faLite->cacheEnabled = true;

/**
 * If you want to use the cache directory of your
 * framework or something, you can set the path
 * to the right directory
 */
$faLite->cacheDirectory = '../files/cache';

/**
 * If you want to use the files directory of your
 * framework or something, you can set the path
 * to the right directory
 *
 * Just make sure the FA source files are in this
 * folder!
 */
$faLite->filesDirectory = '../files';

/**
 * If you want to use different file names for
 * the FA source files, then feel free to override
 * it
 */
$faLite->types = [
    'fab' => 'fa-brands',
    'fal' => 'fa-light',
    'far' => 'fa-regular',
    'fas' => 'fa-solid'
];

/**
 * Input needs to be comma separated
 * @example https://cdn.yoursite.com/fa-lite.js?icons=fab apple,far address-book
 */
$faLite->execute($_GET['icons']);