<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \File;
use \Response;

class StorageController extends Controller
{
    //

    public function sendFile($filename) {
        $path = storage_path($filename);


        if (!File::exists($path)) {
        abort(404);
        }


        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;

    }
}
