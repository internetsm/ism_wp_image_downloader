<?php

namespace IsmImageUploader\Helper;

/**
 * Created by PhpStorm.
 * User: michele
 * Date: 16/11/17
 * Time: 11.48
 */
class MediaHelper
{

    public static function downloadImage($url){
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

        return $attachId;
    }

}