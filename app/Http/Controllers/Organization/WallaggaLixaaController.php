<?php

namespace App\Http\Controllers\Organization;

use App\Models\Organization\WallaggaLixaa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use App\Imports\Organization\WallaggaLixaaImport;

class WallaggaLixaaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:w_lixaa-list|w_lixaa-create|w_lixaa-edit|w_lixaa-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:w_lixaa-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:w_lixaa-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:w_lixaa-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $zone = 'w_lixaa';
        $count = WallaggaLixaa::count();
        $name = 'Wallagga Lixaa';
        $export = true;
        $woreda = $request->woreda;

        $woredas = \DB::table($zone)
            ->select('woreda')
            ->distinct()
            ->orderBy('organization_name', 'ASC')
            ->pluck('woreda');

        $query = WallaggaLixaa::query();

        if ($woreda) {
            $query->where('woreda', $woreda);
        }

        $reports = $query->paginate(10);

        $reports->getCollection()->transform(function ($item, $key) use ($reports) {
            $item->row_id = ($reports->currentPage() - 1) * $reports->perPage() + $key + 1;
            $item->has_paid = \DB::table('zone_member_pays')
                ->where('member_id', $item->id)
                ->where('model', 'w_lixaa')
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->exists();
            return $item;
        });

        return view('organization.w_lixaa.index', compact('reports','count','name','export','woredas','woreda','zone'));
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

        $organization_type = ['Dhaabbataa Miti-Mootummaa', 'Dhaabbataa Mootummaa'];
        $org_option = [];
        foreach ($organization_type as $org) {
            $org_option[] = ['id'=> $org, 'text'=> $org];
        }
        $joption = json_encode($org_option);

        return view('organization.w_lixaa.create', compact('jsonOptions','joption'));
    }

    public function store(Request $request)
    {
        $last_thumb = null;
        $documentname = 'default.pdf';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);
            $last_thumb = 'Photo/' . $name_gen;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        }

        $validated = $request->validate([
            'member_id' => 'required|string',
            'organization_name' => 'required|string',
            'organization_type' => 'nullable|string',
            'woreda' => 'nullable|string',
            'phone_number' => 'nullable|numeric|digits_between:9,14',
            'email' => 'nullable|email|unique:w_lixaa',
            'payment_period' => 'nullable|string',
            'member_started' => 'nullable|date',
            'payment' => 'nullable|numeric',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $documentname;

        WallaggaLixaa::create($validated);

        return redirect()->route('w_lixaa.index')->with('success','w_lixaa Member Created Successfully');
    }

    public function edit($id)
    {
        $w_lixaa = WallaggaLixaa::findOrFail($id);

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
        foreach ($woredas as $w) {
            $options[] = ['id' => $w, 'text' => $w];
        }
        $jsonOptions = json_encode($options);

        $organization_type = ['Dhaabbataa Miti-Mootummaa', 'Dhaabbataa Mootummaa'];
        $org_option = [];
        foreach ($organization_type as $org) {
            $org_option[] = ['id'=> $org, 'text'=> $org];
        }
        $joption = json_encode($org_option);

        return view('organization.w_lixaa.edit', compact('w_lixaa','jsonOptions','joption'));
    }

    public function update(Request $request, $id)
    {
        $w_lixaa = WallaggaLixaa::findOrFail($id);

        $last_thumb = $w_lixaa->image;
        $documentname = $w_lixaa->document;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);
            $last_thumb = 'Photo/' . $name_gen;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        }

        $validated = $request->validate([
            'member_id' => 'required|string',
            'organization_name' => 'required|string',
            'organization_type' => 'nullable|string',
            'woreda' => 'nullable|string',
            'phone_number' => 'nullable|numeric|digits_between:9,14',
            'email' => 'nullable|email|unique:w_lixaa',
            'payment_period' => 'nullable|string',
            'member_started' => 'nullable|date',
            'payment' => 'nullable|numeric',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $documentname;

        $w_lixaa->update($validated);

        return redirect()->route('w_lixaa.index')->with('update','w_lixaa Member Updated Successfully');
    }

    public function destroy($id)
    {
        $w_lixaa = WallaggaLixaa::findOrFail($id);
        $w_lixaa->delete();

        return redirect()->route('w_lixaa.index')->with('delete','w_lixaa Member Deleted Successfully');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        try {
            $maxId = WallaggaLixaa::max('id');
            Excel::import(new WallaggaLixaaImport($maxId), $request->file('file'));

            return redirect()->route('w_lixaa.index')->with('success','w_lixaa Imported Successfully');
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function pay($id)
    {
        $member = WallaggaLixaa::findOrFail($id);
        $model = "w_lixaa";

        return view('organization.w_lixaa.create', compact('member', 'model'));
    }
}
