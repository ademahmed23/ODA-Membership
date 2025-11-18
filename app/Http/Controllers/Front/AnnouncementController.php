<?php

namespace App\Http\Controllers\Front;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController
{
    public function __invoke(Request $request)
    {
        $latest = Announcement::latest()->first();
        if ($latest) {
            $announcements = Announcement::where('id', '!=', $latest->id)->latest()->paginate(9);
        } else {
            $announcements = Announcement::latest()->paginate(9);
        }
        return view('front.announcement', compact('latest', 'announcements'));
    }
}
