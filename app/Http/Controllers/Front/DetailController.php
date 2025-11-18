<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

class DetailController
{
    public function __invoke($id, $model)
    {
        $model = 'App\Models\\' . $model;
        $detail = $model::findOrFail($id);
        $latests = $model::where('id', '!=', $id)->latest()->take(4)->get();
        return view('front.detail', compact('detail', 'latests'));
    }
}
