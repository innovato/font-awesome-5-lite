<?php
/**
 * Example file for using Font Awesome 5 Lite.
 */

include dirname(dirname(__FILE__))  . DIRECTORY_SEPARATOR . 'autoloader.php';

$faLite = new Innovato\FaLite();

/**
 * Input needs to be comma separated
 * @example https://cdn.yoursite.com/fa-lite.js?icons=fab apple,far address-book
 */
$faLite->execute($_GET['icons']);