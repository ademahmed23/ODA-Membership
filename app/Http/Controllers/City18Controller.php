<?php

namespace App\Http\Controllers;

use App\Models\City18;
use App\Imports\City18Import;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class City18Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:city18-list|city18-create|city18-edit|city18-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:city18-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:city18-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:city18-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $count = City18::count();

        return view('city18.index', compact('count'));
    }

    public function create()
    {
        return view('city18.create');
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
            'email' => 'nullable|email|unique:city18s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);

        $city18 = City18::create($validated);

        return redirect()->route('city18.index')->with('success', 'City18 Created successfully');
    }

    public function show($id)
    {
        $city18 = City18::findOrFail($id);
    }

    public function edit($id)
    {
        $city18 = City18::findOrFail($id);

        return view('city18.edit', compact('city18'));
    }

    public function update(Request $request, $id)
    {
        $city18 = City18::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $city18->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $city18->document;
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
            'email' => 'nullable|email|unique:city18s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);


        $city18->update($validated);

        return redirect()->route('city18.index')->with('update', 'City18 Updated successfully');
    }

    public function destroy($id)
    {
        $city18 = City18::findOrFail($id);
        $city18->delete();

        return redirect()->route('city18.index')->with('delete', 'City18 Deleted successfully');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $maxId = City18::max('id');

        $file = $request->file('file');
        Excel::import(new City18Import($maxId), $file);

        return redirect()->route('city18.index');
    }
    public function pay($id)
    {
        $member = city18::findOrFail($id);
        $model = "city18";
        return view('cityMemberPay.create', compact('member', 'model'));
    }
}
