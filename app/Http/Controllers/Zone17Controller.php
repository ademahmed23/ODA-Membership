<?php

namespace App\Http\Controllers;

use App\Models\Zone17;
use Illuminate\Http\Request;
use App\Imports\Zone17Import;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class Zone17Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:zone17-list|zone17-create|zone17-edit|zone17-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:zone17-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:zone17-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:zone17-delete', ['only' => ['destroy']]);
    }

   public function index(Request $request){
    $count_woreda = Zone17::where('woreda','kuyyuu')->count();
            $zone = 'zone17s';
    $count = Zone17::count();
    $name = 'Shawaa-Kaabaa';
    $export = true;
    $woreda = $request->woreda;

    // Get distinct woredas
    $woredas = \DB::table($zone)
        ->select('woreda')
        ->distinct()
        ->orderBy('woreda')
        ->pluck('woreda');

    // Base query
    $query = Zone17::query();

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

    return view('zones.zone17.index', compact('reports', 'name', 'zone', 'woreda', 'export', 'woredas','count','count_woreda'));
    }
   

    public function create()
    {
        $woredas = [
            'Darraa',
            'H/Abootee',
            'W/Jaarsoo',
            'Kuyyuu',
            'Dagam',
            'G/Jaarsoo',
            'Y/Gullalee',
            'D/Libaanoos',
            'Waacaalee',
            'Jiddaa',
            'Aleeltuu',
            'Abbiichuu fi Nya\'aa',
            'Qimbiibit',
            'B/M/Fiichee',
            'B/M/ G/Guraachaa'
        ];

        $options = [];
        foreach ($woredas as $woreda) {
            $options[] = ['id' => $woreda, 'text' => $woreda];
        }

        $jsonOptions = json_encode($options);

        return view('zones.zone17.create');
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
            'education_level'=>'string',
            'address' => 'nullable|string',
            'contact_number' => 'nullable|numeric|digits_between:9,14',
            'woreda' => 'nullable|string',
            'email' => 'nullable|email|unique:zone17s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);

        $zone17 = Zone17::create($validated);

        return redirect()->route('zone17.index')->with('success', 'Zone17 Created successfully');
    }

    public function show($id)
    {
        $zone17 = Zone17::findOrFail($id);
    }

    public function edit($id)
    {
        $zone17 = Zone17::findOrFail($id);

        return view('zones.zone17.edit', compact('zone17'));
    }

    public function update(Request $request, $id)
    {
        $zone17 = Zone17::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $zone17->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $zone17->document;
        }

        $validated = $request->validate([
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'required|string',
            'gender' => 'required|string',
            'age' => 'required|integer',
            'education_level'=>'string',
            'address' => 'nullable|string',
            'contact_number' => 'nullable|numeric|digits_between:9,14',
            'woreda' => 'nullable|string',
            'email' => 'nullable|email|unique:zone17s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);


        $zone17->update($validated);

        return redirect()->route('zone17.index')->with('update', 'Zone17 Updated successfully');
    }

    public function destroy($id)
    {
        $zone17 = Zone17::findOrFail($id);
        $zone17->delete();

        return redirect()->route('zone17.index')->with('delete', 'Zone17 Deleted successfully');
    }
    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
        try {



            $maxId = Zone17::max('id');

            $file = $request->file('file');
            Excel::import(new Zone17Import($maxId), $file);

            return redirect()->route('zone17.index')->with('success', 'Zone17 Imported successfully');
        } catch (\Exception $e) {
            // return redirect()->back()->withErrors($e->getMessage());
            return redirect()->back();
        }
    }
    public function pay($id)
    {
        $member = Zone17::findOrFail($id);
        $model = "zone17";
        return view('zones.zoneMemberPay.create', compact('member', 'model'));
    }
}
