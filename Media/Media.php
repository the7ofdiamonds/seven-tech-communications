<?php

namespace SEVEN_TECH\Communications\Media;

use Exception;

class Media
{
    public function __construct()
    {
    }

    function valid_extensions()
    {
        $valid_extensions = [];

        $mimes = wp_get_mime_types();
        $mimes['svg'] = 'image/svg+xml';
        $extensions = array_keys($mimes);

        foreach ($extensions as $extension) {
            if (strpos($extension, '|')) {
                $mime_types = explode('|', $extension);

                foreach ($mime_types as $mime_type) {
                    $valid_extensions[] = $mime_type;
                }
            }

            $valid_extensions[] = $extension;
        }

        return $valid_extensions;
    }

    function valid_extension($file_path)
    {
        $file_extension = pathinfo($file_path, PATHINFO_EXTENSION);

        if (in_array($file_extension, $this->valid_extensions())) {
            return true;
        }

        return false;
    }

    function upload($subdir, $file, $filename)
    {
        $full_path = $file['full_path'];
        $file_path = $file['tmp_name'];
        $mime_type = $file['type'];

        if ($this->valid_extension($full_path) === false) {
            throw new Exception("The mime type {$mime_type} is not allowed.");
        }

        if (file_exists($file_path)) {
            $upload_dir = wp_upload_dir();
            $upload_path = $upload_dir['basedir'] . $subdir;
            $file_url = $upload_dir['baseurl'] . $subdir . $filename;

            if (!file_exists($upload_path)) {
                wp_mkdir_p($upload_path);
            }

            $new_file_path = $upload_path . $filename;

            move_uploaded_file($file_path, $new_file_path);

            $attachment = array(
                'guid'           => $new_file_path,
                'post_mime_type' => $mime_type,
                'post_title'     => sanitize_file_name($filename),
                'post_content'   => '',
                'post_status'    => 'inherit'
            );

            $attachment_id = wp_insert_attachment($attachment, $new_file_path);

            $attachment_data = wp_generate_attachment_metadata($attachment_id, $new_file_path);

            wp_update_attachment_metadata($attachment_id, $attachment_data);

            return $file_url;
        }
    }

    function getURL($path, $file)
    {
        $upload_dir = wp_upload_dir();
        $upload_dir_path = $upload_dir['basedir'] . '/' . $path;
        $upload_url = $upload_dir['baseurl'] . '/' . $path;

        if (!file_exists($upload_dir_path)) {
            throw new Exception('File does not exists.', 404);
        }

        $file_extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        if (in_array($file_extension, $this->valid_extensions())) {
            $url = $upload_url . '/' . $file;
        }

        return $url;
    }

    function urls($dir)
    {
        $upload_dir = wp_upload_dir();
        $upload_dir_path = $upload_dir['basedir'] . '/' . $dir;
        $upload_url = $upload_dir['baseurl'] . '/' . $dir;

        $urls = [];

        if (file_exists($upload_dir_path)) {
            $files = scandir($upload_dir_path);

            foreach ($files as $file) {
                $file_extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

                if (in_array($file_extension, $this->valid_extensions())) {
                    $url = $upload_url . '/' . $file;

                    $urls[] = $url;
                }
            }
        }

        return $urls;
    }
}
