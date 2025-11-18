<?php

namespace App\Http\Controllers;

use App\Models\Abroad;
use App\Imports\AbroadImport;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class AbroadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:abroad-list|abroad-create|abroad-edit|abroad-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:abroad-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:abroad-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:abroad-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $count = Abroad::count();

        return view('abroad.index', compact('count'));
    }

    public function create()
    {
        $countries = Country::all();
        return view('abroad.create', compact('countries'));
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
            'country' => 'required|string',
            'address' => 'nullable|string',
            'contact_number' => 'nullable|numeric|digits_between:9,14',
            'woreda' => 'nullable|string',
            'email' => 'nullable|email|unique:abroads',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);

        $abroad = Abroad::create($validated);

        return redirect()->route('abroad.index')->with('success', 'Abroad Created successfully');
    }

    public function show($id)
    {
        $abroad = Abroad::findOrFail($id);
    }

    public function edit($id)
    {
        $countries = Country::all();
        $abroad = Abroad::findOrFail($id);

        return view('abroad.edit', compact('abroad', 'countries'));
    }

    public function update(Request $request, $id)
    {
        $abroad = Abroad::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $abroad->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $abroad->document;
        }

        $validated = $request->validate([
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'required|string',
            'gender' => 'required|string',
            'age' => 'required|integer',
            'country' => 'required|string',
            'address' => 'nullable|string',
            'contact_number' => 'nullable|numeric|digits_between:9,14',
            'woreda' => 'nullable|string',
            'email' => 'nullable|email|unique:abroads',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);


        $abroad->update($validated);

        return redirect()->route('abroad.index')->with('update', 'Abroad Updated successfully');
    }

    public function destroy($id)
    {
        $abroad = Abroad::findOrFail($id);
        $abroad->delete();

        return redirect()->route('abroad.index')->with('delete', 'Abroad Deleted successfully');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $maxId = Abroad::max('id');

        $file = $request->file('file');
        Excel::import(new AbroadImport($maxId), $file);

        return redirect()->route('abroad.index');
    }
    public function pay($id)
    {
        $member = Abroad::findOrFail($id);
        return view('abroadMemberPay.create', compact('member'));
    }
}
