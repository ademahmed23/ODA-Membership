<?php

namespace App\Http\Controllers;

use App\Models\Zone10;
use Illuminate\Http\Request;
use App\Imports\Zone10Import;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class Zone10Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:zone10-list|zone10-create|zone10-edit|zone10-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:zone10-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:zone10-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:zone10-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $count = Zone10::count();

        return view('zones.zone10.index', compact('count'));
    }

    public function create()
    {
        $woredas = [
            'Malkaabal oo',
            'Aanaa Dadar',
            'Gooroo Guutuu',
            'Meettaa',
            'Gooroo Muxii',
            'Qarsaa',
            'Aanaa Haramaayaa',
            'Kurfaa Callee',
            'Gurawaa',
            'Mayyuu Muluqqee',
            'Baddannoo',
            'Gola Odaa',
            'Qumbii',
            'Cinaaksaan',
            'Gursum',
            'Aanaa Baabbilee',
            'Jaarsoo',
            'Kombolchaa',
            'Miidhagaa Tola',
            'Fadis',
            'Bu/Ma/Dadar',
            'Bu/Ma/Haramaayaa',
            'Bu/Ma/Awwadaay',
            'Bu/Ma/Baabbilee',


        ];

        $options = [];
        foreach ($woredas as $woreda) {
            $options[] = ['id' => $woreda, 'text' => $woreda];
        }

        $jsonOptions = json_encode($options);

        return view('zones.zone10.create', compact('jsonOptions'));
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
            'email' => 'nullable|email|unique:zone10s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);

        $zone10 = Zone10::create($validated);

        return redirect()->route('zone10.index')->with('success', 'Zone10 Created successfully');
    }

    public function show($id)
    {
        $zone10 = Zone10::findOrFail($id);
    }

    public function edit($id)
    {
        $zone10 = Zone10::findOrFail($id);

        return view('zones.zone10.edit', compact('zone10'));
    }

    public function update(Request $request, $id)
    {
        $zone10 = Zone10::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $zone10->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $zone10->document;
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
            'email' => 'nullable|email|unique:zone10s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);


        $zone10->update($validated);

        return redirect()->route('zone10.index')->with('update', 'Zone10 Updated successfully');
    }

    public function destroy($id)
    {
        $zone10 = Zone10::findOrFail($id);
        $zone10->delete();

        return redirect()->route('zone10.index')->with('delete', 'Zone10 Deleted successfully');
    }
    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
        try {



            $maxId = Zone10::max('id');

            $file = $request->file('file');
            Excel::import(new Zone10Import($maxId), $file);

            return redirect()->route('zone10.index')->with('success', 'Zone10 Imported successfully');
        } catch (\Exception $e) {
            // return redirect()->back()->withErrors($e->getMessage());
            return redirect()->back();
        }
    }
    public function pay($id)
    {
        $member = Zone10::findOrFail($id);
        $model = "zone10";
        return view('zones.zoneMemberPay.create', compact('member', 'model'));
    }
}
