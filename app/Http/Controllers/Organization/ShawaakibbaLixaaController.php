<?php

namespace App\Http\Controllers\Organization;

use App\Models\Organization\Baalee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use App\Imports\Organization\BaaleeImport;

class BaaleeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:baalee-list|baalee-create|baalee-edit|baalee-delete', ['only' => ['index','store']]);
        $this->middleware('permission:baalee-create', ['only' => ['create','store']]);
        $this->middleware('permission:baalee-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:baalee-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $zone = 'baalee';
        $count = Baalee::count();
        $name = 'Baalee';
        $export = true;
        $woreda = $request->woreda;

        // GET DISTINCT WOREDA
        $woredas = \DB::table($zone)
            ->select('woreda')
            ->distinct()
            ->orderBy('organization_name', 'ASC')
            ->pluck('woreda');

        // BASE QUERY
        $query = Baalee::query();

        if ($woreda) {
            $query->where('woreda', $woreda);
        }

        $reports = $query->paginate(10);

        // COMPUTED FIELDS
        $reports->getCollection()->transform(function ($item, $key) use ($reports) {
            $item->row_id = ($reports->currentPage() - 1) * $reports->perPage() + $key + 1;
            $item->has_paid = \DB::table('zone_member_pays')
                ->where('member_id', $item->id)
                ->where('model', 'baalee')
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->exists();
            return $item;
        });

        return view('organization.baalee.index', compact(
            'reports','count','name','export','woredas','woreda','zone'
        ));
    }

    public function create()
    {
        // CHANGE THESE WOREDA NAMES TO BAALEE WOREDA LIST
        $woredas = [
             'Agaarfaa',
            'Barbaree',
            'Diinshoo',
            'D/Mannaa',
            'Gaasaraa',
            'Goobbaa',
            'Gooroo',
            'Gu/dha.',
            'H/Bulluq',
            'M/Goobbaa',
            'M/Walaabuu',
            'Sinaanaa',
            'Bu/M/Roobee',
        ];

        $options = [];
        foreach ($woredas as $w) {
            $options[] = ['id' => $w, 'text' => $w];
        }

        $jsonOptions = json_encode($options);

        $organization_type = [
            'Dhaabbataa Miti-Mootummaa',
            'Dhaabbataa Mootummaa'
        ];

        $org_option = [];
        foreach ($organization_type as $o) {
            $org_option[] = ['id' => $o, 'text' => $o];
        }

        $joption = json_encode($org_option);

        return view('organization.baalee.create', compact('jsonOptions','joption'));
    }

    public function store(Request $request)
    {
        // IMAGE UPLOAD
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);
            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = null;
        }

        // DOCUMENT UPLOAD
        if ($request->hasFile('document')) {
            $doc = $request->file('document');
            $docName = time() . '.' . $doc->getClientOriginalExtension();
            $doc->move(public_path('/Document'), $docName);
        } else {
            $docName = 'default.pdf';
        }

        // VALIDATION
        $validated = $request->validate([
            'member_id'         => 'required|string',
            'organization_name' => 'required|string',
            'organization_type' => 'nullable|string',
            'woreda'            => 'nullable|string',
            'phone_number'      => 'nullable|numeric|digits_between:9,14',
            'email'             => 'nullable|email|unique:baalee',
            'payment_period'    => 'nullable|string',
            'member_started'    => 'nullable|date',
            'payment'           => 'nullable|numeric',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $docName;

        Baalee::create($validated);

        return redirect()->route('baalee.index')->with('success','Baalee Member Created Successfully');
    }

    public function edit($id)
    {
        $baalee = Baalee::findOrFail($id);

        // CHANGE WOREDA NAMES FOR BAALEE
        $woredas = [
            'Agaarfaa',
            'Barbaree',
            'Diinshoo',
            'D/Mannaa',
            'Gaasaraa',
            'Goobbaa',
            'Gooroo',
            'Gu/dha.',
            'H/Bulluq',
            'M/Goobbaa',
            'M/Walaabuu',
            'Sinaanaa',
            'Bu/M/Roobee',
        ];

        $options = [];
        foreach ($woredas as $w) {
            $options[] = ['id' => $w, 'text' => $w];
        }

        $jsonOptions = json_encode($options);

        $organization_type = [
            'Dhaabbataa Miti-Mootummaa',
            'Dhaabbataa Mootummaa'
        ];

        $org_option = [];
        foreach ($organization_type as $o) {
            $org_option[] = ['id' => $o, 'text' => $o];
        }

        $joption = json_encode($org_option);

        return view('organization.baalee.edit', compact('baalee','jsonOptions','joption'));
    }

    public function update(Request $request, $id)
    {
        $baalee = Baalee::findOrFail($id);

        // IMAGE UPDATE
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);
            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $baalee->image;
        }

        // DOCUMENT UPDATE
        if ($request->hasFile('document')) {
            $doc = $request->file('document');
            $docName = time() . '.' . $doc->getClientOriginalExtension();
            $doc->move(public_path('/Document'), $docName);
        } else {
            $docName = $baalee->document;
        }

        // VALIDATION
        $validated = $request->validate([
            'member_id'         => 'required|string',
            'organization_name' => 'required|string',
            'organization_type' => 'nullable|string',
            'woreda'            => 'nullable|string',
            'phone_number'      => 'nullable|numeric|digits_between:9,14',
            'email'             => 'nullable|email|unique:baalee',
            'payment_period'    => 'nullable|string',
            'member_started'    => 'nullable|date',
            'payment'           => 'nullable|integer',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $docName;

        $baalee->update($validated);

        return redirect()->route('baalee.index')->with('update','Baalee Member Updated Successfully');
    }

    public function destroy($id)
    {
        $baalee = Baalee::findOrFail($id);
        $baalee->delete();

        return redirect()->route('baalee.index')->with('delete','Baalee Member Deleted Successfully');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        try {
            $maxId = Baalee::max('id');

            Excel::import(new BaaleeImport($maxId), $request->file('file'));

            return redirect()->route('baalee.index')
                ->with('success', 'Baalee Imported successfully');
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function pay($id)
    {
        $member = Baalee::findOrFail($id);
        $model = 'baalee';

        return view('organization.baalee.create', compact('member','model'));
    }
}
