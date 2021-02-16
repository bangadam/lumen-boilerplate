<?php

namespace App\Http\Controllers\V1\FileManager;

use Illuminate\Http\Request;
use App\Http\Controllers\V1\Controller;

class FileController extends Controller
{
    
    public function show($name)
    {
        $path = storage_path('app/public') . '/' . $name . '.jpeg';
        if (file_exists($path)) {
            $file = file_get_contents($path);
            return response($file, 200)->header('Content-Type', 'image/jpeg');
        }
    }

}
