<?php

namespace App\Http\Controllers;

use App\Models\City19;
use App\Imports\City19Import;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class City19Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:city19-list|city19-create|city19-edit|city19-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:city19-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:city19-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:city19-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $count = City19::count();

        return view('city19.index', compact('count'));
    }

    public function create()
    {
        return view('city19.create');
    }

    public function store(Request $request)
    {
        //  $table->string('first_name');
        // $table->string('middle_name')->nullable();
        // $table->string('last_name');
        // $table->string('gender');
        // $table->integer('age');
        // $table->string('address')->nullable();
        // $table->string('contact_number');
        // $table->string('email')->nullable();
        // $table->string('position')->nullable();
        // $table->string('membership_type')->nullable();
        // $table->integer('membership_fee')->nullable();

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

        $validated = $request->validate([
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'required|string',
            'gender' => 'required|string',
            'age' => 'required|integer',
            'address' => 'nullable|string',
            'contact_number' => 'nullable|numeric|digits_between:9,14',
            'woreda' => 'nullable|string',
            'email' => 'nullable|email|unique:city19s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);

        $city19 = City19::create($validated);

        return redirect()->route('city19.index')->with('success', 'City19 Created successfully');
    }

    public function show($id)
    {
        $city19 = City19::findOrFail($id);
    }

    public function edit($id)
    {
        $city19 = City19::findOrFail($id);

        return view('city19.edit', compact('city19'));
    }

    public function update(Request $request, $id)
    {
        $city19 = City19::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $city19->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $city19->document;
        }

        $validated = $request->validate([
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'required|string',
            'gender' => 'required|string',
            'age' => 'required|integer',
            'address' => 'nullable|string',
            'contact_number' => 'nullable|numeric|digits_between:9,14',
            'woreda' => 'nullable|string',
            'email' => 'nullable|email|unique:city19s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);


        $city19->update($validated);

        return redirect()->route('city19.index')->with('update', 'City19 Updated successfully');
    }

    public function destroy($id)
    {
        $city19 = City19::findOrFail($id);
        $city19->delete();

        return redirect()->route('city19.index')->with('delete', 'City19 Deleted successfully');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $maxId = City19::max('id');

        $file = $request->file('file');
        Excel::import(new City19Import($maxId), $file);

        return redirect()->route('city19.index');
    }
    public function pay($id)
    {
        $member = city19::findOrFail($id);
        $model = "city19";
        return view('cityMemberPay.create', compact('member', 'model'));
    }
}
