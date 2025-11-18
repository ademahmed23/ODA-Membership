<?php

namespace App\Http\Controllers;

use App\Models\Regional;
use App\Imports\RegionalImport;
use App\Models\Country;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class RegionalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:regional-list|regional-create|regional-edit|regional-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:regional-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:regional-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:regional-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $count = Regional::count();

        return view('regional.index', compact('count'));
    }

    public function create()
    {
        $regions = Region::all();
        return view('regional.create', compact('regions'));
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
            'region' => 'required|string',
            'address' => 'nullable|string',
            'contact_number' => 'nullable|numeric|digits_between:9,14',
            'woreda' => 'nullable|string',
            'email' => 'nullable|email|unique:regionals',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);

        $regional = Regional::create($validated);

        return redirect()->route('regional.index')->with('success', 'Regional Created successfully');
    }

    public function show($id)
    {
        $regional = Regional::findOrFail($id);
    }

    public function edit($id)
    {
        $regions = Region::all();
        $regional = Regional::findOrFail($id);

        return view('regional.edit', compact('regional', 'regions'));
    }

    public function update(Request $request, $id)
    {
        $regional = Regional::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $regional->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $regional->document;
        }

        $validated = $request->validate([
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'required|string',
            'gender' => 'required|string',
            'age' => 'required|integer',
            'region' => 'required|string',
            'address' => 'nullable|string',
            'contact_number' => 'nullable|numeric|digits_between:9,14',
            'woreda' => 'nullable|string',
            'email' => 'nullable|email|unique:regionals',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);


        $regional->update($validated);

        return redirect()->route('regional.index')->with('update', 'Regional Updated successfully');
    }

    public function destroy($id)
    {
        $regional = Regional::findOrFail($id);
        $regional->delete();

        return redirect()->route('regional.index')->with('delete', 'Regional Deleted successfully');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $maxId = Regional::max('id');

        $file = $request->file('file');
        Excel::import(new RegionalImport($maxId), $file);

        return redirect()->route('regional.index');
    }
    public function pay($id)
    {
        $member = Regional::findOrFail($id);
        return view('regionMemberPay.create', compact('member'));
    }
}
