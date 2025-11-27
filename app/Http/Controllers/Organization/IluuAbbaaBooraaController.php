<?php

namespace App\Http\Controllers\Organization;

use App\Models\Organization\Iluu;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use App\Imports\Organization\IluuImport;

class IluuAbbaaBooraaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:iluu-list|iluu-create|iluu-edit|iluu-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:iluu-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:iluu-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:iluu-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $zone = 'i_a_booraa';
        $count =Iluu::count();
        $name = 'Iluu Abbaa Booraa';
        $export = true;
        $woreda = $request->woreda;

        $woredas = \DB::table($zone)
            ->select('woreda')
            ->distinct()
            ->orderBy('organization_name', 'ASC')
            ->pluck('woreda');

        $query =Iluu::query();

        if ($woreda) {
            $query->where('woreda', $woreda);
        }

        $reports = $query->paginate(10);

        $reports->getCollection()->transform(function ($item, $key) use ($reports) {
            $item->row_id = ($reports->currentPage() - 1) * $reports->perPage() + $key + 1;
            $item->has_paid = \DB::table('zone_member_pays')
                ->where('member_id', $item->id)
                ->where('model', 'iluu')
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->exists();
            return $item;
        });

        return view('organization.iluu.index', compact('reports','count','name','export','woredas','woreda','zone'));
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

        return view('organization.iluu.create', compact('jsonOptions','joption'));
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
            'email' => 'nullable|email|unique:i_a_booraa',
            'payment_period' => 'nullable|string',
            'member_started' => 'nullable|date',
            'payment' => 'nullable|numeric',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $documentname;

       Iluu::create($validated);

        return redirect()->route('iluu.index')->with('success','iluu Member Created Successfully');
    }

    public function edit($id)
    {
        $iluu =Iluu::findOrFail($id);

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

        return view('organization.iluu.edit', compact('iluu','jsonOptions','joption'));
    }

    public function update(Request $request, $id)
    {
        $iluu =Iluu::findOrFail($id);

        $last_thumb = $iluu->image;
        $documentname = $iluu->document;

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
            'email' => 'nullable|email|unique:i_a_booraa',
            'payment_period' => 'nullable|string',
            'member_started' => 'nullable|date',
            'payment' => 'nullable|numeric',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $documentname;

        $iluu->update($validated);

        return redirect()->route('iluu.index')->with('update','iluu Member Updated Successfully');
    }

    public function destroy($id)
    {
        $iluu =Iluu::findOrFail($id);
        $iluu->delete();

        return redirect()->route('iluu.index')->with('delete','iluu Member Deleted Successfully');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        try {
            $maxId =Iluu::max('id');
            Excel::import(new IluuImport($maxId), $request->file('file'));

            return redirect()->route('iluu.index')->with('success','iluu Imported Successfully');
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function pay($id)
    {
        $member =Iluu::findOrFail($id);
        $model = "iluu";

        return view('organization.iluu.create', compact('member', 'model'));
    }
}
