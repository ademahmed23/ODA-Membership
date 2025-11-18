<?php
namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:announcement-list|announcement-create|announcement-edit|announcement-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:announcement-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:announcement-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:announcement-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $count = Announcement::count();

        return view('announcement.index', compact('count'));
    }

    public function create()
    {
        return view('announcement.create');
    }

    public function store(Request $request)
    {
         if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        }else{
            $last_thumb = null;
        }

         if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = 'default.pdf';
        }

        $validated = $request->validate([
            'title' => 'required|string|max:40',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20000',
        ]);

        $announcement = Announcement::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'image' => $last_thumb,
        ]);

        return redirect()->route('announcement.index')->with('success', 'Announcement Created successfully');

    }

    public function show($id)
    {
        $announcement = Announcement::findOrFail($id);
    }

    public function edit($id)
    {
        $announcement = Announcement::findOrFail($id);

        return view('announcement.edit', compact('announcement'));
    }

    public function update(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        }else{
            $last_thumb = $announcement->image;
        }

         if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $announcement->document;
        }

        $validated = $request->validate([
            'title' => 'required|string|max:40',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20000',
        ]);


        $announcement->update([
            'title' => $validated['title'] ?? $announcement->title,
            'content' => $validated['content'] ?? $announcement->content,
            'image' => $last_thumb,
        ]);

        return redirect()->route('announcement.index')->with('update', 'Announcement Updated successfully');

    }

    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();

        return redirect()->route('announcement.index')->with('delete', 'Announcement Deleted successfully');
    }
}
