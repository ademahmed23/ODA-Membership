<?php

namespace App\Http\Controllers;

use App\Models\City17;
use App\Imports\City17Import;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class City17Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:city17-list|city17-create|city17-edit|city17-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:city17-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:city17-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:city17-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $count = City17::count();

        return view('cities.city17.index', compact('count'));
    }

    public function create()
    {
        return view('cities.city17.create');
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
            'email' => 'nullable|email|unique:city17s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);

        $city17 = City17::create($validated);

        return redirect()->route('city17.index')->with('success', 'City17 Created successfully');
    }

    public function show($id)
    {
        $city17 = City17::findOrFail($id);
    }

    public function edit($id)
    {
        $city17 = City17::findOrFail($id);

        return view('cities.city17.edit', compact('city17'));
    }

    public function update(Request $request, $id)
    {
        $city17 = City17::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $city17->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $city17->document;
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
            'email' => 'nullable|email|unique:city17s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);


        $city17->update($validated);

        return redirect()->route('city17.index')->with('update', 'City17 Updated successfully');
    }

    public function destroy($id)
    {
        $city17 = City17::findOrFail($id);
        $city17->delete();

        return redirect()->route('city17.index')->with('delete', 'City17 Deleted successfully');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $maxId = City17::max('id');

        $file = $request->file('file');
        Excel::import(new City17Import($maxId), $file);

        return redirect()->route('city17.index');
    }
    public function pay($id)
    {
        $member = city17::findOrFail($id);
        $model = "city17";
        return view('cities.cityMemberPay.create', compact('member', 'model'));
    }
}
