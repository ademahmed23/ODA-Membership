<?php

namespace App\Http\Controllers;

use App\Models\Honorable;
use Illuminate\Http\Request;
use App\Imports\HonorableImport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class HonorableController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:honorable-list|honorable-create|honorable-edit|honorable-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:honorable-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:honorable-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:honorable-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $count = Honorable::count();

        return view('honorable.index', compact('count'));
    }

    public function create()
    {
        return view('honorable.create');
    }

    public function store(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = null;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = 'default.pdf';
        }
        // $table->string('first_name');
        // $table->string('middle_name')->nullable();
        // $table->string('last_name');
        // $table->string('gender');
        // $table->integer('age');
        // $table->string('address')->nullable();
        // $table->string('contact_number')->nullable();
        // $table->string('email')->nullable();
        // $table->string('position')->nullable();
        // $table->string('membership_type')->default('Honorable');
        // $table->integer('membership_fee')->nullable();
        $validated = $request->validate([
            'first_name' => 'required|string|max:40',
            'middle_name' => 'nullable|string|max:40',
            'last_name' => 'required|string|max:40',
            'gender' => 'required|string|max:7',
            'age' => 'required|integer|digits_between:1,3',
            'address' => 'nullable|string|max:255',
            'contact_number' => 'nullable|numeric|digits_between:9,14',
            'email' => 'nullable|email|max:255|unique:honorables',
            'position' => 'nullable|string|max:255',
            'membership_type' => 'nullable|string|max:255',
            'membership_fee' => 'nullable|integer',
        ]);

        $honorable = Honorable::create($validated);

        return redirect()->route('honorable.index')->with('success', 'Honorable Created successfully');
    }

    public function show($id)
    {
        $honorable = Honorable::findOrFail($id);
    }

    public function edit($id)
    {
        $honorable = Honorable::findOrFail($id);

        return view('honorable.edit', compact('honorable'));
    }

    public function update(Request $request, $id)
    {
        $honorable = Honorable::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $honorable->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $honorable->document;
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:40',
            'middle_name' => 'nullable|string|max:40',
            'last_name' => 'required|string|max:40',
            'gender' => 'required|string|max:7',
            'age' => 'required|integer|digits_between:1,3',
            'address' => 'nullable|string|max:255',
            'contact_number' => 'nullable|numeric|digits_between:9,14',
            'email' => 'nullable|email|max:255|unique:honorables,email,' . $honorable->id,
            'position' => 'nullable|string|max:255',
            'membership_type' => 'nullable|string|max:255',
            'membership_fee' => 'nullable|integer',
        ]);


        $honorable->update($validated);

        return redirect()->route('honorable.index')->with('update', 'Honorable Updated successfully');
    }

    public function destroy($id)
    {
        $honorable = Honorable::findOrFail($id);
        $honorable->delete();

        return redirect()->route('honorable.index')->with('delete', 'Honorable Deleted successfully');
    }
    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $maxId = Honorable::max('id');

        $file = $request->file('file');
        Excel::import(new HonorableImport($maxId), $file);

        return redirect()->route('honorable.index');
    }
    public function pay($id)
    {
        $member = Honorable::findOrFail($id);
        return view('honorableMemberPay.create', compact('member'));
    }
}
