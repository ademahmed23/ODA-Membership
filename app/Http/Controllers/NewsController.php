<?php
namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:news-list|news-create|news-edit|news-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:news-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:news-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:news-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $count = News::count();

        return view('news.index', compact('count'));
    }

    public function create()
    {
        return view('news.create');
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
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $name_gen = hexdec(uniqid()) . '.' . $video->getClientOriginalExtension();
            Image::make($video)->save('Photo/' . $name_gen);

            $video = 'Photo/' . $name_gen;
        }else{
            $video = null;
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
            'image' => 'nullable|image|mimes:mp4,jpeg,png,jpg,gif,svg|max:20000',
            'document' => 'nullable|mimes:pdf,doc,docx|max:40000',
            'video' => 'nullable|video|mimes:mp4,3gp,mov,flv,avi,wmv|max:40000',
        ]);

        $news = News::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'image' => $last_thumb,
            'document' => $documentname,
            'video' => $video,
        ]);

        return redirect()->route('news.index')->with('success', 'News Created successfully');

    }

    public function show($id)
    {
        $news = News::findOrFail($id);
    }

    public function edit($id)
    {
        $news = News::findOrFail($id);

        return view('news.edit', compact('news'));
    }

    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        }else{
            $last_thumb = $news->image;
        }
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $name_gen = hexdec(uniqid()) . '.' . $video->getClientOriginalExtension();
            Image::make($video)->save('Photo/' . $name_gen);

            $video = 'Photo/' . $name_gen;
        }else{
            $video = $news->video;
        }

         if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $news->document;
        }

        $validated = $request->validate([
            'title' => 'required|string|max:40',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20000',
            'document' => 'nullable|mimes:pdf,doc,docx|max:40000',
            'video' => 'nullable|video|mimes:mp4,3gp,mov,flv,avi,wmv|max:40000',
        ]);


        $news->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'image' => $last_thumb,
            'document' => $documentname,
            'video' => $video,
        ]);

        return redirect()->route('news.index')->with('update', 'News Updated successfully');

    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);
        $news->delete();

        return redirect()->route('news.index')->with('delete', 'News Deleted successfully');
    }
}
