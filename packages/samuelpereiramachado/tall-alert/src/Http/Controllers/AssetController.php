<?php

namespace SamuelPereiraMachado\TallAlert\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class AssetController extends Controller
{
    public function js()
    {
        $path = __DIR__ . '/../../../resources/js/sweetalert2.all.min.js';

        if (!file_exists($path)) {
            abort(404);
        }

        $content = file_get_contents($path);

        return new Response($content, 200, [
            'Content-Type' => 'application/javascript; charset=utf-8',
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }
}
