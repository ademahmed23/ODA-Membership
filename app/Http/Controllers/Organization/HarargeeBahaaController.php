<?php

namespace App\Http\Controllers\Organization;

use App\Models\Organization\HarargeeBahaa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use App\Imports\Organization\HarargeeBahaaImport;

class HarargeeBahaaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:h_bahaa-list|h_bahaa-create|h_bahaa-edit|h_bahaa-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:h_bahaa-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:h_bahaa-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:h_bahaa-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
     $zone = 'h_bahaa';
    $count = HarargeeBahaa::count();
    // $aanaa = Zone1::count('woreda');
    $name = 'Harargee Bahaa';
    $export = true;
    $woreda = $request->woreda;

    // Get distinct woredas
    $woredas = \DB::table($zone)
        ->select('woreda')
        ->distinct()
        ->orderBy('organization_name','Asc')
        ->pluck('woreda');

    // Base query
    $query = HarargeeBahaa::query();

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
            ->where('model', 'h_bahaa')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->exists();
        return $item;   
    });
    return view('organization.h_bahaa.index', compact('reports', 'count', 'name', 'export', 'woredas', 'woreda','zone'));
    }

    public function create()
    {


         $woredas = [
    'Baabbilee Aanaa',
    'Baabbilee Magaalaa',
    'Baddannoo',
    'Cinaksaan',
    'Dadar Aanaa',
    'Dadar Magaala',
    'Fadis',
    'Gola Odaa',
    'Gooroo Gootuu',
    'Gooroo Muxii',
    'Guraawaa',
    'Gursum',
    'Haramayaa',
    'Jaarsoo',
    'Kombolchaa',
    'Kurfaa Callee',
    'Malkaa Bal\'oo',
    'Mayaa Magaala',
    'Mayyuu Muluqqee',
    'Meettaa',
    'Miidhagaa Tola',
    'Qarsaa',
    'Qumbii'
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

        return view('organization.h_bahaa.create', compact('jsonOptions','joption'));
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
            'email'             => 'nullable|email|unique:h_bahaa',
            'payment_period'    => 'nullable|string',
            'member_started'    => 'nullable|date',
            'payment'           => 'nullable|numeric',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $documentname;

        HarargeeBahaa::create($validated);

        return redirect()->route('h_bahaa.index')->with('success', 'Harargee Bahaa Member Created Successfully');
    }

    public function show($id)
    {
        $arsii = HarargeeBahaa::findOrFail($id);
    }

    public function edit($id)
    {
        $h_bahaa = HarargeeBahaa::findOrFail($id);
      $woredas = [
    'Baabbilee Aanaa',
    'Baabbilee Magaalaa',
    'Baddannoo',
    'Cinaksaan',
    'Dadar Aanaa',
    'Dadar Magaala',
    'Fadis',
    'Gola Odaa',
    'Gooroo Gootuu',
    'Gooroo Muxii',
    'Guraawaa',
    'Gursum',
    'Haramayaa',
    'Jaarsoo',
    'Kombolchaa',
    'Kurfaa Callee',
    'Malkaa Bal\'oo',
    'Mayaa Magaala',
    'Mayyuu Muluqqee',
    'Meettaa',
    'Miidhagaa Tola',
    'Qarsaa',
    'Qumbii'
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

        return view('organization.h_bahaa.edit', compact('h_bahaa','joption','jsonOptions'));
    }

    public function update(Request $request, $id)
    {
        $h_bahaa = HarargeeBahaa::findOrFail($id);

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
            'email'             => 'nullable|email|unique:h_bahaa',
            'payment_period'    => 'nullable|string',
            'member_started'    => 'nullable|date',
            'payment'           => 'nullable|integer',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $documentname;

        $arsii->update($validated);

        return redirect()->route('h_bahaa.index')->with('update', 'Harargee Bahaa Member Updated Successfully');
    }

    public function destroy($id)
    {
        $arsii = HarargeeBahaa::findOrFail($id);
        $arsii->delete();

        return redirect()->route('h_bahaa.index')->with('delete', 'Harargee Bahaa Member Deleted Successfully');
    }

      public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
        try {



            $maxId = HarargeeBahaa::max('id');

            $file = $request->file('file');
            Excel::import(new HarargeeBahaaImport($maxId), $file);
            

            return redirect()->route('h_bahaa.index')->with('success', 'Harargee Bahaa Imported successfully');
        } catch (\Exception $e) {
            // return redirect()->back()->withErrors($e->getMessage());
            return redirect()->back();
        }
    }

    public function pay($id)
    {
        $member = HarargeeBahaa::findOrFail($id);
        $model = "h_bahaa";

        return view('organization.h_bahaa.create', compact('member', 'model'));
    }
}
