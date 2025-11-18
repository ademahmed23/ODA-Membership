<?php

namespace App\Http\Controllers;

use App\Models\ZoneMemberPay;
use Doctrine\DBAL\Schema\View;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;

class ZoneMemberPayController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');

    //     $this->middleware('permission:zoneMemberPay-list|zoneMemberPay-create|zoneMemberPay-edit|zoneMemberPay-delete', ['only' => ['index', 'store']]);

    //     $this->middleware('permission:zoneMemberPay-create', ['only' => ['create', 'store']]);

    //     $this->middleware('permission:zoneMemberPay-edit', ['only' => ['edit', 'update']]);

    //     $this->middleware('permission:zoneMemberPay-delete', ['only' => ['destroy']]);
    // }

    public function index()
    {
        $model = null;
        $pays = ZoneMemberPay::whereMonth('date', date('m'))->whereYear('date', date('Y'))->get();
        return view('zoneMemberPay.index', compact('model', 'pays'));
    }

    public function get(Request $request)
    {
        $pays = ZoneMemberPay::where('model', $request->model)->where('woreda', $request->woreda)->get();
        $model = $request->model;
        $woreda = $request->woreda;
        return view('zoneMemberPay.index', compact('pays', 'model', 'woreda'));
    }

    public function create()
    {

        return view('zoneMemberPay.create');
    }
    public function fetch($zone)
    {
        $woredas = ZoneMemberPay::where('model', $zone)->select('woreda')->groupBy('woreda')->pluck('woreda');
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
            'model' => 'required',
            'member_id' => 'required',
            'name' => 'required',
            'woreda' => 'required',
            'position' => 'required',
            'amount' => 'required',
            'date' => 'required',
        ]);

        $zoneMemberPay = ZoneMemberPay::create($validated);

        return redirect()->route('zoneMemberPay.index')->with('success', 'ZoneMemberPay Created successfully');
    }

    public function show($id)
    {
        $zoneMemberPay = ZoneMemberPay::findOrFail($id);
    }

    public function edit($id)
    {
        $zoneMemberPay = ZoneMemberPay::findOrFail($id);

        return view('zoneMemberPay.edit', compact('zoneMemberPay'));
    }

    public function update(Request $request, $id)
    {
        $zoneMemberPay = ZoneMemberPay::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $zoneMemberPay->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $zoneMemberPay->document;
        }

        $validated = $request->validate([]);


        $zoneMemberPay->update($validated);

        return redirect()->route('zoneMemberPay.index')->with('update', 'ZoneMemberPay Updated successfully');
    }

    public function destroy($id)
    {
        $zoneMemberPay = ZoneMemberPay::findOrFail($id);
        $zoneMemberPay->delete();

        return redirect()->route('zoneMemberPay.index')->with('delete', 'ZoneMemberPay Deleted successfully');
    }
}
