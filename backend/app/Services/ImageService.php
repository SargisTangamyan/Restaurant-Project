<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageService
{
    protected string $disk = 'public';

    public function saveImage($file, $folders = ['original', 'thumbnail'], $thumbnailSize = 300)
    {
        $filename = time() . '_' . $file->getClientOriginalName();

        $paths = [];

        // Save original
        if (in_array('original', $folders)) {
            $paths['original'] = $file->storeAs('images/original', $filename, $this->disk);
        }

        // Create thumbnail
        if (in_array('thumbnail', $folders)) {
            $manager = new ImageManager(new Driver());
            $thumbnail = $manager->read($file);
            $thumbnail->resize($thumbnailSize, $thumbnailSize);

            $thumbnailPath = 'images/thumbnail/' . $filename;
            Storage::disk($this->disk)->put($thumbnailPath, (string)$thumbnail->encode());
            $paths['thumbnail'] = $thumbnailPath;
        }

        return $paths;
    }
}
