<?php

namespace App\Http\Controllers;

use App\Models\Zone12;
use Illuminate\Http\Request;
use App\Imports\Zone12Import;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class Zone12Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:zone12-list|zone12-create|zone12-edit|zone12-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:zone12-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:zone12-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:zone12-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $count = Zone12::count();

        return view('zones.zone12.index', compact('count'));
    }

    public function create()
    {
        // Abee Dongooroo
        // Amuuruu
        // Abbay Coommaan
        // Jimmaa Gannaat
        // Jimmaa Raaree
        // Jardaagaa Jaartee
        // Abaaboo Guduruu
        // Hoorroo
        // Hoorroo Bulluq
        // Guduruu
        // Coommaan Guduruu
        // B_M_Shaambuu
        // Sulula Fincaa’a

        $woredas = [
            'Abee Dongooroo',
            'Amuuruu',
            'Abbay Coommaan',
            'Jimmaa Gannaat',
            'Jimmaa Raaree',
            'Jardaagaa Jaartee',
            'Abaaboo Guduruu',
            'Hoorroo',
            'Hoorroo Bulluq',
            'Guduruu',
            'Coommaan Guduruu',
            'B_M_Shaambuu',
            'Sulula Fincaa’a'
        ];

        $options = [];
        foreach ($woredas as $woreda) {
            $options[] = ['id' => $woreda, 'text' => $woreda];
        }

        $jsonOptions = json_encode($options);

        return view('zones.zone12.create');
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
            'email' => 'nullable|email|unique:zone12s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);

        $zone12 = Zone12::create($validated);

        return redirect()->route('zone12.index')->with('success', 'Zone12 Created successfully');
    }

    public function show($id)
    {
        $zone12 = Zone12::findOrFail($id);
    }

    public function edit($id)
    {
        $zone12 = Zone12::findOrFail($id);

        return view('zones.zone12.edit', compact('zone12'));
    }

    public function update(Request $request, $id)
    {
        $zone12 = Zone12::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $zone12->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $zone12->document;
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
            'email' => 'nullable|email|unique:zone12s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);


        $zone12->update($validated);

        return redirect()->route('zone12.index')->with('update', 'Zone12 Updated successfully');
    }

    public function destroy($id)
    {
        $zone12 = Zone12::findOrFail($id);
        $zone12->delete();

        return redirect()->route('zone12.index')->with('delete', 'Zone12 Deleted successfully');
    }
    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
        try {



            $maxId = Zone12::max('id');

            $file = $request->file('file');
            Excel::import(new Zone12Import($maxId), $file);

            return redirect()->route('zone12.index')->with('success', 'Zone12 Imported successfully');
        } catch (\Exception $e) {
            // return redirect()->back()->withErrors($e->getMessage());
            return redirect()->back();
        }
    }
    public function pay($id)
    {
        $member = Zone12::findOrFail($id);
        $model = "zone12";
        return view('zones.zoneMemberPay.create', compact('member', 'model'));
    }
}
