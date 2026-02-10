<?php

namespace SamuelPereiraMachado\TailwindcssSweetalert\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class AssetController extends Controller
{
    public function css()
    {
        $path = __DIR__ . '/../../../resources/css/tailwind.css';

        if (! file_exists($path)) {
            abort(404);
        }

        return new Response(file_get_contents($path), 200, [
            'Content-Type'  => 'text/css; charset=utf-8',
            'Cache-Control' => 'public, max-age=31536000, immutable',
        ]);
    }

    public function js()
    {
        $path = __DIR__ . '/../../../resources/js/sweetalert2.all.min.js';

        if (! file_exists($path)) {
            abort(404);
        }

        return new Response(file_get_contents($path), 200, [
            'Content-Type'  => 'application/javascript; charset=utf-8',
            'Cache-Control' => 'public, max-age=31536000, immutable',
        ]);
    }
}
