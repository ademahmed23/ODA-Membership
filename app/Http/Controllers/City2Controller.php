<?php

namespace App\Http\Controllers;

use App\Models\City2;
use App\Imports\City2Import;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class City2Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:city2-list|city2-create|city2-edit|city2-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:city2-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:city2-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:city2-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $count = City2::count();

        return view('cities.city2.index', compact('count'));
    }

    public function create()
    {
        return view('cities.city2.create');
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
            'email' => 'nullable|email|unique:city2s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);

        $city2 = City2::create($validated);

        return redirect()->route('city2.index')->with('success', 'City2 Created successfully');
    }

    public function show($id)
    {
        $city2 = City2::findOrFail($id);
    }

    public function edit($id)
    {
        $city2 = City2::findOrFail($id);

        return view('cities.city2.edit', compact('city2'));
    }

    public function update(Request $request, $id)
    {
        $city2 = City2::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $city2->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $city2->document;
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
            'email' => 'nullable|email|unique:city2s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);


        $city2->update($validated);

        return redirect()->route('city2.index')->with('update', 'City2 Updated successfully');
    }

    public function destroy($id)
    {
        $city2 = City2::findOrFail($id);
        $city2->delete();

        return redirect()->route('city2.index')->with('delete', 'City2 Deleted successfully');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $maxId = City2::max('id');

        $file = $request->file('file');
        Excel::import(new City2Import($maxId), $file);

        return redirect()->route('city2.index');
    }
    public function pay($id)
    {
        $member = City2::findOrFail($id);
        $model = "city2";
        return view('cities.cityMemberPay.create', compact('member', 'model'));
    }
}
