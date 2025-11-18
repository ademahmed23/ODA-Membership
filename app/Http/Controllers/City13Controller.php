<?php

namespace App\Http\Controllers;

use App\Models\City13;
use App\Imports\City13Import;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class City13Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:city13-list|city13-create|city13-edit|city13-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:city13-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:city13-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:city13-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $count = City13::count();

        return view('city13.index', compact('count'));
    }

    public function create()
    {
        return view('city13.create');
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
            'email' => 'nullable|email|unique:city13s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);

        $city13 = City13::create($validated);

        return redirect()->route('city13.index')->with('success', 'City13 Created successfully');
    }

    public function show($id)
    {
        $city13 = City13::findOrFail($id);
    }

    public function edit($id)
    {
        $city13 = City13::findOrFail($id);

        return view('city13.edit', compact('city13'));
    }

    public function update(Request $request, $id)
    {
        $city13 = City13::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $city13->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $city13->document;
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
            'email' => 'nullable|email|unique:city13s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);


        $city13->update($validated);

        return redirect()->route('city13.index')->with('update', 'City13 Updated successfully');
    }

    public function destroy($id)
    {
        $city13 = City13::findOrFail($id);
        $city13->delete();

        return redirect()->route('city13.index')->with('delete', 'City13 Deleted successfully');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $maxId = City13::max('id');

        $file = $request->file('file');
        Excel::import(new City13Import($maxId), $file);

        return redirect()->route('city13.index');
    }
    public function pay($id)
    {
        $member = city13::findOrFail($id);
        $model = "city13";
        return view('cityMemberPay.create', compact('member', 'model'));
    }
}
