<?php

namespace App\Http\Controllers\Organization;

use App\Models\Organization\ShawaaKaabaa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use App\Imports\Organization\ShawaaKaabaaImport;

class ShawaaKaabaaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:sh_kaabaa-list|sh_kaabaa-create|sh_kaabaa-edit|sh_kaabaa-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:sh_kaabaa-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:sh_kaabaa-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:sh_kaabaa-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $zone = 'sh_kaabaa';
        $count = ShawaaKaabaa::count();
        $name = 'Shawwa Kaabaa';
        $export = true;
        $woreda = $request->woreda;

        $woredas = \DB::table($zone)
            ->select('woreda')
            ->distinct()
            ->orderBy('organization_name', 'ASC')
            ->pluck('woreda');

        $query = ShawaaKaabaa::query();

        if ($woreda) {
            $query->where('woreda', $woreda);
        }

        $reports = $query->paginate(10);

        $reports->getCollection()->transform(function ($item, $key) use ($reports) {
            $item->row_id = ($reports->currentPage() - 1) * $reports->perPage() + $key + 1;
            $item->has_paid = \DB::table('zone_member_pays')
                ->where('member_id', $item->id)
                ->where('model', 'sh_kaabaa')
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->exists();
            return $item;
        });

        return view('organization.sh_kaabaa.index', compact('reports','count','name','export','woredas','woreda','zone'));
    }

    public function create()
    {
        $woredas = [
            'Teltele', 'Dire', 'Moyale', 'Dillo', 'Yabello', 'Arero', 'Magaalaa', 'Bule', 'Other'
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

        return view('organization.sh_kaabaa.create', compact('jsonOptions','joption'));
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
            'email' => 'nullable|email|unique:sh_kaabaa',
            'payment_period' => 'nullable|string',
            'member_started' => 'nullable|date',
            'payment' => 'nullable|numeric',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $documentname;

        ShawaaKaabaa::create($validated);

        return redirect()->route('sh_kaabaa.index')->with('success','sh_kaabaa Member Created Successfully');
    }

    public function edit($id)
    {
        $sh_kaabaa = ShawaaKaabaa::findOrFail($id);

        $woredas = [
            'Teltele', 'Dire', 'Moyale', 'Dillo', 'Yabello', 'Arero', 'Magaalaa', 'Bule', 'Other'
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

        return view('organization.sh_kaabaa.edit', compact('sh_kaabaa','jsonOptions','joption'));
    }

    public function update(Request $request, $id)
    {
        $sh_kaabaa = ShawaaKaabaa::findOrFail($id);

        $last_thumb = $sh_kaabaa->image;
        $documentname = $sh_kaabaa->document;

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
            'email' => 'nullable|email|unique:sh_kaabaa',
            'payment_period' => 'nullable|string',
            'member_started' => 'nullable|date',
            'payment' => 'nullable|numeric',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $documentname;

        $sh_kaabaa->update($validated);

        return redirect()->route('sh_kaabaa.index')->with('update','sh_kaabaa Member Updated Successfully');
    }

    public function destroy($id)
    {
        $sh_kaabaa = ShawaaKaabaa::findOrFail($id);
        $sh_kaabaa->delete();

        return redirect()->route('sh_kaabaa.index')->with('delete','sh_kaabaa Member Deleted Successfully');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        try {
            $maxId = ShawaaKaabaa::max('id');
            Excel::import(new ShawaaKaabaaImport($maxId), $request->file('file'));

            return redirect()->route('sh_kaabaa.index')->with('success','sh_kaabaa Imported Successfully');
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function pay($id)
    {
        $member = ShawaaKaabaa::findOrFail($id);
        $model = "sh_kaabaa";

        return view('organization.sh_kaabaa.create', compact('member', 'model'));
    }
}
