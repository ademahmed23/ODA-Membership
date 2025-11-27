<?php

namespace App\Http\Controllers\Organization;

use App\Models\Organization\Buunnoo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use App\Imports\Organization\BuunnooImport;

class BuunnooBeddelleeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:buunnoo-list|buunnoo-create|buunnoo-edit|buunnoo-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:buunnoo-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:buunnoo-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:buunnoo-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $zone = 'b_baddalle';
        $count = Buunnoo::count();
        $name = 'b_baddalle';
        $export = true;
        $woreda = $request->woreda;

        $woredas = \DB::table($zone)
            ->select('woreda')
            ->distinct()
            ->orderBy('organization_name', 'ASC')
            ->pluck('woreda');

        $query = Buunnoo::query();

        if ($woreda) {
            $query->where('woreda', $woreda);
        }

        $reports = $query->paginate(10);

        $reports->getCollection()->transform(function ($item, $key) use ($reports) {
            $item->row_id = ($reports->currentPage() - 1) * $reports->perPage() + $key + 1;
            $item->has_paid = \DB::table('zone_member_pays')
                ->where('member_id', $item->id)
                ->where('model', 'buunnoo')
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->exists();
            return $item;
        });

        return view('organization.buunnoo.index', compact('reports','count','name','export','woredas','woreda','zone'));
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

        return view('organization.buunnoo.create', compact('jsonOptions','joption'));
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
            'email' => 'nullable|email|unique:b_badelle',
            'payment_period' => 'nullable|string',
            'member_started' => 'nullable|date',
            'payment' => 'nullable|numeric',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $documentname;

        Buunnoo::create($validated);

        return redirect()->route('buunnoo.index')->with('success','buunnoo Member Created Successfully');
    }

    public function edit($id)
    {
        $buunnoo = Buunnoo::findOrFail($id);

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

        return view('organization.buunnoo.edit', compact('buunnoo','jsonOptions','joption'));
    }

    public function update(Request $request, $id)
    {
        $buunnoo = Buunnoo::findOrFail($id);

        $last_thumb = $buunnoo->image;
        $documentname = $buunnoo->document;

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
            'email' => 'nullable|email|unique:b_baddalle',
            'payment_period' => 'nullable|string',
            'member_started' => 'nullable|date',
            'payment' => 'nullable|numeric',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $documentname;

        $buunnoo->update($validated);

        return redirect()->route('buunnoo.index')->with('update','buunnoo Member Updated Successfully');
    }

    public function destroy($id)
    {
        $buunnoo = Buunnoo::findOrFail($id);
        $buunnoo->delete();

        return redirect()->route('buunnoo.index')->with('delete','buunnoo Member Deleted Successfully');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        try {
            $maxId = Buunnoo::max('id');
            Excel::import(new buunnooImport($maxId), $request->file('file'));

            return redirect()->route('buunnoo.index')->with('success','buunnoo Imported Successfully');
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function pay($id)
    {
        $member = Buunnoo::findOrFail($id);
        $model = "buunnoo";

        return view('organization.buunnoo.create', compact('member', 'model'));
    }
}
