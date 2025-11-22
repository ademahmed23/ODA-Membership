<?php

namespace App\Http\Controllers;

use App\Models\Zone1;
use App\Imports\Zone1Import;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;


class Zone1Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:zone1-list|zone1-create|zone1-edit|zone1-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:zone1-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:zone1-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:zone1-delete', ['only' => ['destroy']]);
    }

public function index(Request $request)
{
    
    $zone = 'zone1s';
    $count = Zone1::count();
    // $aanaa = Zone1::count('woreda');
    $name = 'Arsii';
    $export = true;
    $woreda = $request->woreda;

    // Get distinct woredas
    $woredas = \DB::table($zone)
        ->select('woreda')
        ->distinct()
        ->orderBy('first_name','Asc')
        ->pluck('woreda');

    // Base query
    $query = Zone1::query();

    // Filter by woreda if provided
    if ($woreda) {
        $query->where('woreda', $woreda);
    }

    // Use pagination instead of get()
    $reports = $query->paginate(10); // 10 items per page

    // Add computed fields
    $reports->getCollection()->transform(function ($item, $key) use ($reports) {
        $item->row_id = ($reports->currentPage() - 1) * $reports->perPage() + $key + 1; // continuous numbering
        $item->has_paid = \DB::table('zone_member_pays')
            ->where('member_id', $item->id)
            ->where('model', 'zone1')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->exists();
        return $item;   
    });

    return view('zone1.index', compact('reports', 'name', 'zone', 'woreda', 'export', 'woredas', 'count'));
}



    
    public function create()
    {
        $woredas = [
            'Aminyaa',
            'Asakoo',
            'Asallaa',
            'Balee Gasgaar',
            'Boqojjii',
            'Collee',
            'D/Xiijoo',
            'Diksiis',
            'Doddotaa',
            'Gololchaa',
            'Gunaa',
            'Heexosaa',
            'H/Waabee',
            'Jajuu',
            'L/Bilbiloo',
            'L/Heexosaa',
            'Martii',
            'Muunessaa',
            'Roobee',
            'Seeruu',
            'Shanan Kooluu',
            'Siirkaa',
            'Siree',
            'Suudee',
            'Xichoo',
            'Xiyoo',
            'Z/Dugdaa',

        ];

        $options = [];
        foreach ($woredas as $woreda) {
            $options[] = ['id' => $woreda, 'text' => $woreda];
        }

        $jsonOptions = json_encode($options);

        return view('zone1.create', compact('jsonOptions'));
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
            'education_level' => 'required|string',
            'address' => 'nullable|string',
            'contact_number' => 'nullable|numeric|digits_between:9,14',
            'woreda' => 'nullable|string',
            'email' => 'nullable|email|unique:zone1s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);

        $zone1 = Zone1::create($validated);

        return redirect()->route('zone1.index')->with('success', 'Zone1 Created successfully');
    }

    public function show($id)
    {
        $zone1 = Zone1::findOrFail($id);
    }

    public function edit($id)
    {
        $zone1 = Zone1::findOrFail($id);

        return view('zone1.edit', compact('zone1'));
    }

    public function update(Request $request, $id)
    {
        $zone1 = Zone1::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $zone1->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $zone1->document;
        }

        $validated = $request->validate([
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'required|string',
            'gender' => 'required|string',
            'age' => 'required|integer',
            'education_level' => 'required|string',
            'address' => 'nullable|string',
            'contact_number' => 'nullable|numeric|digits_between:9,14',
            'woreda' => 'nullable|string',
            'email' => 'nullable|email|unique:zone1s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);


        $zone1->update($validated);

        return redirect()->route('zone1.index')->with('update', 'Zone1 Updated successfully');
    }

    public function destroy($id)
    {
        $zone1 = Zone1::findOrFail($id);
        $zone1->delete();

        return redirect()->route('zone1.index')->with('delete', 'Zone1 Deleted successfully');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
        try {



            $maxId = Zone1::max('id');

            $file = $request->file('file');
            Excel::import(new Zone1Import($maxId), $file);

            return redirect()->route('zone1.index')->with('success', 'Zone1 Imported successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            return redirect()->back();
        }
    }
    public function pay($id)
    {
        $member = Zone1::findOrFail($id);
        $model = "zone1";
        return view('zoneMemberPay.create', compact('member', 'model'));
    }
}
