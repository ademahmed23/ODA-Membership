<?php

namespace App\Http\Controllers;

use App\Models\Zone14;
use Illuminate\Http\Request;
use App\Imports\Zone14Import;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class Zone14Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:zone14-list|zone14-create|zone14-edit|zone14-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:zone14-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:zone14-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:zone14-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $count = Zone14::count();

        return view('zone14.index', compact('count'));
    }

    public function create()
    {
        $woredas = [
            'B-Xollay',
            'C-Botor',
            'Dedoo',
            'Geeraa',
            'Gommaa',
            'Gumaay',
            'L-Koossaa',
            'L-Saqqaa',
            'Manchoo',
            'Maannaa',
            'N-Beenjaa',
            'O-Beeyyam',
            'O-Naaddaa',
            'Qarsaa',
            'S-Coqorsaa',
            'Sigimoo',
            'SH-Somboo',
            'Saxxammaa',
            'Sokorruu',
            'N-Gibee',
            'M-Aggaroo',
            'M-L-Gannaat',
        ];

        $options = [];
        foreach ($woredas as $woreda) {
            $options[] = ['id' => $woreda, 'text' => $woreda];
        }

        $jsonOptions = json_encode($options);

        return view('zone14.create');
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
            'email' => 'nullable|email|unique:zone14s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);

        $zone14 = Zone14::create($validated);

        return redirect()->route('zone14.index')->with('success', 'Zone14 Created successfully');
    }

    public function show($id)
    {
        $zone14 = Zone14::findOrFail($id);
    }

    public function edit($id)
    {
        $zone14 = Zone14::findOrFail($id);

        return view('zone14.edit', compact('zone14'));
    }

    public function update(Request $request, $id)
    {
        $zone14 = Zone14::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $zone14->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $zone14->document;
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
            'email' => 'nullable|email|unique:zone14s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);


        $zone14->update($validated);

        return redirect()->route('zone14.index')->with('update', 'Zone14 Updated successfully');
    }

    public function destroy($id)
    {
        $zone14 = Zone14::findOrFail($id);
        $zone14->delete();

        return redirect()->route('zone14.index')->with('delete', 'Zone14 Deleted successfully');
    }
    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
        try {



            $maxId = Zone14::max('id');

            $file = $request->file('file');
            Excel::import(new Zone14Import($maxId), $file);

            return redirect()->route('zone14.index')->with('success', 'Zone14 Imported successfully');
        } catch (\Exception $e) {
            // return redirect()->back()->withErrors($e->getMessage());
            return redirect()->back();
        }
    }
    public function pay($id)
    {
        $member = Zone14::findOrFail($id);
        $model = "zone14";
        return view('zoneMemberPay.create', compact('member', 'model'));
    }
}
