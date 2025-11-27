<?php

namespace App\Http\Controllers\Organization;

use App\Models\Organization\HarargeeLixaa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use App\Imports\Organization\HarargeeLixaaImport;

class HarargeeLixaaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:h_lixaa-list|h_lixaa-create|h_lixaa-edit|h_lixaa-delete', ['only' => ['index','store']]);
        $this->middleware('permission:h_lixaa-create', ['only' => ['create','store']]);
        $this->middleware('permission:h_lixaa-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:h_lixaa-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $zone = 'h_lixaa';
        $count = HarargeeLixaa::count();
        $name = 'Harargee Lixaa';
        $export = true;
        $woreda = $request->woreda;

        $woredas = \DB::table($zone)
            ->select('woreda')
            ->distinct()
            ->orderBy('organization_name', 'ASC')
            ->pluck('woreda');

        $query = HarargeeLixaa::query();
        if ($woreda) {
            $query->where('woreda', $woreda);
        }

        $reports = $query->paginate(10);

        $reports->getCollection()->transform(function ($item, $key) use ($reports) {
            $item->row_id = ($reports->currentPage() - 1) * $reports->perPage() + $key + 1;
            $item->has_paid = \DB::table('zone_member_pays')
                ->where('member_id', $item->id)
                ->where('model', 'h_lixaa')
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->exists();
            return $item;
        });

        return view('organization.h_lixaa.index', compact('reports','count','name','export','woredas','woreda','zone'));
    }

    public function create()
    {
        $woredas = [
            'M/Gindhiir',
            'A/ Gindhiir',
            'Gololcha',
            'Raayituu',
            'Sawweena',
            'LagaHidhaa',
            'D/Sarar',
            'D/Qachan',
            'Sektara Godina'
        ];

        $options = [];
        foreach ($woredas as $w) {
            $options[] = ['id' => $w, 'text' => $w];
        }
        $jsonOptions = json_encode($options);

        $organization_type = ['Dhaabbataa Miti-Mootummaa', 'Dhaabbataa Mootummaa'];
        $org_option = [];
        foreach ($organization_type as $o) {
            $org_option[] = ['id' => $o, 'text' => $o];
        }
        $joption = json_encode($org_option);

        return view('organization.h_lixaa.create', compact('jsonOptions','joption'));
    }

    public function store(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);
            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = null;
        }

        if ($request->hasFile('document')) {
            $doc = $request->file('document');
            $docName = time() . '.' . $doc->getClientOriginalExtension();
            $doc->move(public_path('/Document'), $docName);
        } else {
            $docName = 'default.pdf';
        }

        $validated = $request->validate([
            'member_id' => 'required|string',
            'organization_name' => 'required|string',
            'organization_type' => 'nullable|string',
            'woreda' => 'nullable|string',
            'phone_number' => 'nullable|numeric|digits_between:9,14',
            'email' => 'nullable|email|unique:h_lixaa',
            'payment_period' => 'nullable|string',
            'member_started' => 'nullable|date',
            'payment' => 'nullable|numeric',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $docName;

        HarargeeLixaa::create($validated);

        return redirect()->route('h_lixaa.index')->with('success','Harargee Lixaa Member Created Successfully');
    }

    public function edit($id)
    {
        $h_lixaa = HarargeeLixaa::findOrFail($id);

        $woredas = [
            'M/Gindhiir',
            'A/ Gindhiir',
            'Gololcha',
            'Raayituu',
            'Sawweena',
            'LagaHidhaa',
            'D/Sarar',
            'D/Qachan',
            'Sektara Godina'
        ];

        $options = [];
        foreach ($woredas as $w) {
            $options[] = ['id' => $w, 'text' => $w];
        }
        $jsonOptions = json_encode($options);

        $organization_type = ['Dhaabbataa Miti-Mootummaa', 'Dhaabbataa Mootummaa'];
        $org_option = [];
        foreach ($organization_type as $o) {
            $org_option[] = ['id' => $o, 'text' => $o];
        }
        $joption = json_encode($org_option);

        return view('organization.h_lixaa.edit', compact('h_lixaa','jsonOptions','joption'));
    }

    public function update(Request $request, $id)
    {
        $h_lixaa = HarargeeLixaa::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);
            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $h_lixaa->image;
        }

        if ($request->hasFile('document')) {
            $doc = $request->file('document');
            $docName = time() . '.' . $doc->getClientOriginalExtension();
            $doc->move(public_path('/Document'), $docName);
        } else {
            $docName = $h_lixaa->document;
        }

        $validated = $request->validate([
            'member_id' => 'required|string',
            'organization_name' => 'required|string',
            'organization_type' => 'nullable|string',
            'woreda' => 'nullable|string',
            'phone_number' => 'nullable|numeric|digits_between:9,14',
            'email' => 'nullable|email|unique:h_lixaa,email,'.$id,
            'payment_period' => 'nullable|string',
            'member_started' => 'nullable|date',
            'payment' => 'nullable|numeric',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $docName;

        $h_lixaa->update($validated);

        return redirect()->route('h_lixaa.index')->with('update','h_lixaa Bahaa Member Updated Successfully');
    }

    public function destroy($id)
    {
        $h_lixaa = HarargeeLixaa::findOrFail($id);
        $h_lixaa->delete();

        return redirect()->route('h_lixaa.index')->with('delete','h_lixaa Bahaa Member Deleted Successfully');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        try {
            $maxId = HarargeeLixaa::max('id');
            Excel::import(new HarargeeLixaaImport($maxId), $request->file('file'));

            return redirect()->route('h_lixaa.index')
                ->with('success','h_lixaa Bahaa Imported successfully');
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function pay($id)
    {
        $member = HarargeeLixaa::findOrFail($id);
        $model = 'h_lixaa';

        return view('organization.h_lixaa.create', compact('member','model'));
    }
}
