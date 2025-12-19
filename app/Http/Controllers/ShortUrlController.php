<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShortUrlController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $urls = ShortUrl::query()
            ->latest()
            ->get()
            ->filter(fn ($url) => $user->can('view', $url));

        return view('short_urls.index', compact('urls'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', ShortUrl::class);

        $request->validate([
            'original_url' => ['required', 'url']
        ]);

        $user = auth()->user();

        // do {
        //     $code = Str::random(6);
        // } while (ShortUrl::where('short_code', $code)->exists());

        // ShortUrl::create([
        //     'original_url' => $request->original_url,
        //     'short_code' => $code,
        //     'user_id' => auth()->id(),
        //     'company_id' => auth()->user()->company_id,
        // ]);
        ShortUrl::create([
            'short_code' => Str::random(8),
            'original_url' => $request->original_url,
            'user_id' => $user->id,
            'company_id' => $user->company_id, // safe now
        ]);

        return back()->with('success', 'Short URL created successfully.');
    }

}
