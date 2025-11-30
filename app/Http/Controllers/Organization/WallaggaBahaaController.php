<?php

namespace App\Http\Controllers\Organization;

use App\Models\Organization\WallaggaBahaa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use App\Imports\Organization\WallaggaBahaaImport;

class WallaggaBahaaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:w_bahaa-list|w_bahaa-create|w_bahaa-edit|w_bahaa-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:w_bahaa-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:w_bahaa-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:w_bahaa-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $zone = 'wahaa';
        $count = WallaggaBahaa::count();
        $name = 'Wallaga Bahaa';
        $export = true;
        $woreda = $request->woreda;

        $woredas = \DB::table($zone)
            ->select('woreda')
            ->distinct()
            ->orderBy('organization_name', 'ASC')
            ->pluck('woreda');

        $query = WallaggaBahaa::query();

        if ($woreda) {
            $query->where('woreda', $woreda);
        }

        $reports = $query->paginate(10);

        $reports->getCollection()->transform(function ($item, $key) use ($reports) {
            $item->row_id = ($reports->currentPage() - 1) * $reports->perPage() + $key + 1;
            $item->has_paid = \DB::table('zone_member_pays')
                ->where('member_id', $item->id)
                ->where('model', 'w_bahaa')
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->exists();
            return $item;
        });

        return view('organization.w_bahaa.index', compact('reports','count','name','export','woredas','woreda','zone'));
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

        $organization_type = ['Dhaabbataa Miti-Mootummaa', 'Dhaabbataa Mootummaa'];
        $org_option = [];
        foreach ($organization_type as $org) {
            $org_option[] = ['id'=> $org, 'text'=> $org];
        }
        $joption = json_encode($org_option);

        return view('organization.w_bahaa.create', compact('jsonOptions','joption'));
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
            'email' => 'nullable|email|unique:wahaa',
            'payment_period' => 'nullable|string',
            'member_started' => 'nullable|date',
            'payment' => 'nullable|numeric',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $documentname;

        WallaggaBahaa::create($validated);

        return redirect()->route('w_bahaa.index')->with('success','Wallagga Bahaa Member Created Successfully');
    }

    public function edit($id)
    {
        $w_bahaa = WallaggaBahaa::findOrFail($id);

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

        return view('organization.w_bahaa.edit', compact('w_bahaa','jsonOptions','joption'));
    }

    public function update(Request $request, $id)
    {
        $w_bahaa = WallaggaBahaa::findOrFail($id);

        $last_thumb = $w_bahaa->image;
        $documentname = $w_bahaa->document;

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
            'email' => 'nullable|email|unique:wahaa',
            'payment_period' => 'nullable|string',
            'member_started' => 'nullable|date',
            'payment' => 'nullable|numeric',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $documentname;

        $w_bahaa->update($validated);

        return redirect()->route('w_bahaa.index')->with('update','w_bahaa Member Updated Successfully');
    }

    public function destroy($id)
    {
        $w_bahaa = WallaggaBahaa::findOrFail($id);
        $w_bahaa->delete();

        return redirect()->route('w_bahaa.index')->with('delete','w_bahaa Member Deleted Successfully');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        try {
            $maxId = WallaggaBahaa::max('id');
            Excel::import(new WallaggaBahaaImport($maxId), $request->file('file'));

            return redirect()->route('w_bahaa.index')->with('success','w_bahaa Imported Successfully');
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function pay($id)
    {
        $member = WallaggaBahaa::findOrFail($id);
        $model = "w_bahaa";

        return view('organization.w_bahaa.create', compact('member', 'model'));
    }
}
