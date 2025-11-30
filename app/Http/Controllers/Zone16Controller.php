<?php

namespace App\Http\Controllers;

use App\Models\Zone16;
use Illuminate\Http\Request;
use App\Imports\Zone16Import;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class Zone16Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:zone16-list|zone16-create|zone16-edit|zone16-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:zone16-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:zone16-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:zone16-delete', ['only' => ['destroy']]);
    }

   
   public function index(Request $request){
            $zone = 'zone16s';
    $count = Zone16::count();
    $name = 'Shawaa Bahaa';
    $export = true;
    $woreda = $request->woreda;

    // Get distinct woredas
    $woredas = \DB::table($zone)
        ->select('woreda')
        ->distinct()
        ->orderBy('woreda')
        ->pluck('woreda');

    // Base query
    $query = Zone16::query();

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
    return view('zones.zone16.index', compact('reports', 'name', 'zone', 'woreda', 'export', 'woredas','count'));
    }

    public function create()
    {
        $woredas = [
            'Adaa’aa',
            'Adaamaa',
            'Adaamii_Tulluu_Jiddoo_Kombolcha',
            'Booraa',
            'Boosat',
            'Dugdaa',
            'Fantaallee',
            'Gumbichuu',
            'L_Cuqqaalaa',
            'Lumee',
        ];

        $options = [];
        foreach ($woredas as $woreda) {
            $options[] = ['id' => $woreda, 'text' => $woreda];
        }

        $jsonOptions = json_encode($options);

        return view('zones.zone16.create');
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
            'email' => 'nullable|email|unique:zone16s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);

        $zone16 = Zone16::create($validated);

        return redirect()->route('zone16.index')->with('success', 'Zone16 Created successfully');
    }

    public function show($id)
    {
        $zone16 = Zone16::findOrFail($id);
    }

    public function edit($id)
    {
        $zone16 = Zone16::findOrFail($id);

        return view('zones.zone16.edit', compact('zone16'));
    }

    public function update(Request $request, $id)
    {
        $zone16 = Zone16::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $zone16->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $zone16->document;
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
            'email' => 'nullable|email|unique:zone16s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);


        $zone16->update($validated);

        return redirect()->route('zone16.index')->with('update', 'Zone16 Updated successfully');
    }

    public function destroy($id)
    {
        $zone16 = Zone16::findOrFail($id);
        $zone16->delete();

        return redirect()->route('zone16.index')->with('delete', 'Zone16 Deleted successfully');
    }
    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
        try {



            $maxId = Zone16::max('id');

            $file = $request->file('file');
            Excel::import(new Zone16Import($maxId), $file);

            return redirect()->route('zone16.index')->with('success', 'Zone16 Imported successfully');
        } catch (\Exception $e) {
            // return redirect()->back()->withErrors($e->getMessage());
            return redirect()->back();
        }
    }
    public function pay($id)
    {
        $member = Zone16::findOrFail($id);
        $model = "zone16";
        return view('zones.zoneMemberPay.create', compact('member', 'model'));
    }
}
