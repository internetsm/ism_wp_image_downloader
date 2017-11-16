<?php
/*
Plugin Name: Ism Image Downloader
Plugin URI: #
Description: Ism Image Downloader
Version: 1.0.0
Author: #
Author URI: #
License: MIT
*/

require_once __DIR__ . "/src/autoload.php";
require_once __DIR__ . "/includes/ism-menu-page.php";

if (!function_exists("ism_image_downloader_get_template")) {

    /**
     * Get template
     *
     * @param $slug
     * @param $args
     * @return string
     * @throws Exception
     */
    function ism_image_downloader_get_template($slug, $args = [])
    {
        $templatePathSelected = null;
        $templatePaths = [
            __DIR__ . "/templates/{$slug}.php",
            get_stylesheet_directory() . "/ism_image_uploader/{$slug}.php",
        ];
        foreach ($templatePaths as $templatePath) {
            if (file_exists($templatePath)) {
                $templatePathSelected = $templatePath;
            }
        }
        if (!$templatePathSelected) {
            throw new Exception("ism_image_uploader template not found");
        }
        ob_start();
        extract($args);
        include $templatePathSelected;
        return ob_get_clean();
    }
}
