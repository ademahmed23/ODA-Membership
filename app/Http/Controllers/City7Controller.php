<?php

namespace App\Http\Controllers;

use App\Models\City7;
use App\Imports\City7Import;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class City7Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:city7-list|city7-create|city7-edit|city7-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:city7-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:city7-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:city7-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $count = City7::count();

        return view('cities.city7.index', compact('count'));
    }

    public function create()
    {
        return view('cities.city7.create');
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
            'email' => 'nullable|email|unique:city7s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);

        $city7 = City7::create($validated);

        return redirect()->route('city7.index')->with('success', 'City7 Created successfully');
    }

    public function show($id)
    {
        $city7 = City7::findOrFail($id);
    }

    public function edit($id)
    {
        $city7 = City7::findOrFail($id);

        return view('cities.city7.edit', compact('city7'));
    }

    public function update(Request $request, $id)
    {
        $city7 = City7::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $city7->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $city7->document;
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
            'email' => 'nullable|email|unique:city7s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);


        $city7->update($validated);

        return redirect()->route('city7.index')->with('update', 'City7 Updated successfully');
    }

    public function destroy($id)
    {
        $city7 = City7::findOrFail($id);
        $city7->delete();

        return redirect()->route('city7.index')->with('delete', 'City7 Deleted successfully');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $maxId = City7::max('id');

        $file = $request->file('file');
        Excel::import(new City7Import($maxId), $file);

        return redirect()->route('city7.index');
    }
    public function pay($id)
    {
        $member = city7::findOrFail($id);
        $model = "city7";
        return view('cities.cityMemberPay.create', compact('member', 'model'));
    }
}
