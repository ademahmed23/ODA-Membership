<?php

namespace App\Http\Controllers;

use App\Models\City14;
use App\Imports\City14Import;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class City14Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:city14-list|city14-create|city14-edit|city14-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:city14-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:city14-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:city14-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $count = City14::count();

        return view('city14.index', compact('count'));
    }

    public function create()
    {
        return view('city14.create');
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
            'email' => 'nullable|email|unique:city14s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);

        $city14 = City14::create($validated);

        return redirect()->route('city14.index')->with('success', 'City14 Created successfully');
    }

    public function show($id)
    {
        $city14 = City14::findOrFail($id);
    }

    public function edit($id)
    {
        $city14 = City14::findOrFail($id);

        return view('city14.edit', compact('city14'));
    }

    public function update(Request $request, $id)
    {
        $city14 = City14::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $city14->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $city14->document;
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
            'email' => 'nullable|email|unique:city14s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);


        $city14->update($validated);

        return redirect()->route('city14.index')->with('update', 'City14 Updated successfully');
    }

    public function destroy($id)
    {
        $city14 = City14::findOrFail($id);
        $city14->delete();

        return redirect()->route('city14.index')->with('delete', 'City14 Deleted successfully');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $maxId = City14::max('id');

        $file = $request->file('file');
        Excel::import(new City14Import($maxId), $file);

        return redirect()->route('city14.index');
    }
    public function pay($id)
    {
        $member = city14::findOrFail($id);
        $model = "city14";
        return view('cityMemberPay.create', compact('member', 'model'));
    }
}
