<?php
/**
 * Example file for using FA Lite, all the options are optional!
 */

include '../src/falite.php';

$faLite = new Innovato\FaLite();

/**
 * Input needs to be comma separated
 * @example https://cdn.yoursite.com/fa-lite.js?icons=fab apple,far address-book
 */
$faLite->execute($_GET['icons']);