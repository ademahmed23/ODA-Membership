<?php

namespace App\Http\Controllers\Organization;

use App\Models\Organization\ShawaaBahaa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use App\Imports\Organization\ShawaaBahaaImport;

class ShawaaBahaaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:sh_bahaa-list|sh_bahaa-create|sh_bahaa-edit|sh_bahaa-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:sh_bahaa-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:sh_bahaa-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:sh_bahaa-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $zone = 'sh_bahaa';
        $count = ShawaaBahaa::count();
        $name = 'Shawaa Bahaa';
        $export = true;
        $woreda = $request->woreda;

        $woredas = \DB::table($zone)
            ->select('woreda')
            ->distinct()
            ->orderBy('organization_name', 'ASC')
            ->pluck('woreda');

        $query = ShawaaBahaa::query();

        if ($woreda) {
            $query->where('woreda', $woreda);
        }

        $reports = $query->paginate(10);

        $reports->getCollection()->transform(function ($item, $key) use ($reports) {
            $item->row_id = ($reports->currentPage() - 1) * $reports->perPage() + $key + 1;
            $item->has_paid = \DB::table('zone_member_pays')
                ->where('member_id', $item->id)
                ->where('model', 'sh_bahaa')
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->exists();
            return $item;
        });

        return view('organization.sh_bahaa.index', compact('reports','count','name','export','woredas','woreda','zone'));
    }

    public function create()
    {
        $woredas = [
           'Od/Shakkisoo',
            'Mag/Shakkiso',
            'Mag/Adoola',
            'Aagaa Waayyuu',
            'Booree',
            'Girjaa',
            'Adoola-Reeddee',
            'Waadaraa',
            'Uraaga',
            'S/Borruu',
            'Annaa Sorraa',
            'Liiban',
            'Ardaa jilaa',
            'Daamaa',
            'mag/Nagellee'
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

        return view('organization.sh_bahaa.create', compact('jsonOptions','joption'));
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
            'email' => 'nullable|email|unique:sh_bahaa',
            'payment_period' => 'nullable|string',
            'member_started' => 'nullable|date',
            'payment' => 'nullable|numeric',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $documentname;

        ShawaaBahaa::create($validated);

        return redirect()->route('sh_bahaa.index')->with('success','sh_bahaa Member Created Successfully');
    }

    public function edit($id)
    {
        $sh_bahaa = ShawaaBahaa::findOrFail($id);

        $woredas = [
           'Od/Shakkisoo',
            'Mag/Shakkiso',
            'Mag/Adoola',
            'Aagaa Waayyuu',
            'Booree',
            'Girjaa',
            'Adoola-Reeddee',
            'Waadaraa',
            'Uraaga',
            'S/Borruu',
            'Annaa Sorraa',
            'Liiban',
            'Ardaa jilaa',
            'Daamaa',
            'mag/Nagellee'
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

        return view('organization.sh_bahaa.edit', compact('sh_bahaa','jsonOptions','joption'));
    }

    public function update(Request $request, $id)
    {
        $sh_bahaa = ShawaaBahaa::findOrFail($id);

        $last_thumb = $sh_bahaa->image;
        $documentname = $sh_bahaa->document;

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
            'email' => 'nullable|email|unique:sh_bahaa',
            'payment_period' => 'nullable|string',
            'member_started' => 'nullable|date',
            'payment' => 'nullable|numeric',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $documentname;

        $sh_bahaa->update($validated);

        return redirect()->route('sh_bahaa.index')->with('update','sh_bahaa Member Updated Successfully');
    }

    public function destroy($id)
    {
        $sh_bahaa = ShawaaBahaa::findOrFail($id);
        $sh_bahaa->delete();

        return redirect()->route('sh_bahaa.index')->with('delete','sh_bahaa Member Deleted Successfully');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        try {
            $maxId = ShawaaBahaa::max('id');
            Excel::import(new ShawaaBahaaImport($maxId), $request->file('file'));

            return redirect()->route('sh_bahaa.index')->with('success','sh_bahaa Imported Successfully');
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function pay($id)
    {
        $member = ShawaaBahaa::findOrFail($id);
        $model = "sh_bahaa";

        return view('organization.sh_bahaa.create', compact('member', 'model'));
    }
}
