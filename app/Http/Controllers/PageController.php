<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($slug = 'index')
    {
        $path = "pages/{$slug}.json";

        if (!Storage::exists($path)) {
            return response()->json(['error' => 'Page not found'], 404);
        }

        $json = Storage::get($path);
        $data = json_decode($json, true);

        return response()->json($data);
    }
}
