<?php

namespace App\Http\Controllers\Organization;

use App\Models\Organization\Gujii;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use App\Imports\Organization\GujiiImport;

class GujiiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:gujii-list|gujii-create|gujii-edit|gujii-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:gujii-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:gujii-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:gujii-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $zone = 'gujii';
        $count = Gujii::count();
        $name = 'gujii';
        $export = true;
        $woreda = $request->woreda;

        $woredas = \DB::table($zone)
            ->select('woreda')
            ->distinct()
            ->orderBy('organization_name', 'ASC')
            ->pluck('woreda');

        $query = Gujii::query();

        if ($woreda) {
            $query->where('woreda', $woreda);
        }

        $reports = $query->paginate(10);

        $reports->getCollection()->transform(function ($item, $key) use ($reports) {
            $item->row_id = ($reports->currentPage() - 1) * $reports->perPage() + $key + 1;
            $item->has_paid = \DB::table('zone_member_pays')
                ->where('member_id', $item->id)
                ->where('model', 'gujii')
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->exists();
            return $item;
        });

        return view('organization.gujii.index', compact('reports','count','name','export','woredas','woreda','zone'));
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

        return view('organization.gujii.create', compact('jsonOptions','joption'));
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
            'email' => 'nullable|email|unique:gujii',
            'payment_period' => 'nullable|string',
            'member_started' => 'nullable|date',
            'payment' => 'nullable|numeric',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $documentname;

        Gujii::create($validated);

        return redirect()->route('gujii.index')->with('success','gujii Member Created Successfully');
    }

    public function edit($id)
    {
        $gujii = Gujii::findOrFail($id);

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

        return view('organization.gujii.edit', compact('gujii','jsonOptions','joption'));
    }

    public function update(Request $request, $id)
    {
        $gujii = Gujii::findOrFail($id);

        $last_thumb = $gujii->image;
        $documentname = $gujii->document;

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
            'email' => 'nullable|email|unique:gujii',
            'payment_period' => 'nullable|string',
            'member_started' => 'nullable|date',
            'payment' => 'nullable|numeric',
        ]);

        $validated['image'] = $last_thumb;
        $validated['document'] = $documentname;

        $gujii->update($validated);

        return redirect()->route('gujii.index')->with('update','gujii Member Updated Successfully');
    }

    public function destroy($id)
    {
        $gujii = Gujii::findOrFail($id);
        $gujii->delete();

        return redirect()->route('gujii.index')->with('delete','gujii Member Deleted Successfully');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        try {
            $maxId = Gujii::max('id');
            Excel::import(new GujiiImport($maxId), $request->file('file'));

            return redirect()->route('gujii.index')->with('success','gujii Imported Successfully');
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function pay($id)
    {
        $member = Gujii::findOrFail($id);
        $model = "gujii";

        return view('organization.gujii.create', compact('member', 'model'));
    }
}
