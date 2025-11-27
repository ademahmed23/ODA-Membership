<?php

namespace App\Http\Controllers\Organization;

use App\Models\Organization\Finfinnee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use App\Imports\Organization\FinfinneeImport;

class FinfinneeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:finfinnee-list|finfinnee-create|finfinnee-edit|finfinnee-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:finfinnee-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:finfinnee-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:finfinnee-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $zone = 'finfinnee';
        $count = Finfinnee::count();
        $name = 'finfinnee';
        $export = true;
        $woreda = $request->woreda;

        $woredas = \DB::table($zone)
            ->select('woreda')
            ->distinct()
            ->orderBy('organization_name', 'ASC')
            ->pluck('woreda');

        $query = Finfinnee::query();

        if ($woreda) {
            $query->where('woreda', $woreda);
        }

        $reports = $query->paginate(10);

        $reports->getCollection()->transform(function ($item, $key) use ($reports) {
            $item->row_id = ($reports->currentPage() - 1) * $reports->perPage() + $key + 1;
            $item->has_paid = \DB::table('zone_member_pays')
                ->where('member_id', $item->id)
                ->where('model', 'finfinnee')
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->exists();
            return $item;
        });

        return view('organization.finfinnee.index', compact('reports','count','name','export','woredas','woreda','zone'));
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

        return view('organization.finfinnee.create', compact('jsonOptions','joption'));
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
            'email' => 'nullable|email|unique:finfinnee',
            'payment_period' => 'nullable|string',
            'member_started' => 'nullable|date',
            'payment' => 'nullable|numeric',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $documentname;

        Finfinnee::create($validated);

        return redirect()->route('finfinnee.index')->with('success','finfinnee Member Created Successfully');
    }

    public function edit($id)
    {
        $finfinnee = Finfinnee::findOrFail($id);

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

        return view('organization.finfinnee.edit', compact('finfinnee','jsonOptions','joption'));
    }

    public function update(Request $request, $id)
    {
        $finfinnee = Finfinnee::findOrFail($id);

        $last_thumb = $finfinnee->image;
        $documentname = $finfinnee->document;

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
            'email' => 'nullable|email|unique:finfinnee',
            'payment_period' => 'nullable|string',
            'member_started' => 'nullable|date',
            'payment' => 'nullable|numeric',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $documentname;

        $finfinnee->update($validated);

        return redirect()->route('finfinnee.index')->with('update','finfinnee Member Updated Successfully');
    }

    public function destroy($id)
    {
        $finfinnee = Finfinnee::findOrFail($id);
        $finfinnee->delete();

        return redirect()->route('finfinnee.index')->with('delete','finfinnee Member Deleted Successfully');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        try {
            $maxId = Finfinnee::max('id');
            Excel::import(new FinfinneeImport($maxId), $request->file('file'));

            return redirect()->route('finfinnee.index')->with('success','finfinnee Imported Successfully');
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function pay($id)
    {
        $member = Finfinnee::findOrFail($id);
        $model = "finfinnee";

        return view('organization.finfinnee.create', compact('member', 'model'));
    }
}
