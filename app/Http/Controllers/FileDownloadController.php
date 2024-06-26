<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileDownloadController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(string $path)
    {
        if (file_exists(public_path('storage/'.$path))) {
            return response()->download(public_path('storage/'.$path));
        }

        abort(404);
    }
}
