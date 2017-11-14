<?php
/**
 * Created by PhpStorm.
 * User: michele
 * Date: 14/11/17
 * Time: 8.40
 */

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

        $extension = ".png";

        $extensions = [".gif", ".jpg", ".jpeg", ".bmp"];

        foreach ($extensions as $testExtension) {

            if (preg_match("/" . str_replace(".", '\.', $testExtension) . "$/is", $url)) {
                $extension = $testExtension;
            }
        }

        $title = basename($url);

        $imageName = sanitize_file_name($title);

        $file = wp_upload_bits($imageName . $extension, null, file_get_contents($url));

        $filename = $file['file'];

        $filetype = wp_check_filetype(basename($filename), null);

        $wp_upload_dir = wp_upload_dir();

        $attachment = array(
            'guid'           => $wp_upload_dir['url'] . '/' . basename($filename),
            'post_mime_type' => $filetype['type'],
            'post_title'     => preg_replace('/\.[^.]+$/', '', basename($filename)),
            'post_content'   => '',
            'post_status'    => 'inherit'
        );

        $attachId = wp_insert_attachment($attachment, $filename);

        $attach_data = wp_generate_attachment_metadata($attachId, $filename);

        wp_update_attachment_metadata($attachId, $attach_data);

        $availableThumbnails = get_intermediate_image_sizes();

    }


    echo ism_image_downloader_get_template('admin/index', [
        'attach_id'            => $attachId,
        'available_thumbnails' => $availableThumbnails
    ]);
}