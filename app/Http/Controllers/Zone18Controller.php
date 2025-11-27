<?php

namespace App\Http\Controllers;

use App\Models\Zone18;
use Illuminate\Http\Request;
use App\Imports\Zone18Import;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class Zone18Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:zone18-list|zone18-create|zone18-edit|zone18-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:zone18-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:zone18-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:zone18-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $count = Zone18::count();

        return view('zones.zone18.index', compact('count'));
    }

    public function create()
    {

        $woredas = [
            'Ammayyaa',
            'Wancii',
            'Gooroo',
            'A/Walisoo',
            'Bachoo',
            'Dawoo',
            'S/Soddoo',
            'Tolee',
            'Iluu',
            'Q/Maliimmaa',
            'S/Dacii',
        ];

        $options = [];
        foreach ($woredas as $woreda) {
            $options[] = ['id' => $woreda, 'text' => $woreda];
        }

        $jsonOptions = json_encode($options);

        return view('zones.zone18.create');
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
            'email' => 'nullable|email|unique:zone18s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);

        $zone18 = Zone18::create($validated);

        return redirect()->route('zone18.index')->with('success', 'Zone18 Created successfully');
    }

    public function show($id)
    {
        $zone18 = Zone18::findOrFail($id);
    }

    public function edit($id)
    {
        $zone18 = Zone18::findOrFail($id);

        return view('zones.zone18.edit', compact('zone18'));
    }

    public function update(Request $request, $id)
    {
        $zone18 = Zone18::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $zone18->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $zone18->document;
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
            'email' => 'nullable|email|unique:zone18s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);


        $zone18->update($validated);

        return redirect()->route('zone18.index')->with('update', 'Zone18 Updated successfully');
    }

    public function destroy($id)
    {
        $zone18 = Zone18::findOrFail($id);
        $zone18->delete();

        return redirect()->route('zone18.index')->with('delete', 'Zone18 Deleted successfully');
    }
    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
        try {



            $maxId = Zone18::max('id');

            $file = $request->file('file');
            Excel::import(new Zone18Import($maxId), $file);

            return redirect()->route('zone18.index')->with('success', 'Zone18 Imported successfully');
        } catch (\Exception $e) {
            // return redirect()->back()->withErrors($e->getMessage());
            return redirect()->back();
        }
    }
    public function pay($id)
    {
        $member = Zone18::findOrFail($id);
        $model = "zone18";
        return view('zones.zoneMemberPay.create', compact('member', 'model'));
    }
}
