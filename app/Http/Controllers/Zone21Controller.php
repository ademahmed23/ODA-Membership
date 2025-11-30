<?php

namespace App\Http\Controllers;

use App\Models\Zone21;
use Illuminate\Http\Request;
use App\Imports\Zone21Import;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class Zone21Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:zone21-list|zone21-create|zone21-edit|zone21-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:zone21-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:zone21-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:zone21-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request){
    $count_woreda = Zone21::where('woreda','kuyyuu')->count();
            $zone = 'zone21s';
    $count = Zone21::count();
    $name = 'Wallagga Lixaa';
    $export = true;
    $woreda = $request->woreda;

    // Get distinct woredas
    $woredas = \DB::table($zone)
        ->select('woreda')
        ->distinct()
        ->orderBy('woreda')
        ->pluck('woreda');

    // Base query
    $query = Zone21::query();

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

    return view('zones.zone21.index', compact('reports', 'name', 'zone', 'woreda', 'export', 'woredas','count','count_woreda'));
    }

    public function create()
    {
        $woredas = [
            'Ayira',
            'Baabboo_Gambeel',
            'Boj_Coqorsa',
            'Bojjii_Dirmajii',
            'M_Mandii',
            'M_Najjoo',
            'Ganjii',
            'Gimbii',
            'Gullisoo',
            'Haaruu',
            'Hoomaa',
            'Jaarsoo',
            'Lata_Sibuu',
            'Laallee_Assaabii',
            'Mana_Sibuu',
            'Najjoo',
            'Noolee_Kaabbaa',
            'Noolee_Qilee',
            'Qilxuu_Kaarraa',
            'Sayyoo_Noolee',
            'Yubdoo',
            'Beggii',
            'Qondaalaa'
        ];

        $options = [];
        foreach ($woredas as $woreda) {
            $options[] = ['id' => $woreda, 'text' => $woreda];
        }

        $jsonOptions = json_encode($options);

        return view('zones.zone21.create');
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
            'email' => 'nullable|email|unique:zone21s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);

        $zone21 = Zone21::create($validated);

        return redirect()->route('zone21.index')->with('success', 'Zone21 Created successfully');
    }

    public function show($id)
    {
        $zone21 = Zone21::findOrFail($id);
    }

    public function edit($id)
    {
        $zone21 = Zone21::findOrFail($id);

        return view('zones.zone21.edit', compact('zone21'));
    }

    public function update(Request $request, $id)
    {
        $zone21 = Zone21::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $zone21->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $zone21->document;
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
            'email' => 'nullable|email|unique:zone21s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);


        $zone21->update($validated);

        return redirect()->route('zone21.index')->with('update', 'Zone21 Updated successfully');
    }

    public function destroy($id)
    {
        $zone21 = Zone21::findOrFail($id);
        $zone21->delete();

        return redirect()->route('zone21.index')->with('delete', 'Zone21 Deleted successfully');
    }
    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
        try {



            $maxId = Zone21::max('id');

            $file = $request->file('file');
            Excel::import(new Zone21Import($maxId), $file);

            return redirect()->route('zone21.index')->with('success', 'Zone21 Imported successfully');
        } catch (\Exception $e) {
            // return redirect()->back()->withErrors($e->getMessage());
            return redirect()->back();
        }
    }
    public function pay($id)
    {
        $member = Zone21::findOrFail($id);
        $model = "zone21";
        return view('zones.zoneMemberPay.create', compact('member', 'model'));
    }
}
