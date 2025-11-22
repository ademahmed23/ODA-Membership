<?php

namespace App\Http\Controllers;

use App\Models\Zone6;
use App\Imports\Zone6Import;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class Zone6Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:zone6-list|zone6-create|zone6-edit|zone6-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:zone6-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:zone6-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:zone6-delete', ['only' => ['destroy']]);
    }

     public function index(Request $request){  

         $zone = 'zone6s';
    $count = Zone6::count();
    $name = 'Buunnoo-Beddellee';
    $export = true;
    $woreda = $request->woreda;

    // Get distinct woredas
    $woredas = \DB::table($zone)
        ->select('woreda')
        ->distinct()
        ->orderBy('woreda')
        ->pluck('woreda');

    // Base query
    $query = Zone6::query();

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
            ->where('model', 'zone6')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->exists();
        return $item;
    });

    return view('zone6.index', compact('reports', 'name', 'zone', 'woreda', 'export', 'woredas','count'));
    }

    public function create()
    {
        $woredas = [
            'M-Beddeellee',
            'Cawwaaqaa',
            'A-Beddeellee',
            'Boorrachaa',
            'Cooraa',
            'Makkoo',
            'Gachii',
            'Dhidheessa',
            'Deeggaa',
            'DaabHaan'
        ];

        $options = [];
        foreach ($woredas as $woreda) {
            $options[] = ['id' => $woreda, 'text' => $woreda];
        }

        $jsonOptions = json_encode($options);

        return view('zone6.create', compact('jsonOptions'));
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
            'email' => 'nullable|email|unique:zone6s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);

        $zone6 = Zone6::create($validated);

        return redirect()->route('zone6.index')->with('success', 'Zone6 Created successfully');
    }

    public function show($id)
    {
        $zone6 = Zone6::findOrFail($id);
    }

    public function edit($id)
    {
        $zone6 = Zone6::findOrFail($id);

        return view('zone6.edit', compact('zone6'));
    }

    public function update(Request $request, $id)
    {
        $zone6 = Zone6::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $zone6->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $zone6->document;
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
            'email' => 'nullable|email|unique:zone6s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);


        $zone6->update($validated);

        return redirect()->route('zone6.index')->with('update', 'Zone6 Updated successfully');
    }

    public function destroy($id)
    {
        $zone6 = Zone6::findOrFail($id);
        $zone6->delete();

        return redirect()->route('zone6.index')->with('delete', 'Zone6 Deleted successfully');
    }
    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
        try {



            $maxId = Zone6::max('id');

            $file = $request->file('file');
            Excel::import(new Zone6Import($maxId), $file);

            return redirect()->route('zone6.index')->with('success', 'Zone6 Imported successfully');
        } catch (\Exception $e) {
            // return redirect()->back()->withErrors($e->getMessage());
            return redirect()->back();
        }
    }
    public function pay($id)
    {
        $member = Zone6::findOrFail($id);
        $model = "zone6";
        return view('zoneMemberPay.create', compact('member', 'model'));
    }
}
