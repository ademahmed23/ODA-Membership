<?php

namespace App\Http\Controllers;

use App\Models\Zone7;
use App\Imports\Zone7Import;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class Zone7Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:zone7-list|zone7-create|zone7-edit|zone7-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:zone7-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:zone7-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:zone7-delete', ['only' => ['destroy']]);
    }

     public function index(Request $request){  

         $zone = 'zone7s';
    $count = Zone7::count();
    $name = 'Finfinnee';
    $export = true;
    $woreda = $request->woreda;

    // Get distinct woredas
    $woredas = \DB::table($zone)
        ->select('woreda')
        ->distinct()
        ->orderBy('woreda')
        ->pluck('woreda');

    // Base query
    $query = Zone7::query();

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
            ->where('model', 'zone7')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->exists();
        return $item;
    });
    return view('zone7.index', compact('reports', 'name', 'zone', 'woreda', 'export', 'woredas','count'));
    }

    public function create()
    {

        $woredas = [
            'Aanaa Aqaaqii',
            'A/Sab.Awaas',
            'Aanaa Barrak',
            'A/ Wal-mara',
            'Aanaa Sululuta',
            'Aanaa Muloo',
            'Mag/Holoota',
            'Mag/Galaan',
            'Mag/Sululuta',
            'Mag/Burayyu',
            'Mag/Sabbataa',
            'Mag/Sandafa',
            'Mag/ L/xaafoo',
            'Mag/Duukam'
        ];

        $options = [];
        foreach ($woredas as $woreda) {
            $options[] = ['id' => $woreda, 'text' => $woreda];
        }

        $jsonOptions = json_encode($options);

        return view('zone7.create', compact('jsonOptions'));
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
            'email' => 'nullable|email|unique:zone7s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);

        $zone7 = Zone7::create($validated);

        return redirect()->route('zone7.index')->with('success', 'Zone7 Created successfully');
    }

    public function show($id)
    {
        $zone7 = Zone7::findOrFail($id);
    }

    public function edit($id)
    {
        $zone7 = Zone7::findOrFail($id);

        return view('zone7.edit', compact('zone7'));
    }

    public function update(Request $request, $id)
    {
        $zone7 = Zone7::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $zone7->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $zone7->document;
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
            'email' => 'nullable|email|unique:zone7s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);


        $zone7->update($validated);

        return redirect()->route('zone7.index')->with('update', 'Zone7 Updated successfully');
    }

    public function destroy($id)
    {
        $zone7 = Zone7::findOrFail($id);
        $zone7->delete();

        return redirect()->route('zone7.index')->with('delete', 'Zone7 Deleted successfully');
    }
    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
        try {



            $maxId = Zone7::max('id');

            $file = $request->file('file');
            Excel::import(new Zone7Import($maxId), $file);

            return redirect()->route('zone7.index')->with('success', 'Zone7 Imported successfully');
        } catch (\Exception $e) {
            // return redirect()->back()->withErrors($e->getMessage());
            return redirect()->back();
        }
    }
    public function pay($id)
    {
        $member = Zone7::findOrFail($id);
        $model = "zone7";
        return view('zoneMemberPay.create', compact('member', 'model'));
    }
}
