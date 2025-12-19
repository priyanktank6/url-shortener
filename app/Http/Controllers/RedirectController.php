<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function resolve(string $code)
    {
        $shortUrl = ShortUrl::where('short_code', $code)->firstOrFail();

        return redirect()->away($shortUrl->original_url);
    }
}
