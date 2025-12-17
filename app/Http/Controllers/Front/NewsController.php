<?php

namespace App\Http\Controllers\Front;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController
{
    public function __invoke(Request $request)
    {
        $latest = News::latest()->first();
        if ($latest) {
            $news = News::where('id', '!=', $latest->id)->latest()->paginate(9);
        } else {
            $news = News::latest()->paginate(9);
        }

        return view('front.index', compact('latest', 'news'));
    }
}
