<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Storage;

trait UploadTrait
{
    public function deleteImage($folder, $image)
    {
        $exists = Storage::disk('uploads')->exists($folder . '/' . $image);
        if ($exists) {
            Storage::disk('uploads')->delete($folder . '/' . $image);
        }
    }

    public function addImage($folder, $image)
    {
        $path = $image->store($folder, 'uploads');
        if ($path) {
            $image_name = explode('/', $path);
            return end($image_name);
        }
        return false;
    }
}
