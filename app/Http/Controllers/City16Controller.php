<?php

namespace App\Http\Controllers;

use App\Models\City16;
use App\Imports\City16Import;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class City16Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:city16-list|city16-create|city16-edit|city16-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:city16-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:city16-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:city16-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $count = City16::count();

        return view('cities.city16.index', compact('count'));
    }

    public function create()
    {
        return view('cities.city16.create');
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
            'email' => 'nullable|email|unique:city16s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);

        $city16 = City16::create($validated);

        return redirect()->route('city16.index')->with('success', 'City16 Created successfully');
    }

    public function show($id)
    {
        $city16 = City16::findOrFail($id);
    }

    public function edit($id)
    {
        $city16 = City16::findOrFail($id);

        return view('cities.city16.edit', compact('city16'));
    }

    public function update(Request $request, $id)
    {
        $city16 = City16::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $city16->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $city16->document;
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
            'email' => 'nullable|email|unique:city16s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);


        $city16->update($validated);

        return redirect()->route('city16.index')->with('update', 'City16 Updated successfully');
    }

    public function destroy($id)
    {
        $city16 = City16::findOrFail($id);
        $city16->delete();

        return redirect()->route('city16.index')->with('delete', 'City16 Deleted successfully');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $maxId = City16::max('id');

        $file = $request->file('file');
        Excel::import(new City16Import($maxId), $file);

        return redirect()->route('city16.index');
    }
    public function pay($id)
    {
        $member = city16::findOrFail($id);
        $model = "city16";
        return view('cities.cityMemberPay.create', compact('member', 'model'));
    }
}
