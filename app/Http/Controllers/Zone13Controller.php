<?php

namespace App\Http\Controllers;

use App\Models\Zone13;
use Illuminate\Http\Request;
use App\Imports\Zone13Import;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class Zone13Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:zone13-list|zone13-create|zone13-edit|zone13-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:zone13-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:zone13-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:zone13-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $count = Zone13::count();

        return view('zones.zone13.index', compact('count'));
    }

    public function create()
    {
        $woredas = [
            'Daarimuu',
            'A/Saachii',
            'B/Nophaa',
            'Doranni',
            'Yaayyoo',
            'Hurrumu',
            'Buree',
            'Diiduu',
            'Bacho',
            'A/Mattu',
            'Haaluu',
            'Allee',
            'M/mattuu',
            'S/nonno',
        ];

        $options = [];
        foreach ($woredas as $woreda) {
            $options[] = ['id' => $woreda, 'text' => $woreda];
        }

        $jsonOptions = json_encode($options);

        return view('zones.zone13.create');
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
            'email' => 'nullable|email|unique:zone13s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);

        $zone13 = Zone13::create($validated);

        return redirect()->route('zone13.index')->with('success', 'Zone13 Created successfully');
    }

    public function show($id)
    {
        $zone13 = Zone13::findOrFail($id);
    }

    public function edit($id)
    {
        $zone13 = Zone13::findOrFail($id);

        return view('zones.zone13.edit', compact('zone13'));
    }

    public function update(Request $request, $id)
    {
        $zone13 = Zone13::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $zone13->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $zone13->document;
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
            'email' => 'nullable|email|unique:zone13s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);


        $zone13->update($validated);

        return redirect()->route('zone13.index')->with('update', 'Zone13 Updated successfully');
    }

    public function destroy($id)
    {
        $zone13 = Zone13::findOrFail($id);
        $zone13->delete();

        return redirect()->route('zone13.index')->with('delete', 'Zone13 Deleted successfully');
    }
    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
        try {



            $maxId = Zone13::max('id');

            $file = $request->file('file');
            Excel::import(new Zone13Import($maxId), $file);

            return redirect()->route('zone13.index')->with('success', 'Zone13 Imported successfully');
        } catch (\Exception $e) {
            // return redirect()->back()->withErrors($e->getMessage());
            return redirect()->back();
        }
    }
    public function pay($id)
    {
        $member = Zone13::findOrFail($id);
        $model = "zone13";
        return view('zones.zoneMemberPay.create', compact('member', 'model'));
    }
}
