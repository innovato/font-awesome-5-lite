# Font Awesome 5 Lite
This PHP library generates Font Awesome 5 (Pro and Free) SVG JS files and stores them in a cache. It only generates the icons that you need! It's useful for those who don't want to use third party CDN's or WebPack.  

Due to possible copyright infringements you need to download the latest Font Awesome yourself and add it to the files/fa_source folder.  

## Quick start
Several quick start options are available:

- [Download the latest release.](https://github.com/innovato/font-awesome-5-lite/archive/master.zip)
- Clone the repo: `git clone https://github.com/innovato/font-awesome-5-lite.git`
- Install with [composer](https://www.getcomposer.org/): `composer require innovato/font-awesome-5-lite`

### Get the Font Awesome 5 source files (required)
Get the Font Awesome 5 source files from their official website (https://fontawesome.com/). It's up to you to whether you want to use the Free or Pro version. They're both compatible with this library.

After the download you need to place the content of the Font Awesome svg-with-js/js folder in to the files/fa_source directory (or use your own assets directory).

If you choose to use your own assets directory, then make sure there's a subfolder called "fa_source" with the SVG JS files and also make sure the names are compatible.

## Basic usage
### With default settings
```php
<?php

include '../src/falite.php';

$faLite = new Innovato\FaLite();

$faLite->execute($_GET['icons']);
```

### With all options
```php
<?php

include '../src/falite.php';

$faLite = new Innovato\FaLite();

$faLite->cacheEnabled = true; // Default true
$faLite->cacheDirectory = '../files/cache';
$faLite->filesDirectory = '../files';
$faLite->types = [
    'fab' => 'fa-brands',
    'fal' => 'fa-light',
    'far' => 'fa-regular',
    'fas' => 'fa-solid'
];
$faLite->execute($_GET['icons']);
```

### Webserver configuration examples (optional)

You can use Nginx's `rewrite` to create a rule to make it look like it's a legit JS file. For example:

```
server {
    ...
    
    rewrite ^/font-awesome-lite\.js$  /examples/example_minimal.php;
    
    ...
}
```

Or use Apache's `mod_rewrite` method:
```
<IfModule mod_rewrite.c>
  RewriteEngine on
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteRule ^example_minimal\.php$ /font-awesome-lite.js?&%{QUERY_STRING}
</IfModule>
```

### Adding Font Awesome Lite in your template
Add the generator URL to your HTML (use your own URL and path of course):
```html
<script src="https://yourwebsite.com/assets/font-awesome-lite.js?icons=fab innovato, fas arrow-left"></script>
```

Initiate Font Animate:

```javascript
$(document).ready(function () {
  $('.font-animate').fontAnimate();
});
```
Done!

## Options
| Name            | Type     | Description |
|-----------------|----------|-------------|
|`cacheEnabled`   | boolean  | This enables caching JS files [Default: `true`] |
|`cacheDirectory` | string   | Full path to caching directory [Default: `files/cache`] |
|`filesDirectory` | string   | Full path to files directory [Default: `files`] |
|`types`          | array    | The types and files to use [Default: `[ 'fab' => 'fa-brands', 'fal' => 'fa-light', 'far' => 'fa-regular', 'fas' => 'fa-solid' ]`] |

## Credits
A big thanks to [Font Awesome](https://github.com/FortAwesome/Font-Awesome) for the awesome SVG icons!

## Copyright and license
Code and documentation copyright 2018 [Innovato](https://innovato.nl/). Code released under the [MIT License](https://github.com/innovato/fontanimate/blob/master/LICENSE).