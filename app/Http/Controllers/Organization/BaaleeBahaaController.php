<?php

namespace App\Http\Controllers\Organization;

use App\Models\Organization\BaaleeBahaa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use App\Imports\Organization\BaaleeBahaaImport;

class BaaleeBahaaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:baalee_bahaa-list|baalee_bahaa-create|baalee_bahaa-edit|baalee_bahaa-delete', ['only' => ['index','store']]);
        $this->middleware('permission:baalee_bahaa-create', ['only' => ['create','store']]);
        $this->middleware('permission:baalee_bahaa-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:baalee_bahaa-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $zone = 'b_bahaa';
        $count = BaaleeBahaa::count();
        $name = 'Baalee Bahaa';
        $export = true;
        $woreda = $request->woreda;

        $woredas = \DB::table($zone)
            ->select('woreda')
            ->distinct()
            ->orderBy('organization_name', 'ASC')
            ->pluck('woreda');

        $query = BaaleeBahaa::query();
        if ($woreda) {
            $query->where('woreda', $woreda);
        }

        $reports = $query->paginate(10);

        $reports->getCollection()->transform(function ($item, $key) use ($reports) {
            $item->row_id = ($reports->currentPage() - 1) * $reports->perPage() + $key + 1;
            $item->has_paid = \DB::table('zone_member_pays')
                ->where('member_id', $item->id)
                ->where('model', 'b_bahaa')
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->exists();
            return $item;
        });

        return view('organization.baalee_bahaa.index', compact('reports','count','name','export','woredas','woreda','zone'));
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

        return view('organization.baalee_bahaa.create', compact('jsonOptions','joption'));
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
            'email' => 'nullable|email|unique:b_bahaa',
            'payment_period' => 'nullable|string',
            'member_started' => 'nullable|date',
            'payment' => 'nullable|numeric',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $docName;

        BaaleeBahaa::create($validated);

        return redirect()->route('baalee_bahaa.index')->with('success','Baalee Bahaa Member Created Successfully');
    }

    public function edit($id)
    {
        $baalee = BaaleeBahaa::findOrFail($id);

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

        return view('organization.baalee_bahaa.edit', compact('baalee','jsonOptions','joption'));
    }

    public function update(Request $request, $id)
    {
        $baalee = BaaleeBahaa::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);
            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $baalee->image;
        }

        if ($request->hasFile('document')) {
            $doc = $request->file('document');
            $docName = time() . '.' . $doc->getClientOriginalExtension();
            $doc->move(public_path('/Document'), $docName);
        } else {
            $docName = $baalee->document;
        }

        $validated = $request->validate([
            'member_id' => 'required|string',
            'organization_name' => 'required|string',
            'organization_type' => 'nullable|string',
            'woreda' => 'nullable|string',
            'phone_number' => 'nullable|numeric|digits_between:9,14',
            'email' => 'nullable|email|unique:b_bahaa,email,'.$id,
            'payment_period' => 'nullable|string',
            'member_started' => 'nullable|date',
            'payment' => 'nullable|numeric',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $docName;

        $baalee->update($validated);

        return redirect()->route('baalee_bahaa.index')->with('update','Baalee Bahaa Member Updated Successfully');
    }

    public function destroy($id)
    {
        $baalee = BaaleeBahaa::findOrFail($id);
        $baalee->delete();

        return redirect()->route('baalee_bahaa.index')->with('delete','Baalee Bahaa Member Deleted Successfully');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        try {
            $maxId = BaaleeBahaa::max('id');
            Excel::import(new BaaleeBahaaImport($maxId), $request->file('file'));

            return redirect()->route('baalee_bahaa.index')
                ->with('success','Baalee Bahaa Imported successfully');
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function pay($id)
    {
        $member = BaaleeBahaa::findOrFail($id);
        $model = 'baalee_bahaa';

        return view('organization.baalee_bahaa.create', compact('member','model'));
    }
}
