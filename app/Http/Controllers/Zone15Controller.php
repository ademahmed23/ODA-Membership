<?php

namespace App\Http\Controllers;

use App\Models\Zone15;
use Illuminate\Http\Request;
use App\Imports\Zone15Import;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class Zone15Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:zone15-list|zone15-create|zone15-edit|zone15-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:zone15-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:zone15-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:zone15-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $count = Zone15::count();

        return view('zone15.index', compact('count'));
    }

    public function create()
    {
//         Gidaamii
// J-Hoorroo
// G-Qeebbee
// D-Wabaaraa
// S-Canqaa
// D-Sadii
// L-Qilee
// Y-Walal
// H-Galaan
// D-Doolloo
// Sayyoo
// Anfilloo

        $woredas = [
            'Gidaamii',
            'J-Hoorroo',
            'G-Qeebbee',
            'D-Wabaaraa',
            'S-Canqaa',
            'D-Sadii',
            'L-Qilee',
            'Y-Walal',
            'H-Galaan',
            'D-Doolloo',
            'Sayyoo',
            'Anfilloo',
        ];

        $options = [];
        foreach ($woredas as $woreda) {
            $options[] = ['id' => $woreda, 'text' => $woreda];
        }

        $jsonOptions = json_encode($options);

        return view('zone15.create');
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
            'email' => 'nullable|email|unique:zone15s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);

        $zone15 = Zone15::create($validated);

        return redirect()->route('zone15.index')->with('success', 'Zone15 Created successfully');
    }

    public function show($id)
    {
        $zone15 = Zone15::findOrFail($id);
    }

    public function edit($id)
    {
        $zone15 = Zone15::findOrFail($id);

        return view('zone15.edit', compact('zone15'));
    }

    public function update(Request $request, $id)
    {
        $zone15 = Zone15::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $zone15->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $zone15->document;
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
            'email' => 'nullable|email|unique:zone15s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);


        $zone15->update($validated);

        return redirect()->route('zone15.index')->with('update', 'Zone15 Updated successfully');
    }

    public function destroy($id)
    {
        $zone15 = Zone15::findOrFail($id);
        $zone15->delete();

        return redirect()->route('zone15.index')->with('delete', 'Zone15 Deleted successfully');
    }
    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
        try {



            $maxId = Zone15::max('id');

            $file = $request->file('file');
            Excel::import(new Zone15Import($maxId), $file);

            return redirect()->route('zone15.index')->with('success', 'Zone15 Imported successfully');
        } catch (\Exception $e) {
            // return redirect()->back()->withErrors($e->getMessage());
            return redirect()->back();
        }
    }
    public function pay($id)
    {
        $member = Zone15::findOrFail($id);
        $model = "zone15";
        return view('zoneMemberPay.create', compact('member', 'model'));
    }
}
