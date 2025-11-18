<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\RegionMemberPay;
use Doctrine\DBAL\Schema\View;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;

class RegionMemberPayController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');

    //     $this->middleware('permission:regionMemberPay-list|regionMemberPay-create|regionMemberPay-edit|regionMemberPay-delete', ['only' => ['index', 'store']]);

    //     $this->middleware('permission:regionMemberPay-create', ['only' => ['create', 'store']]);

    //     $this->middleware('permission:regionMemberPay-edit', ['only' => ['edit', 'update']]);

    //     $this->middleware('permission:regionMemberPay-delete', ['only' => ['destroy']]);
    // }

    public function index()
    {
        $regions = Region::all();
        $region = null;
        $pays = RegionMemberPay::whereMonth('date', date('m'))->whereYear('date', date('Y'))->get();
        return view('regionMemberPay.index', compact('region', 'pays', 'regions'));
    }

    public function get(Request $request)
    {
        $regions = Region::all();
        $pays = RegionMemberPay::where('region', $request->region)->get();
        $region = $request->region;
        return view('regionMemberPay.index', compact('pays', 'region', 'regions'));
    }

    public function create()
    {
        $regions = Region::all();
        return view('regionMemberPay.create', compact('regions'));
    }
    public function fetch($region)
    {
        $woredas = RegionMemberPay::where('region', $region)->select('woreda')->groupBy('woreda')->pluck('woreda');
        return response()->json($woredas);
    }
    public function store(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = null;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = 'default.pdf';
        }

        $validated = $request->validate([
            'region' => 'required',
            'member_id' => 'required',
            'name' => 'required',
            'position' => 'required',
            'amount' => 'required',
            'date' => 'required',
        ]);

        $regionMemberPay = RegionMemberPay::create($validated);

        return redirect()->route('regionMemberPay.index')->with('success', 'RegionMemberPay Created successfully');
    }

    public function show($id)
    {
        $regionMemberPay = RegionMemberPay::findOrFail($id);
    }

    public function edit($id)
    {
        $regionMemberPay = RegionMemberPay::findOrFail($id);

        return view('regionMemberPay.edit', compact('regionMemberPay'));
    }

    public function update(Request $request, $id)
    {
        $regionMemberPay = RegionMemberPay::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $regionMemberPay->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $regionMemberPay->document;
        }

        $validated = $request->validate([]);


        $regionMemberPay->update($validated);

        return redirect()->route('regionMemberPay.index')->with('update', 'RegionMemberPay Updated successfully');
    }

    public function destroy($id)
    {
        $regionMemberPay = RegionMemberPay::findOrFail($id);
        $regionMemberPay->delete();

        return redirect()->route('regionMemberPay.index')->with('delete', 'RegionMemberPay Deleted successfully');
    }
}
