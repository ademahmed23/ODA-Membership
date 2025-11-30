<?php

namespace App\Http\Controllers\Organization;

use App\Models\Organization\Qeellam;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use App\Imports\Organization\QeellamImport;

class QellamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:qeellam-list|qeellam-create|qeellam-edit|qeellam-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:qeellam-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:qeellam-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:qeellam-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $zone = 'q_wallaga';
        $count = Qeellam::count();
        $name = 'Qeellam Wallaggaa';
        $export = true;
        $woreda = $request->woreda;

        $woredas = \DB::table($zone)
            ->select('woreda')
            ->distinct()
            ->orderBy('organization_name', 'ASC')
            ->pluck('woreda');

        $query = Qeellam::query();

        if ($woreda) {
            $query->where('woreda', $woreda);
        }

        $reports = $query->paginate(10);

        $reports->getCollection()->transform(function ($item, $key) use ($reports) {
            $item->row_id = ($reports->currentPage() - 1) * $reports->perPage() + $key + 1;
            $item->has_paid = \DB::table('zone_member_pays')
                ->where('member_id', $item->id)
                ->where('model', 'qeellam')
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->exists();
            return $item;
        });

        return view('organization.qeellam.index', compact('reports','count','name','export','woredas','woreda','zone'));
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

        return view('organization.qeellam.create', compact('jsonOptions','joption'));
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
            'email' => 'nullable|email|unique:q_wallaga',
            'payment_period' => 'nullable|string',
            'member_started' => 'nullable|date',
            'payment' => 'nullable|numeric',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $documentname;

        Qeellam::create($validated);

        return redirect()->route('qeellam.index')->with('success','qeellam Member Created Successfully');
    }

    public function edit($id)
    {
        $qeellam = Qeellam::findOrFail($id);

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

        return view('organization.qeellam.edit', compact('qeellam','jsonOptions','joption'));
    }

    public function update(Request $request, $id)
    {
        $qeellam = Qeellam::findOrFail($id);

        $last_thumb = $qeellam->image;
        $documentname = $qeellam->document;

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
            'email' => 'nullable|email|unique:q_wallaga',
            'payment_period' => 'nullable|string',
            'member_started' => 'nullable|date',
            'payment' => 'nullable|numeric',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $documentname;

        $qeellam->update($validated);

        return redirect()->route('qeellam.index')->with('update','qeellam Member Updated Successfully');
    }

    public function destroy($id)
    {
        $qeellam = Qeellam::findOrFail($id);
        $qeellam->delete();

        return redirect()->route('qeellam.index')->with('delete','qeellam Member Deleted Successfully');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        try {
            $maxId = Qeellam::max('id');
            Excel::import(new qeellamImport($maxId), $request->file('file'));

            return redirect()->route('qeellam.index')->with('success','qeellam Imported Successfully');
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function pay($id)
    {
        $member = Qeellam::findOrFail($id);
        $model = "qeellam";

        return view('organization.qeellam.create', compact('member', 'model'));
    }
}
