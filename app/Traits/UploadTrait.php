<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

trait UploadTrait
{
    public function uploadOne($file, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : Str::random(25); // Usamos Str::random en lugar de str_random
        $file->storeAs($folder, $name.'.'.$file->getClientOriginalExtension(), $disk);

        return $name.'.'.$file->getClientOriginalExtension();
    }
}
