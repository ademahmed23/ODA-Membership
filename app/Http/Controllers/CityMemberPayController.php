<?php

namespace App\Http\Controllers;

use App\Models\CityMemberPay;
use Doctrine\DBAL\Schema\View;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;

class CityMemberPayController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');

    //     $this->middleware('permission:cityMemberPay-list|cityMemberPay-create|cityMemberPay-edit|cityMemberPay-delete', ['only' => ['index', 'store']]);

    //     $this->middleware('permission:cityMemberPay-create', ['only' => ['create', 'store']]);

    //     $this->middleware('permission:cityMemberPay-edit', ['only' => ['edit', 'update']]);

    //     $this->middleware('permission:cityMemberPay-delete', ['only' => ['destroy']]);
    // }

    public function index()
    {
        $model = null;
        $pays = CityMemberPay::whereMonth('date', date('m'))->whereYear('date', date('Y'))->get();
        return view('cityMemberPay.index', compact('model', 'pays'));
    }

    public function get(Request $request)
    {
        $pays = CityMemberPay::where('model', $request->model)->get();
        $model = $request->model;
        return view('cityMemberPay.index', compact('pays', 'model'));
    }

    public function create()
    {
        return view('cityMemberPay.create');
    }
    public function fetch($city)
    {
        $woredas = CityMemberPay::where('model', $city)->select('woreda')->groupBy('woreda')->pluck('woreda');
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
            'position' => 'required',
            'amount' => 'required',
            'date' => 'required',
        ]);

        $cityMemberPay = CityMemberPay::create($validated);

        return redirect()->route('cityMemberPay.index')->with('success', 'CityMemberPay Created successfully');
    }

    public function show($id)
    {
        $cityMemberPay = CityMemberPay::findOrFail($id);
    }

    public function edit($id)
    {
        $cityMemberPay = CityMemberPay::findOrFail($id);

        return view('cityMemberPay.edit', compact('cityMemberPay'));
    }

    public function update(Request $request, $id)
    {
        $cityMemberPay = CityMemberPay::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $cityMemberPay->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $cityMemberPay->document;
        }

        $validated = $request->validate([]);


        $cityMemberPay->update($validated);

        return redirect()->route('cityMemberPay.index')->with('update', 'CityMemberPay Updated successfully');
    }

    public function destroy($id)
    {
        $cityMemberPay = CityMemberPay::findOrFail($id);
        $cityMemberPay->delete();

        return redirect()->route('cityMemberPay.index')->with('delete', 'CityMemberPay Deleted successfully');
    }
}
