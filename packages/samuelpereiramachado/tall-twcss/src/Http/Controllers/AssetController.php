<?php

namespace SamuelPereiraMachado\TallTwcss\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class AssetController extends Controller
{
    public function css()
    {
        $path = __DIR__ . '/../../../resources/css/tailwind.css';

        if (!file_exists($path)) {
            abort(404);
        }

        $content = file_get_contents($path);

        return new Response($content, 200, [
            'Content-Type' => 'text/css; charset=utf-8',
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }
}