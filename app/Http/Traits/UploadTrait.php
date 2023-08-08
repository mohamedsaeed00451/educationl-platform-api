<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Storage;

trait UploadTrait
{
    public function deleteFile($file)
    {
        $exists = Storage::disk('uploads')->exists($file);
        if ($exists) {
            Storage::disk('uploads')->delete($file);
        }
        return true;
    }

    public function addFile($folder, $file)
    {
        $path = $file->store($folder, 'uploads');
        if ($path) {
            return $path;
        }
        return false;
    }
}
