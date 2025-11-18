<?php

namespace App\Http\Controllers;

use App\Models\Abroad;
use App\Models\AbroadMemberPay;
use App\Models\Country;
use Doctrine\DBAL\Schema\View;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;

class AbroadMemberPayController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');

    //     $this->middleware('permission:abroadMemberPay-list|abroadMemberPay-create|abroadMemberPay-edit|abroadMemberPay-delete', ['only' => ['index', 'store']]);

    //     $this->middleware('permission:abroadMemberPay-create', ['only' => ['create', 'store']]);

    //     $this->middleware('permission:abroadMemberPay-edit', ['only' => ['edit', 'update']]);

    //     $this->middleware('permission:abroadMemberPay-delete', ['only' => ['destroy']]);
    // }

    public function index()
    {
        $countries = Country::all();
        $country = null;
        $pays = AbroadMemberPay::whereMonth('date', date('m'))->whereYear('date', date('Y'))->get();
        return view('abroadMemberPay.index', compact('country', 'pays', 'countries'));
    }

    public function get(Request $request)
    {
        $countries = Country::all();
        $pays = AbroadMemberPay::where('country', $request->country)->get();
        $country = $request->country;
        return view('abroadMemberPay.index', compact('pays', 'country', 'countries'));
    }

    public function create()
    {
        $countries = Country::all();
        return view('abroadMemberPay.create', compact('countries'));
    }
    public function fetch($abroad)
    {
        $woredas = AbroadMemberPay::where('abroad', $abroad)->select('woreda')->groupBy('woreda')->pluck('woreda');
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
            'country' => 'required',
            'member_id' => 'required',
            'name' => 'required',
            'position' => 'required',
            'amount' => 'required',
            'date' => 'required',
        ]);

        $abroadMemberPay = AbroadMemberPay::create($validated);

        return redirect()->route('abroadMemberPay.index')->with('success', 'AbroadMemberPay Created successfully');
    }

    public function show($id)
    {
        $abroadMemberPay = AbroadMemberPay::findOrFail($id);
    }

    public function edit($id)
    {
        $abroadMemberPay = AbroadMemberPay::findOrFail($id);

        return view('abroadMemberPay.edit', compact('abroadMemberPay'));
    }

    public function update(Request $request, $id)
    {
        $abroadMemberPay = AbroadMemberPay::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $abroadMemberPay->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $abroadMemberPay->document;
        }

        $validated = $request->validate([]);


        $abroadMemberPay->update($validated);

        return redirect()->route('abroadMemberPay.index')->with('update', 'AbroadMemberPay Updated successfully');
    }

    public function destroy($id)
    {
        $abroadMemberPay = AbroadMemberPay::findOrFail($id);
        $abroadMemberPay->delete();

        return redirect()->route('abroadMemberPay.index')->with('delete', 'AbroadMemberPay Deleted successfully');
    }
}
