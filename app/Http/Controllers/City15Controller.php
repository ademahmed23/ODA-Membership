<?php

namespace App\Http\Controllers;

use App\Models\City15;
use App\Imports\City15Import;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class City15Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:city15-list|city15-create|city15-edit|city15-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:city15-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:city15-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:city15-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $count = City15::count();

        return view('city15.index', compact('count'));
    }

    public function create()
    {
        return view('city15.create');
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
            'email' => 'nullable|email|unique:city15s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);

        $city15 = City15::create($validated);

        return redirect()->route('city15.index')->with('success', 'City15 Created successfully');
    }

    public function show($id)
    {
        $city15 = City15::findOrFail($id);
    }

    public function edit($id)
    {
        $city15 = City15::findOrFail($id);

        return view('city15.edit', compact('city15'));
    }

    public function update(Request $request, $id)
    {
        $city15 = City15::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $city15->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $city15->document;
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
            'email' => 'nullable|email|unique:city15s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);


        $city15->update($validated);

        return redirect()->route('city15.index')->with('update', 'City15 Updated successfully');
    }

    public function destroy($id)
    {
        $city15 = City15::findOrFail($id);
        $city15->delete();

        return redirect()->route('city15.index')->with('delete', 'City15 Deleted successfully');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $maxId = City15::max('id');

        $file = $request->file('file');
        Excel::import(new City15Import($maxId), $file);

        return redirect()->route('city15.index');
    }
    public function pay($id)
    {
        $member = city15::findOrFail($id);
        $model = "city15";
        return view('cityMemberPay.create', compact('member', 'model'));
    }
}
