<?php

namespace App\Http\Controllers;

use App\Models\City12;
use App\Imports\City12Import;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class City12Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:city12-list|city12-create|city12-edit|city12-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:city12-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:city12-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:city12-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $count = City12::count();

        return view('city12.index', compact('count'));
    }

    public function create()
    {
        return view('city12.create');
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
            'email' => 'nullable|email|unique:city12s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);

        $city12 = City12::create($validated);

        return redirect()->route('city12.index')->with('success', 'City12 Created successfully');
    }

    public function show($id)
    {
        $city12 = City12::findOrFail($id);
    }

    public function edit($id)
    {
        $city12 = City12::findOrFail($id);

        return view('city12.edit', compact('city12'));
    }

    public function update(Request $request, $id)
    {
        $city12 = City12::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $city12->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $city12->document;
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
            'email' => 'nullable|email|unique:city12s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);


        $city12->update($validated);

        return redirect()->route('city12.index')->with('update', 'City12 Updated successfully');
    }

    public function destroy($id)
    {
        $city12 = City12::findOrFail($id);
        $city12->delete();

        return redirect()->route('city12.index')->with('delete', 'City12 Deleted successfully');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $maxId = City12::max('id');

        $file = $request->file('file');
        Excel::import(new City12Import($maxId), $file);

        return redirect()->route('city12.index');
    }
    public function pay($id)
    {
        $member = city12::findOrFail($id);
        $model = "city12";
        return view('cityMemberPay.create', compact('member', 'model'));
    }
}
