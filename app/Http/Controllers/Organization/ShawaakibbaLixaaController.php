<?php

namespace App\Http\Controllers\Organization;

use App\Models\Organization\ShawaakLixaa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use App\Imports\Organization\ShawaaKibbaLixaaImport;

class ShawaakibbaLixaaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:sh_k_lixaa-list|sh_k_lixaa-create|sh_k_lixaa-edit|sh_k_lixaa-delete', ['only' => ['index','store']]);
        $this->middleware('permission:sh_k_lixaa-create', ['only' => ['create','store']]);
        $this->middleware('permission:sh_k_lixaa-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:sh_k_lixaa-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $zone = 'sh_k_lixaa';
        $count = ShawaakLixaa::count();
        $name = 'Shawaa Kibba Lixaa';
        $export = true;
        $woreda = $request->woreda;

        // GET DISTINCT WOREDA
        $woredas = \DB::table($zone)
            ->select('woreda')
            ->distinct()
            ->orderBy('organization_name', 'ASC')
            ->pluck('woreda');

        // BASE QUERY
        $query = ShawaakLixaa::query();

        if ($woreda) {
            $query->where('woreda', $woreda);
        }

        $reports = $query->paginate(10);

        // COMPUTED FIELDS
        $reports->getCollection()->transform(function ($item, $key) use ($reports) {
            $item->row_id = ($reports->currentPage() - 1) * $reports->perPage() + $key + 1;
            $item->has_paid = \DB::table('zone_member_pays')
                ->where('member_id', $item->id)
                ->where('model', 'sh_k_lixaa')
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->exists();
            return $item;
        });

        return view('organization.sh_k_lixaa.index', compact(
            'reports','count','name','export','woredas','woreda','zone'
        ));
    }

    public function create()
    {
        // CHANGE THESE WOREDA NAMES TO sh_k_lixaa WOREDA LIST
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

        return view('organization.sh_k_lixaa.create', compact('jsonOptions','joption'));
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
            'email'             => 'nullable|email|unique:sh_k_lixaa',
            'payment_period'    => 'nullable|string',
            'member_started'    => 'nullable|date',
            'payment'           => 'nullable|numeric',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $docName;

        ShawaakLixaa::create($validated);

        return redirect()->route('sh_k_lixaa.index')->with('success','sh_k_lixaa Member Created Successfully');
    }

    public function edit($id)
    {
        $sh_k_lixaa = ShawaakLixaa::findOrFail($id);

        // CHANGE WOREDA NAMES FOR sh_k_lixaa
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

        return view('organization.sh_k_lixaa.edit', compact('sh_k_lixaa','jsonOptions','joption'));
    }

    public function update(Request $request, $id)
    {
        $sh_k_lixaa = ShawaakLixaa::findOrFail($id);

        // IMAGE UPDATE
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);
            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $sh_k_lixaa->image;
        }

        // DOCUMENT UPDATE
        if ($request->hasFile('document')) {
            $doc = $request->file('document');
            $docName = time() . '.' . $doc->getClientOriginalExtension();
            $doc->move(public_path('/Document'), $docName);
        } else {
            $docName = $sh_k_lixaa->document;
        }

        // VALIDATION
        $validated = $request->validate([
            'member_id'         => 'required|string',
            'organization_name' => 'required|string',
            'organization_type' => 'nullable|string',
            'woreda'            => 'nullable|string',
            'phone_number'      => 'nullable|numeric|digits_between:9,14',
            'email'             => 'nullable|email|unique:sh_k_lixaa',
            'payment_period'    => 'nullable|string',
            'member_started'    => 'nullable|date',
            'payment'           => 'nullable|integer',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $docName;

        $sh_k_lixaa->update($validated);

        return redirect()->route('sh_k_lixaa.index')->with('update','sh_k_lixaa Member Updated Successfully');
    }

    public function destroy($id)
    {
        $sh_k_lixaa = ShawaakLixaa::findOrFail($id);
        $sh_k_lixaa->delete();

        return redirect()->route('sh_k_lixaa.index')->with('delete','sh_k_lixaa Member Deleted Successfully');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        try {
            $maxId = ShawaakLixaa::max('id');

            Excel::import(new ShawaaKibbaLixaaImport($maxId), $request->file('file'));

            return redirect()->route('sh_k_lixaa.index')
                ->with('success', 'sh_k_lixaa Imported successfully');
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function pay($id)
    {
        $member = ShawaakLixaa::findOrFail($id);
        $model = 'sh_k_lixaa';

        return view('organization.sh_k_lixaa.create', compact('member','model'));
    }
}
