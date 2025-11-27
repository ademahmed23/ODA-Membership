<?php

namespace App\Http\Controllers;

use App\Models\Zone20;
use Illuminate\Http\Request;
use App\Imports\Zone20Import;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class Zone20Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:zone20-list|zone20-create|zone20-edit|zone20-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:zone20-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:zone20-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:zone20-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $count = Zone20::count();

        return view('zones.zone20.index', compact('count'));
    }

    public function create()
    {
        //         1.	G_Sayyoo
        // 2.	W_Tuqaa
        // 3.	S_siree
        // 4.	G_Biilaa
        // 5.	B_Booshee
        // 6.	W_Hagaloo
        // 7.	G_Giddaa
        // 8.	Sasiggaa
        // 9.	N_Qumbaa
        // 10.	J_Arjoo
        // 11.	L_Dullachaa
        // 12.	G_Ayyaanaa
        // 13.	Kiraamuu
        // 14.	Ebantuu
        // 15.	Limmuu
        // 16.	H_Limmuu
        // 17.	Diggaa
        // 18.	A_Guutee

        $woredas = [
            'G_Sayyoo',
            'W_Tuqaa',
            'S_siree',
            'G_Biilaa',
            'B_Booshee',
            'W_Hagaloo',
            'G_Giddaa',
            'Sasiggaa',
            'N_Qumbaa',
            'J_Arjoo',
            'L_Dullachaa',
            'G_Ayyaanaa',
            'Kiraamuu',
            'Ebantuu',
            'Limmuu',
            'H_Limmuu',
            'Diggaa',
            'A_Guutee',
        ];

        $options = [];
        foreach ($woredas as $woreda) {
            $options[] = ['id' => $woreda, 'text' => $woreda];
        }

        $jsonOptions = json_encode($options);

        return view('zones.zone20.create');
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
            'email' => 'nullable|email|unique:zone20s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);

        $zone20 = Zone20::create($validated);

        return redirect()->route('zone20.index')->with('success', 'Zone20 Created successfully');
    }

    public function show($id)
    {
        $zone20 = Zone20::findOrFail($id);
    }

    public function edit($id)
    {
        $zone20 = Zone20::findOrFail($id);

        return view('zones.zone20.edit', compact('zone20'));
    }

    public function update(Request $request, $id)
    {
        $zone20 = Zone20::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $zone20->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $zone20->document;
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
            'email' => 'nullable|email|unique:zone20s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);


        $zone20->update($validated);

        return redirect()->route('zone20.index')->with('update', 'Zone20 Updated successfully');
    }

    public function destroy($id)
    {
        $zone20 = Zone20::findOrFail($id);
        $zone20->delete();

        return redirect()->route('zone20.index')->with('delete', 'Zone20 Deleted successfully');
    }
    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
        try {



            $maxId = Zone20::max('id');

            $file = $request->file('file');
            Excel::import(new Zone20Import($maxId), $file);

            return redirect()->route('zone20.index')->with('success', 'Zone20 Imported successfully');
        } catch (\Exception $e) {
            // return redirect()->back()->withErrors($e->getMessage());
            return redirect()->back();
        }
    }
    public function pay($id)
    {
        $member = Zone20::findOrFail($id);
        $model = "zone20";
        return view('zones.zoneMemberPay.create', compact('member', 'model'));
    }
}
