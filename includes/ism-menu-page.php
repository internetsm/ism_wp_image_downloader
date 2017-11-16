<?php
/**
 * Created by PhpStorm.
 * User: michele
 * Date: 14/11/17
 * Time: 8.40
 */

use IsmImageUploader\Helper\MediaHelper;

add_action("admin_menu", 'ism_image_downloader_page');

function ism_image_downloader_page()
{
    add_submenu_page('upload.php', 'Download images', 'Download', 'manage_options', 'ism_image_downloader_menu', 'ism_image_downloader_page_template');
}

function ism_image_downloader_page_template()
{
    $attachId = null;

    $availableThumbnails = [];

    if (isset($_POST['url'])) {

        $url = $_POST['url'];

        $attachId = MediaHelper::downloadImage($url);

        $availableThumbnails = get_intermediate_image_sizes();

    }


    echo ism_image_downloader_get_template('admin/index', [
        'attach_id'            => $attachId,
        'available_thumbnails' => $availableThumbnails
    ]);
}