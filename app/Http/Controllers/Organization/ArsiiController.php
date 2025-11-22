<?php

namespace App\Http\Controllers\Organization;

use App\Models\Organization\Arsii;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use App\Imports\Organization\ArsiiImport;

class ArsiiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:arsii-list|arsii-create|arsii-edit|arsii-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:arsii-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:arsii-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:arsii-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
     $zone = 'arsii';
    $count = Arsii::count();
    // $aanaa = Zone1::count('woreda');
    $name = 'Arsii';
    $export = true;
    $woreda = $request->woreda;

    // Get distinct woredas
    $woredas = \DB::table($zone)
        ->select('woreda')
        ->distinct()
        ->orderBy('organization_name','Asc')
        ->pluck('woreda');

    // Base query
    $query = Arsii::query();

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
            ->where('model', 'arsii')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->exists();
        return $item;   
    });
    return view('organization.arsii.index', compact('reports', 'count', 'name', 'export', 'woredas', 'woreda','zone'));
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
        return view('organization.arsii.create', compact('jsonOptions','joption'));
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
            'email'             => 'nullable|email|unique:arsii',
            'payment_period'    => 'nullable|string',
            'member_started'    => 'nullable|date',
            'paymemt'           => 'nullable|numeric',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $documentname;

        Arsii::create($validated);

        return redirect()->route('arsii.index')->with('success', 'Arsii Member Created Successfully');
    }

    public function show($id)
    {
        $arsii = Arsii::findOrFail($id);
    }

    public function edit($id)
    {
        $arsii = Arsii::findOrFail($id);

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

        return view('organization.arsii.edit', compact('arsii','joption','jsonOptions'));
    }

    public function update(Request $request, $id)
    {
        $arsii = Arsii::findOrFail($id);

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
            'email'             => 'nullable|email|unique:arsii',
            'payment_period'    => 'nullable|string',
            'member_started'    => 'nullable|date',
            'paymemt'           => 'nullable|integer',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $documentname;

        $arsii->update($validated);

        return redirect()->route('arsii.index')->with('update', 'Arsii Member Updated Successfully');
    }

    public function destroy($id)
    {
        $arsii = Arsii::findOrFail($id);
        $arsii->delete();

        return redirect()->route('arsii.index')->with('delete', 'Arsii Member Deleted Successfully');
    }

      public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
        try {



            $maxId = Arsii::max('id');

            $file = $request->file('file');
            Excel::import(new ArsiiImport($maxId), $file);
            

            return redirect()->route('arsii.index')->with('success', 'Arsii Imported successfully');
        } catch (\Exception $e) {
            // return redirect()->back()->withErrors($e->getMessage());
            return redirect()->back();
        }
    }

    public function pay($id)
    {
        $member = Arsii::findOrFail($id);
        $model = "arsii";

        return view('organization.arsii.create', compact('member', 'model'));
    }
}
