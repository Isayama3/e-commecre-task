<?php

namespace App\Base\Traits\Custom;

use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

/**
 *
 */
trait ResizableImageTrait
{
    /**
     * Undocumented function
     *
     * @param [type] $file
     * @param [type] $path
     * @return string
     */
    public function uploadImage($file, $path = "uploads", $quality = 60): string
    {
        $extension = $file->getClientOriginalExtension();
        $file_rename = time() . uniqid() . '.' . $extension;

        // Make directory if it doesn't exist
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        // Move uploaded file to the specified path
        $file->move($path, $file_rename);

        // Compress and save image with the specified quality
        $image = Image::make(public_path($path . '/' . $file_rename));
        $image->save(public_path($path . '/' . $file_rename), $quality);
        return $path . '/' . $file_rename;
    }

    /**
     * Upload new images and delete old stored images
     *
     * @param string $path
     * @param [type] $file
     * @param [type] $old_record
     * @return string
     */
    public function updateImage($file, string|null $old_file_name, $path = "uploads", $quality = 60): string
    {
        $file_rename = $this->uploadImage($file, $path, $quality);
        if (File::exists(public_path($path . '/' . $old_file_name))) {
            File::delete(public_path($path . '/' . $old_file_name));
        }

        return $file_rename;
    }

    public function deleteImage(string|null $file_name, $path = "uploads")
    {
        if (File::exists(public_path($path . '/' . $file_name))) {
            File::delete(public_path($path . '/' . $file_name));
        }

        return false;
    }
}
