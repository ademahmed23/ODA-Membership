<?php

namespace App\Http\Controllers\Organization;

use App\Models\Organization\GujiiLixaa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use App\Imports\Organization\GujiiLixaaImport;

class GujiiLixaaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:gujii_lixaa-list|gujii_lixaa-create|gujii_lixaa-edit|gujii_lixaa-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:gujii_lixaa-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:gujii_lixaa-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:gujii_lixaa-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
     $zone = 'g_lixaa';
    $count = GujiiLixaa::count();
    // $aanaa = Zone1::count('woreda');
    $name = 'g_lixaa';
    $export = true;
    $woreda = $request->woreda;

    // Get distinct woredas
    $woredas = \DB::table($zone)
        ->select('woreda')
        ->distinct()
        ->orderBy('organization_name','Asc')
        ->pluck('woreda');

    // Base query
    $query = GujiiLixaa::query();

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
            ->where('model', 'gujii_lixaa')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->exists();
        return $item;   
    });
    return view('organization.gujii_lixaa.index', compact('reports', 'count', 'name', 'export', 'woredas', 'woreda','zone'));
    }

    public function create()
    {


                $woredas = [
            'Aminyaa',
            'Asakoo',
            'Asallaa',
            'Balee Gasgaar',
            'Boqojjii',
            'Collee',
            'D/Xiijoo',
            'Diksiis',
            'Doddotaa',
            'Gololchaa',
            'Gunaa',
            'Heexosaa',
            'H/Waabee',
            'Jajuu',
            'L/Bilbiloo',
            'L/Heexosaa',
            'Martii',
            'Muunessaa',
            'Roobee',
            'Seeruu',
            'Shanan Kooluu',
            'Siirkaa',
            'Siree',
            'Suudee',
            'Xichoo',
            'Xiyoo',
            'Z/Dugdaa',

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
        return view('organization.gujii_lixaa.create', compact('jsonOptions','joption'));
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
            'email'             => 'nullable|email|unique:g_lixaa',
            'payment_period'    => 'nullable|string',
            'member_started'    => 'nullable|date',
            'payment'           => 'nullable|numeric',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $documentname;

        GujiiLixaa::create($validated);

        return redirect()->route('gujii_lixaa.index')->with('success', 'Gujii Lixaa Member Created Successfully');
    }

    public function show($id)
    {
        $gujii_lixaa = GujiiLixaa::findOrFail($id);
    }

    public function edit($id)
    {
        $gujii_lixaa = GujiiLixaa::findOrFail($id);

                  $woredas = [
            'Aminyaa',
            'Asakoo',
            'Asallaa',
            'Balee Gasgaar',
            'Boqojjii',
            'Collee',
            'D/Xiijoo',
            'Diksiis',
            'Doddotaa',
            'Gololchaa',
            'Gunaa',
            'Heexosaa',
            'H/Waabee',
            'Jajuu',
            'L/Bilbiloo',
            'L/Heexosaa',
            'Martii',
            'Muunessaa',
            'Roobee',
            'Seeruu',
            'Shanan Kooluu',
            'Siirkaa',
            'Siree',
            'Suudee',
            'Xichoo',
            'Xiyoo',
            'Z/Dugdaa',

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

        return view('organization.gujii_lixaa.edit', compact('gujii_lixaa','joption','jsonOptions'));
    }

    public function update(Request $request, $id)
    {
        $gujii_lixaa = GujiiLixaa::findOrFail($id);

        // Image Update
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);
            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $gujii_lixaa->image;
        }

        // Document Update
        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $gujii_lixaa->document;
        }

        // Validation
        $validated = $request->validate([
            'member_id'         => 'required|string',
            'organization_name' => 'required|string',
            'organization_type' => 'nullable|string',
            'woreda'            => 'nullable|string',
            'phone_number'      => 'nullable|numeric|digits_between:9,14',
            'email'             => 'nullable|email|unique:g_lixaa',
            'payment_period'    => 'nullable|string',
            'member_started'    => 'nullable|date',
            'payment'           => 'nullable|integer',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $documentname;

        $gujii_lixaa->update($validated);

        return redirect()->route('gujii_lixaa.index')->with('update', 'gujii_lixaa Member Updated Successfully');
    }

    public function destroy($id)
    {
        $gujii_lixaa = GujiiLixaa::findOrFail($id);
        $gujii_lixaa->delete();

        return redirect()->route('gujii_lixaa.index')->with('delete', 'Gujii Lixaa Member Deleted Successfully');
    }

      public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
        try {



            $maxId = GujiiLixaa::max('id');

            $file = $request->file('file');
            Excel::import(new GujiiLixaaImport($maxId), $file);
            

            return redirect()->route('gujii_lixaa.index')->with('success', 'gujii_lixaa Imported successfully');
        } catch (\Exception $e) {
            // return redirect()->back()->withErrors($e->getMessage());
            return redirect()->back();
        }
    }

    public function pay($id)
    {
        $member = GujiiLixaa::findOrFail($id);
        $model = "gujii_lixaa";

        return view('organization.gujii_lixaa.create', compact('member', 'model'));
    }
}
