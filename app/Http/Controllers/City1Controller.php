<?php

namespace App\Http\Controllers;

use App\Models\City1;
use App\Imports\City1Import;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class City1Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:city1-list|city1-create|city1-edit|city1-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:city1-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:city1-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:city1-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $count = City1::count();

        return view('city1.index', compact('count'));
    }

    public function create()
    {
        return view('city1.create');
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
            'email' => 'nullable|email|unique:city1s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);

        $city1 = City1::create($validated);

        return redirect()->route('city1.index')->with('success', 'City1 Created successfully');
    }

    public function show($id)
    {
        $city1 = City1::findOrFail($id);
    }

    public function edit($id)
    {
        $city1 = City1::findOrFail($id);

        return view('city1.edit', compact('city1'));
    }

    public function update(Request $request, $id)
    {
        $city1 = City1::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $city1->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $city1->document;
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
            'email' => 'nullable|email|unique:city1s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);


        $city1->update($validated);

        return redirect()->route('city1.index')->with('update', 'City1 Updated successfully');
    }

    public function destroy($id)
    {
        $city1 = City1::findOrFail($id);
        $city1->delete();

        return redirect()->route('city1.index')->with('delete', 'City1 Deleted successfully');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $maxId = City1::max('id');

        $file = $request->file('file');
        Excel::import(new City1Import($maxId), $file);

        return redirect()->route('city1.index');
    }
    public function pay($id)
    {
        $member = City1::findOrFail($id);
        $model = "city1";
        return view('cityMemberPay.create', compact('member', 'model'));
    }
}
