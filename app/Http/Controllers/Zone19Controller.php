<?php

namespace App\Http\Controllers;

use App\Models\Zone19;
use Illuminate\Http\Request;
use App\Imports\Zone19Import;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class Zone19Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:zone19-list|zone19-create|zone19-edit|zone19-delete', ['only' => ['index', 'store']]);

        $this->middleware('permission:zone19-create', ['only' => ['create', 'store']]);

        $this->middleware('permission:zone19-edit', ['only' => ['edit', 'update']]);

        $this->middleware('permission:zone19-delete', ['only' => ['destroy']]);
    }
  public function index(Request $request){
    $count_woreda = Zone19::where('woreda','kuyyuu')->count();
            $zone = 'zone19s';
    $count = Zone19::count();
    $name = 'Shawaa Lixaa';
    $export = true;
    $woreda = $request->woreda;

    // Get distinct woredas
    $woredas = \DB::table($zone)
        ->select('woreda')
        ->distinct()
        ->orderBy('woreda')
        ->pluck('woreda');

    // Base query
    $query = Zone19::query();

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

    return view('zones.zone19.index', compact('reports', 'name', 'zone', 'woreda', 'export', 'woredas','count','count_woreda'));
    }

    public function create()
    {
        //         1.	Abuna_Gindabarat
        // 2.	Ada’aa_Bargaa
        // 3.	Amboo
        // 4.	Baakkoo_Tibbee
        // 5.	Calliyaa
        // 6.	Cobii
        // 7.	Daannoo
        // 8.	Dandii
        // 9.	Dirree_Incinnii
        // 10.	Ejeree
        // 11.	Ejersaa_Lafoo
        // 12.	Gindabarat
        // 13.	Ilfaataa
        // 14.	Jalduu
        // 15.	Jibaat
        // 16.	Libaan_Jawwii
        // 17.	Meettaa_Roobii
        // 18.	Meettaa_Walqixxee
        // 19.	Midaa_Qanyii
        // 20.	Noonnoo
        // 21.	Tokkee_Kuttaayee

        $woredas = [
            'Abuna_Gindabarat',
            'Ada’aa_Bargaa',
            'Amboo',
            'Baakkoo_Tibbee',
            'Calliyaa',
            'Cobii',
            'Daannoo',
            'Dandii',
            'Dirree_Incinnii',
            'Ejeree',
            'Ejersaa_Lafoo',
            'Gindabarat',
            'Ilfaataa',
            'Jalduu',
            'Jibaat',
            'Libaan_Jawwii',
            'Meettaa_Roobii',
            'Meettaa_Walqixxee',
            'Midaa_Qanyii',
            'Noonnoo',
            'Tokkee_Kuttaayee'

        ];

        $options = [];
        foreach ($woredas as $woreda) {
            $options[] = ['id' => $woreda, 'text' => $woreda];
        }

        $jsonOptions = json_encode($options);

        return view('zones.zone19.create');
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
            'email' => 'nullable|email|unique:zone19s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);

        $zone19 = Zone19::create($validated);

        return redirect()->route('zone19.index')->with('success', 'Zone19 Created successfully');
    }

    public function show($id)
    {
        $zone19 = Zone19::findOrFail($id);
    }

    public function edit($id)
    {
        $zone19 = Zone19::findOrFail($id);

        return view('zones.zone19.edit', compact('zone19'));
    }

    public function update(Request $request, $id)
    {
        $zone19 = Zone19::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $zone19->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $zone19->document;
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
            'email' => 'nullable|email|unique:zone19s',
            'position' => 'nullable|string',
            'membership_type' => 'nullable|string',
            'membership_fee' => 'nullable|integer',

        ]);


        $zone19->update($validated);

        return redirect()->route('zone19.index')->with('update', 'Zone19 Updated successfully');
    }

    public function destroy($id)
    {
        $zone19 = Zone19::findOrFail($id);
        $zone19->delete();

        return redirect()->route('zone19.index')->with('delete', 'Zone19 Deleted successfully');
    }
    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
        try {



            $maxId = Zone19::max('id');

            $file = $request->file('file');
            Excel::import(new Zone19Import($maxId), $file);

            return redirect()->route('zone19.index')->with('success', 'Zone19 Imported successfully');
        } catch (\Exception $e) {
            // return redirect()->back()->withErrors($e->getMessage());
            return redirect()->back();
        }
    }
    public function pay($id)
    {
        $member = Zone19::findOrFail($id);
        $model = "zone19";
        return view('zones.zoneMemberPay.create', compact('member', 'model'));
    }
}
