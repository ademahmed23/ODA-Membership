<?php

namespace App\Http\Controllers\Organization;

use App\Models\Organization\Jimmaa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use App\Imports\Organization\JimmaaImport;

class JimmaaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:jimmaa-list|jimmaa-create|jimmaa-edit|jimmaa-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:jimmaa-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:jimmaa-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:jimmaa-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $zone = 'jimmaa';
        $count = Jimmaa::count();
        $name = 'jimmaa';
        $export = true;
        $woreda = $request->woreda;

        $woredas = \DB::table($zone)
            ->select('woreda')
            ->distinct()
            ->orderBy('organization_name', 'ASC')
            ->pluck('woreda');

        $query = Jimmaa::query();

        if ($woreda) {
            $query->where('woreda', $woreda);
        }

        $reports = $query->paginate(10);

        $reports->getCollection()->transform(function ($item, $key) use ($reports) {
            $item->row_id = ($reports->currentPage() - 1) * $reports->perPage() + $key + 1;
            $item->has_paid = \DB::table('zone_member_pays')
                ->where('member_id', $item->id)
                ->where('model', 'jimmaa')
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->exists();
            return $item;
        });

        return view('organization.jimmaa.index', compact('reports','count','name','export','woredas','woreda','zone'));
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

        return view('organization.jimmaa.create', compact('jsonOptions','joption'));
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
            'email' => 'nullable|email|unique:jimmaa',
            'payment_period' => 'nullable|string',
            'member_started' => 'nullable|date',
            'payment' => 'nullable|numeric',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $documentname;

        Jimmaa::create($validated);

        return redirect()->route('jimmaa.index')->with('success','jimmaa Member Created Successfully');
    }

    public function edit($id)
    {
        $jimmaa = Jimmaa::findOrFail($id);

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

        return view('organization.jimmaa.edit', compact('jimmaa','jsonOptions','joption'));
    }

    public function update(Request $request, $id)
    {
        $jimmaa = Jimmaa::findOrFail($id);

        $last_thumb = $jimmaa->image;
        $documentname = $jimmaa->document;

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
            'email' => 'nullable|email|unique:jimmaa',
            'payment_period' => 'nullable|string',
            'member_started' => 'nullable|date',
            'payment' => 'nullable|numeric',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $documentname;

        $jimmaa->update($validated);

        return redirect()->route('jimmaa.index')->with('update','jimmaa Member Updated Successfully');
    }

    public function destroy($id)
    {
        $jimmaa = Jimmaa::findOrFail($id);
        $jimmaa->delete();

        return redirect()->route('jimmaa.index')->with('delete','jimmaa Member Deleted Successfully');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        try {
            $maxId = Jimmaa::max('id');
            Excel::import(new jimmaaImport($maxId), $request->file('file'));

            return redirect()->route('jimmaa.index')->with('success','jimmaa Imported Successfully');
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function pay($id)
    {
        $member = Jimmaa::findOrFail($id);
        $model = "jimmaa";

        return view('organization.jimmaa.create', compact('member', 'model'));
    }
}
