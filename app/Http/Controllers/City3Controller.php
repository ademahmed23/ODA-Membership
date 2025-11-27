<?php

namespace App\Http\Controllers;

use App\Models\City3;
use App\Imports\City3Import;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class City3Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:city3-list|city3-create|city3-edit|city3-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:city3-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:city3-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:city3-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $count = City3::count();

        return view('cities.city3.index', compact('count'));
    }

    public function create()
    {
        return view('cities.city3.create');
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
            'email' => 'nullable|email|unique:city3s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);

        $city3 = City3::create($validated);

        return redirect()->route('city3.index')->with('success', 'City3 Created successfully');
    }

    public function show($id)
    {
        $city3 = City3::findOrFail($id);
    }

    public function edit($id)
    {
        $city3 = City3::findOrFail($id);

        return view('cities.city3.edit', compact('city3'));
    }

    public function update(Request $request, $id)
    {
        $city3 = City3::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $city3->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $city3->document;
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
            'email' => 'nullable|email|unique:city3s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);


        $city3->update($validated);

        return redirect()->route('city3.index')->with('update', 'City3 Updated successfully');
    }

    public function destroy($id)
    {
        $city3 = City3::findOrFail($id);
        $city3->delete();

        return redirect()->route('city3.index')->with('delete', 'City3 Deleted successfully');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $maxId = City3::max('id');

        $file = $request->file('file');
        Excel::import(new City3Import($maxId), $file);

        return redirect()->route('city3.index');
    }
    public function pay($id)
    {
        $member = City3::findOrFail($id);
        $model = "city3";
        return view('cities.cityMemberPay.create', compact('member', 'model'));
    }
}
