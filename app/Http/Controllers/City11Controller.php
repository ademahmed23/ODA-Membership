<?php

namespace App\Http\Controllers;

use App\Models\City11;
use App\Imports\City11Import;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class City11Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:city11-list|city11-create|city11-edit|city11-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:city11-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:city11-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:city11-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $count = City11::count();

        return view('city11.index', compact('count'));
    }

    public function create()
    {
        return view('city11.create');
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
            'email' => 'nullable|email|unique:city11s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);

        $city11 = City11::create($validated);

        return redirect()->route('city11.index')->with('success', 'City11 Created successfully');
    }

    public function show($id)
    {
        $city11 = City11::findOrFail($id);
    }

    public function edit($id)
    {
        $city11 = City11::findOrFail($id);

        return view('city11.edit', compact('city11'));
    }

    public function update(Request $request, $id)
    {
        $city11 = City11::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $city11->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $city11->document;
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
            'email' => 'nullable|email|unique:city11s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);


        $city11->update($validated);

        return redirect()->route('city11.index')->with('update', 'City11 Updated successfully');
    }

    public function destroy($id)
    {
        $city11 = City11::findOrFail($id);
        $city11->delete();

        return redirect()->route('city11.index')->with('delete', 'City11 Deleted successfully');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $maxId = City11::max('id');

        $file = $request->file('file');
        Excel::import(new City11Import($maxId), $file);

        return redirect()->route('city11.index');
    }
    public function pay($id)
    {
        $member = city11::findOrFail($id);
        $model = "city11";
        return view('cityMemberPay.create', compact('member', 'model'));
    }
}
