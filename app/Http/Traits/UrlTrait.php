<?php

namespace App\Http\Traits;

trait UrlTrait
{
    public function getPath($path)
    {
        if (file_exists(public_path('/uploads/' . $path))) {
            return url('/public/uploads/' . $path);
        }

        return null;
    }
}
