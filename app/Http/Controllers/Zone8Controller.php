<?php

namespace App\Http\Controllers;

use App\Models\Zone8;
use App\Imports\Zone8Import;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class Zone8Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:zone8-list|zone8-create|zone8-edit|zone8-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:zone8-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:zone8-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:zone8-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $count = Zone8::count();

        return view('zone8.index', compact('count'));
    }

    public function create()
    {
        $woredas = [
            'Od/Shakkisoo',
            'Mag/Shakkiso',
            'Mag/Adoola',
            'Aagaa Waayyuu',
            'Booree',
            'Girjaa',
            'Adoola-Reeddee',
            'Waadaraa',
            'Uraaga',
            'S/Borruu',
            'Annaa Sorraa',
            'Liiban',
            'Ardaa jilaa',
            'Daamaa',
            'mag/Nagellee'

        ];

        $options = [];
        foreach ($woredas as $woreda) {
            $options[] = ['id' => $woreda, 'text' => $woreda];
        }

        $jsonOptions = json_encode($options);

        return view('zone8.create', compact('jsonOptions'));
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
            'email' => 'nullable|email|unique:zone8s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);

        $zone8 = Zone8::create($validated);

        return redirect()->route('zone8.index')->with('success', 'Zone8 Created successfully');
    }

    public function show($id)
    {
        $zone8 = Zone8::findOrFail($id);
    }

    public function edit($id)
    {
        $zone8 = Zone8::findOrFail($id);

        return view('zone8.edit', compact('zone8'));
    }

    public function update(Request $request, $id)
    {
        $zone8 = Zone8::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $zone8->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $zone8->document;
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
            'email' => 'nullable|email|unique:zone8s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);


        $zone8->update($validated);

        return redirect()->route('zone8.index')->with('update', 'Zone8 Updated successfully');
    }

    public function destroy($id)
    {
        $zone8 = Zone8::findOrFail($id);
        $zone8->delete();

        return redirect()->route('zone8.index')->with('delete', 'Zone8 Deleted successfully');
    }
    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
        try {



            $maxId = Zone8::max('id');

            $file = $request->file('file');
            Excel::import(new Zone8Import($maxId), $file);

            return redirect()->route('zone8.index')->with('success', 'Zone8 Imported successfully');
        } catch (\Exception $e) {
            // return redirect()->back()->withErrors($e->getMessage());
            return redirect()->back();
        }
    }
    public function pay($id)
    {
        $member = Zone8::findOrFail($id);
        $model = "zone8";
        return view('zoneMemberPay.create', compact('member', 'model'));
    }
}
