<?php

namespace App\Http\Controllers;

use App\Models\City5;
use App\Imports\City5Import;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class City5Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:city5-list|city5-create|city5-edit|city5-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:city5-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:city5-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:city5-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $count = City5::count();

        return view('city5.index', compact('count'));
    }

    public function create()
    {
        return view('city5.create');
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
            'email' => 'nullable|email|unique:city5s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);

        $city5 = City5::create($validated);

        return redirect()->route('city5.index')->with('success', 'City5 Created successfully');
    }

    public function show($id)
    {
        $city5 = City5::findOrFail($id);
    }

    public function edit($id)
    {
        $city5 = City5::findOrFail($id);

        return view('city5.edit', compact('city5'));
    }

    public function update(Request $request, $id)
    {
        $city5 = City5::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $city5->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $city5->document;
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
            'email' => 'nullable|email|unique:city5s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);


        $city5->update($validated);

        return redirect()->route('city5.index')->with('update', 'City5 Updated successfully');
    }

    public function destroy($id)
    {
        $city5 = City5::findOrFail($id);
        $city5->delete();

        return redirect()->route('city5.index')->with('delete', 'City5 Deleted successfully');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $maxId = City5::max('id');

        $file = $request->file('file');
        Excel::import(new City5Import($maxId), $file);

        return redirect()->route('city5.index');
    }
    public function pay($id)
    {
        $member = city5::findOrFail($id);
        $model = "city5";
        return view('cityMemberPay.create', compact('member', 'model'));
    }
}
