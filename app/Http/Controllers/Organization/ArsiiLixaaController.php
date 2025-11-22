<?php

namespace App\Http\Controllers\Organization;

use App\Models\Organization\ArsiiLixaa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use App\Imports\Organization\ArsiiLixaaImport;

class ArsiiLixaaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:arsii_lixaa-list|arsii_lixaa-create|arsii_lixaa-edit|arsii_lixaa-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:arsii_lixaa-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:arsii_lixaa-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:arsii_lixaa-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
     $zone = 'arsii_lixaa';
    $count = ArsiiLixaa::count();
    // $aanaa = Zone1::count('woreda');
    $name = 'Arsii Lixaa';
    $export = true;
    $woreda = $request->woreda;

    // Get distinct woredas
    $woredas = \DB::table($zone)
        ->select('woreda')
        ->distinct()
        ->orderBy('organization_name','Asc')
        ->pluck('woreda');

    // Base query
    $query = ArsiiLixaa::query();

    // Filter by woreda if provided
    if ($woreda) {
        $query->where('woreda', $woreda);
    }

    // Use pagination instead of get()
    $reports = $query->paginate(10); // 10 items per page

    // Add computed fields
    $reports->getCollection()->transform(function ($item, $key) use ($reports) {
        $item->row_id = ($reports->currentPage() - 1) * $reports->perPage() + $key + 1; // continuous numbering
        $item->has_paid = \DB::table('zone_member_pays')
            ->where('member_id', $item->id)
            ->where('model', 'arsii_lixaa')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->exists();
        return $item;   
    });
    return view('organization.arsii_lixaa.index', compact('reports', 'count', 'name', 'export', 'woredas', 'woreda','zone'));
    }

    public function create()
    {


                $woredas = [
               'Adaabba',
            'A/A/Nagellee',
            'A/Sha/ne',
            'G/Hasaasaa',
            'A/Kofalee',
            'A/Dodolaa',
            'Kokkosaa',
            'Nansaboo',
            'A/Qoree',
            'A/Shallaa',
            'A/Siraaroo',
            'A/Wandoo',
            'H/Arsii',
            'M/N/Arsii',
            'M/Dodolaa',
            'M/Kofalee',
            'M/B/Gurachaa'

        ];

        

        $options = [];
        foreach ($woredas as $woreda) {
            $options[] = ['id' => $woreda, 'text' => $woreda];
        }

        $jsonOptions = json_encode($options);
        $organazationtpye = [
            'Dhaabbataa Miti-Mootummaa',
            'Dhaabbataa Mootummaa'
        ];
        $org_option = [];
        foreach($organazationtpye as $org){
            $org_option[] = ['id'=> $org, 'text'=> $org];
        }
        $joption = json_encode($org_option);

        return view('organization.arsii_lixaa.create', compact('jsonOptions','joption'));
    }

    public function store(Request $request)
    {
        // Image Upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);
            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = null;
        }

        // Document Upload
        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = 'default.pdf';
        }

        // Validation
        $validated = $request->validate([
            'member_id'         => 'required|string',
            'organization_name' => 'required|string',
            'organization_type' => 'nullable|string',
            'woreda'            => 'nullable|string',
            'phone_number'      => 'nullable|numeric|digits_between:9,14',
            'email'             => 'nullable|email|unique:arsii_lixaa',
            'payment_period'    => 'nullable|string',
            'member_started'    => 'nullable|date',
            'payment'           => 'nullable|numeric',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $documentname;

        ArsiiLixaa::create($validated);

        return redirect()->route('arsii_lixaa.index')->with('success', 'Arsii Member Created Successfully');
    }

    public function show($id)
    {
        $arsii = ArsiiLixaa::findOrFail($id);
    }

    public function edit($id)
    {
        $arsii_lixaa = ArsiiLixaa::findOrFail($id);
          $woredas = [
               'Adaabba',
            'A/A/Nagellee',
            'A/Sha/ne',
            'G/Hasaasaa',
            'A/Kofalee',
            'A/Dodolaa',
            'Kokkosaa',
            'Nansaboo',
            'A/Qoree',
            'A/Shallaa',
            'A/Siraaroo',
            'A/Wandoo',
            'H/Arsii',
            'M/N/Arsii',
            'M/Dodolaa',
            'M/Kofalee',
            'M/B/Gurachaa'

        ];

        

        $options = [];
        foreach ($woredas as $woreda) {
            $options[] = ['id' => $woreda, 'text' => $woreda];
        }

        $jsonOptions = json_encode($options);
          $organazationtpye = [
            'Dhaabbataa Miti-Mootummaa',
            'Dhaabbataa Mootummaa'
        ];
        $org_option = [];
        foreach($organazationtpye as $org){
            $org_option[] = ['id'=> $org, 'text'=> $org];
        }
        $joption = json_encode($org_option);

        return view('organization.arsii_lixaa.edit', compact('arsii_lixaa','joption','jsonOptions'));
    }

    public function update(Request $request, $id)
    {
        $arsii = ArsiiLixaa::findOrFail($id);

        // Image Update
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);
            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $arsii->image;
        }

        // Document Update
        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $arsii->document;
        }

        // Validation
        $validated = $request->validate([
            'member_id'         => 'required|string',
            'organization_name' => 'required|string',
            'organization_type' => 'nullable|string',
            'woreda'            => 'nullable|string',
            'phone_number'      => 'nullable|numeric|digits_between:9,14',
            'email'             => 'nullable|email|unique:arsii_lixaa',
            'payment_period'    => 'nullable|string',
            'member_started'    => 'nullable|date',
            'payment'           => 'nullable|integer',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $documentname;

        $arsii->update($validated);

        return redirect()->route('arsii_lixaa.index')->with('update', 'Arsii Member Updated Successfully');
    }

    public function destroy($id)
    {
        $arsii = ArsiiLixaa::findOrFail($id);
        $arsii->delete();

        return redirect()->route('arsii_lixaa.index')->with('delete', 'Arsii Member Deleted Successfully');
    }

      public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
        try {



            $maxId = ArsiiLixaa::max('id');

            $file = $request->file('file');
            Excel::import(new ArsiiLixaaImport($maxId), $file);
            

            return redirect()->route('arsii_lixaa.index')->with('success', 'Arsii Lixaa Imported successfully');
        } catch (\Exception $e) {
            // return redirect()->back()->withErrors($e->getMessage());
            return redirect()->back();
        }
    }

    public function pay($id)
    {
        $member = ArsiiLixaa::findOrFail($id);
        $model = "arsii_lixaa";

        return view('organization.arsii_lixaa.create', compact('member', 'model'));
    }
}
