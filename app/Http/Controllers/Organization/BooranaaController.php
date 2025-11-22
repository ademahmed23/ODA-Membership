<?php

namespace App\Http\Controllers\Organization;

use App\Models\Organization\Booranaa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use App\Imports\Organization\BooranaaImport;

class BooranaaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:booranaa-list|booranaa-create|booranaa-edit|booranaa-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:booranaa-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:booranaa-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:booranaa-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $zone = 'booranaa';
        $count = Booranaa::count();
        $name = 'Booranaa';
        $export = true;
        $woreda = $request->woreda;

        $woredas = \DB::table($zone)
            ->select('woreda')
            ->distinct()
            ->orderBy('organization_name', 'ASC')
            ->pluck('woreda');

        $query = Booranaa::query();

        if ($woreda) {
            $query->where('woreda', $woreda);
        }

        $reports = $query->paginate(10);

        $reports->getCollection()->transform(function ($item, $key) use ($reports) {
            $item->row_id = ($reports->currentPage() - 1) * $reports->perPage() + $key + 1;
            $item->has_paid = \DB::table('zone_member_pays')
                ->where('member_id', $item->id)
                ->where('model', 'booranaa')
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->exists();
            return $item;
        });

        return view('organization.booranaa.index', compact('reports','count','name','export','woredas','woreda','zone'));
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

        return view('organization.booranaa.create', compact('jsonOptions','joption'));
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
            'email' => 'nullable|email|unique:booranaa',
            'payment_period' => 'nullable|string',
            'member_started' => 'nullable|date',
            'payment' => 'nullable|numeric',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $documentname;

        Booranaa::create($validated);

        return redirect()->route('booranaa.index')->with('success','Booranaa Member Created Successfully');
    }

    public function edit($id)
    {
        $booranaa = Booranaa::findOrFail($id);

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

        return view('organization.booranaa.edit', compact('booranaa','jsonOptions','joption'));
    }

    public function update(Request $request, $id)
    {
        $booranaa = Booranaa::findOrFail($id);

        $last_thumb = $booranaa->image;
        $documentname = $booranaa->document;

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
            'email' => 'nullable|email|unique:booranaa',
            'payment_period' => 'nullable|string',
            'member_started' => 'nullable|date',
            'payment' => 'nullable|numeric',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $documentname;

        $booranaa->update($validated);

        return redirect()->route('booranaa.index')->with('update','Booranaa Member Updated Successfully');
    }

    public function destroy($id)
    {
        $booranaa = Booranaa::findOrFail($id);
        $booranaa->delete();

        return redirect()->route('booranaa.index')->with('delete','Booranaa Member Deleted Successfully');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        try {
            $maxId = Booranaa::max('id');
            Excel::import(new BooranaaImport($maxId), $request->file('file'));

            return redirect()->route('booranaa.index')->with('success','Booranaa Imported Successfully');
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function pay($id)
    {
        $member = Booranaa::findOrFail($id);
        $model = "booranaa";

        return view('organization.booranaa.create', compact('member', 'model'));
    }
}
