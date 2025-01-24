<?php

namespace Helpers;

class File
{
    public static function upload($file, $outputPath = "uploads/")
    {
        if (!is_dir($outputPath)) {
            mkdir($outputPath, 0755, true);
        }
        $upload_path = $outputPath . trim(basename($file["name"]));
        move_uploaded_file($file["tmp_name"], $upload_path);

        return $upload_path;
    }
}
