<?php

namespace App\Http\Controllers;

use App\Models\Zone11;
use Illuminate\Http\Request;
use App\Imports\Zone11Import;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class Zone11Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:zone11-list|zone11-create|zone11-edit|zone11-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:zone11-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:zone11-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:zone11-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $count = Zone11::count();

        return view('zone11.index', compact('count'));
    }

    public function create()
    {
        $woredas = [
            'Ancaar',
            'Bookee',
            'B/Dhimtu',
            'A/Ciroo',
            'D/Labuu',
            'Doobaa',
            'Gammachis',
            'G/Bordode',
            'G/Qoricha',
            'Habro',
            'H/Gudinaa',
            'SH/Dhuugo',
            'Mi,eessoo',
            'O/Bultum',
            'Xuulloo',
            'M/Baddees',
            'Mag/Ciroo'
        ];

        $options = [];
        foreach ($woredas as $woreda) {
            $options[] = ['id' => $woreda, 'text' => $woreda];
        }

        $jsonOptions = json_encode($options);

        return view('zone11.create', compact('jsonOptions'));
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
            'email' => 'nullable|email|unique:zone11s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);

        $zone11 = Zone11::create($validated);

        return redirect()->route('zone11.index')->with('success', 'Zone11 Created successfully');
    }

    public function show($id)
    {
        $zone11 = Zone11::findOrFail($id);
    }

    public function edit($id)
    {
        $zone11 = Zone11::findOrFail($id);

        return view('zone11.edit', compact('zone11'));
    }

    public function update(Request $request, $id)
    {
        $zone11 = Zone11::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $zone11->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $zone11->document;
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
            'email' => 'nullable|email|unique:zone11s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);


        $zone11->update($validated);

        return redirect()->route('zone11.index')->with('update', 'Zone11 Updated successfully');
    }

    public function destroy($id)
    {
        $zone11 = Zone11::findOrFail($id);
        $zone11->delete();

        return redirect()->route('zone11.index')->with('delete', 'Zone11 Deleted successfully');
    }
    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
        try {



            $maxId = Zone11::max('id');

            $file = $request->file('file');
            Excel::import(new Zone11Import($maxId), $file);

            return redirect()->route('zone11.index')->with('success', 'Zone11 Imported successfully');
        } catch (\Exception $e) {
            // return redirect()->back()->withErrors($e->getMessage());
            return redirect()->back();
        }
    }
    public function pay($id)
    {
        $member = Zone11::findOrFail($id);
        $model = "zone11";
        return view('zoneMemberPay.create', compact('member', 'model'));
    }
}
