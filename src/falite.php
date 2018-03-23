<?php
/**
 * Font Awesome 5 Lite 0.1.4
 * This PHP library generates Font Awesome 5 (Pro and Free) SVG JS files and stores them in a cache.
 *
 * @copyright Copyright (c) 2018 by Innovato
 * @license This code is licensed under MIT license (see LICENSE file for details)
 */

namespace Innovato;

class FaLite
{
    /**
     * FA Types, if you want to use different file names you can
     * override this var, refer to the docs for an example.
     *
     * @var array
     */
    public $types;

    /**
     * Stores all the needed icons and content.
     *
     * @var array
     */
    private $icons;

    /**
     * Path to the files directory, this directory should contain
     * the FontAwesome JS folder (fa_source) & files (fa-brands.js, fa-light.js, etc.).
     *
     * Download Font Awesome Free/Pro at https://fontawesome.com/
     *
     * You can override this field, refer to the docs for an example.
     *
     * @var string
     */
    public $filesDirectory = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR;

    /**
     * This folder will be used to save cached files. Using the cache
     * method will keep your server load lower, especially with loads
     * of traffic.
     *
     * You can override this field, refer to the docs for an example.
     *
     * @var string
     */
    public $cacheDirectory = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR;

    /**
     * Stores the requested icons, not the content.
     *
     * @var string
     */
    private $requestedIcons;

    /**
     * Enables the cache method. You can override this field, refer
     * to the docs for an example.
     *
     * @var bool
     */
    public $cacheEnabled = true;

    /**
     * FaLite constructor.
     */
    public function __construct()
    {
        /**
         * First value is given type, second value is filename.
         */
        $this->types = [
            'fab' => 'fa-brands',
            'fal' => 'fa-light',
            'far' => 'fa-regular',
            'fas' => 'fa-solid'
        ];

        /**
         * We will fill this array when there's a result.
         */
        $this->icons = [
            'fab' => [],
            'fal' => [],
            'far' => [],
            'fas' => []
        ];
    }

    /**
     * Execute function.
     *
     * @param string $requestedIcons
     * @return string
     * @throws Exception
     */
    public function execute($requestedIcons = null)
    {
        $this->setHeader();

        if ($requestedIcons) {
            $this->checkDirectoriesForTrailingSlash();

            $explodedIcons = explode(',', $requestedIcons);
            $this->requestedIcons = $explodedIcons;

            if ($this->cacheEnabled) {
                $cacheFile = $this->getCacheFileName();
                if (file_exists($cacheFile)) {
                    echo file_get_contents($cacheFile);
                    return;
                }
            }

            foreach ($explodedIcons as $explodedIcon) {
                $trimmedIcon = trim($explodedIcon);
                $explodedTrimmedIcons = explode(' ', $trimmedIcon);

                if (sizeof($explodedTrimmedIcons) == 2) {
                    $prefix = strtolower($explodedTrimmedIcons[0]);
                    $font = strtolower($explodedTrimmedIcons[1]);

                    if ($this->types[$prefix]) {
                        if($line = $this->getLineWithString($this->getJSFilePath('fa_source'.DIRECTORY_SEPARATOR.$this->types[$prefix]), '"'.$font.'"')) {
                            $this->icons[$prefix][$font] = $line;
                        }
                    }
                }
            }

            if ($this->icons) {
                $strippedFile = file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'stripped.js');

                foreach ($this->icons as $type => $icons) {
                    $strippedFile = str_replace('[' . $type . ']', 'var icons = {' . implode('', $icons) . '};', $strippedFile);
                }

                if ($this->cacheEnabled && !file_exists($this->getCacheFileName())) {
                    $this->writeToCache($strippedFile);
                }

                echo $strippedFile;
            }
        }
    }

    /**
     * Loops through the source file to look for a match
     * and then returns the line.
     *
     * @param $fileName
     * @param $str
     * @return mixed
     */
    private function getLineWithString($fileName, $str)
    {
        $lines = file($fileName);
        foreach ($lines as $lineNumber => $line) {
            if (strpos($line, $str) !== false) {
                return $line;
            }
        }
        return false;
    }

    /**
     * Returns the full path to the JS source files.
     *
     * @param $fileName
     * @return string
     */
    private function getJSFilePath($fileName)
    {
        return $this->filesDirectory . $fileName . '.js';
    }

    /**
     * Writes a cache file.
     *
     * @param $content
     * @throws Exception
     */
    private function writeToCache($content = '')
    {
        if (!file_exists($this->cacheDirectory)) {
            if (!mkdir($this->cacheDirectory)) {
                throw new Exception('Cannot create cache directory, make sure PHP has writing permissions. You can turn 
                off the caching option. Please refer to https://github.com/innovato/fa-lite.');
            }
        }

        if (strlen($content)) {
            file_put_contents($this->getCacheFileName(), $content);
        }
    }

    /**
     * Generates a cache file name based on the requested icons.
     *
     * @return string
     */
    private function getCacheFileName()
    {
        $fonts = '';
        if ($this->requestedIcons) {
            foreach ($this->requestedIcons as $requestedIcon) {
                $fonts .= trim($requestedIcon);
            }

            return $this->cacheDirectory . substr(md5($fonts), 0, 8) . '.js';
        }

        return false;
    }

    /**
     * Checks if the directories have a trailing slash, if not
     * then it will add the trailing slash for you.
     */
    private function checkDirectoriesForTrailingSlash()
    {
        if (substr($this->filesDirectory, -1) != DIRECTORY_SEPARATOR) {
            $this->filesDirectory = $this->filesDirectory . DIRECTORY_SEPARATOR;
        }

        if (substr($this->cacheDirectory, -1) != DIRECTORY_SEPARATOR) {
            $this->cacheDirectory = $this->cacheDirectory . DIRECTORY_SEPARATOR;
        }
    }

    /**
     * Make it look like a legit JS file.
     */
    private function setHeader()
    {
        header('Content-Type: application/javascript');
    }
}
