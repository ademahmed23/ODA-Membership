<?php

namespace App\Http\Controllers;

use App\Models\City8;
use App\Imports\City8Import;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class City8Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:city8-list|city8-create|city8-edit|city8-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:city8-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:city8-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:city8-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $count = City8::count();

        return view('city8.index', compact('count'));
    }

    public function create()
    {
        return view('city8.create');
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
            'email' => 'nullable|email|unique:city8s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);

        $city8 = City8::create($validated);

        return redirect()->route('city8.index')->with('success', 'City8 Created successfully');
    }

    public function show($id)
    {
        $city8 = City8::findOrFail($id);
    }

    public function edit($id)
    {
        $city8 = City8::findOrFail($id);

        return view('city8.edit', compact('city8'));
    }

    public function update(Request $request, $id)
    {
        $city8 = City8::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $city8->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $city8->document;
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
            'email' => 'nullable|email|unique:city8s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);


        $city8->update($validated);

        return redirect()->route('city8.index')->with('update', 'City8 Updated successfully');
    }

    public function destroy($id)
    {
        $city8 = City8::findOrFail($id);
        $city8->delete();

        return redirect()->route('city8.index')->with('delete', 'City8 Deleted successfully');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $maxId = City8::max('id');

        $file = $request->file('file');
        Excel::import(new City8Import($maxId), $file);

        return redirect()->route('city8.index');
    }
    public function pay($id)
    {
        $member = city8::findOrFail($id);
        $model = "city8";
        return view('cityMemberPay.create', compact('member', 'model'));
    }
}
