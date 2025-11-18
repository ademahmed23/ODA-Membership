<?php

namespace App\Http\Controllers;

use App\Models\Honorable;
use App\Models\HonorableMemberPay;
use App\Models\Country;
use Doctrine\DBAL\Schema\View;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;

class HonorableMemberPayController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');

    //     $this->middleware('permission:honorableMemberPay-list|honorableMemberPay-create|honorableMemberPay-edit|honorableMemberPay-delete', ['only' => ['index', 'store']]);

    //     $this->middleware('permission:honorableMemberPay-create', ['only' => ['create', 'store']]);

    //     $this->middleware('permission:honorableMemberPay-edit', ['only' => ['edit', 'update']]);

    //     $this->middleware('permission:honorableMemberPay-delete', ['only' => ['destroy']]);
    // }

    public function index()
    {
        $pays = HonorableMemberPay::whereMonth('date', date('m'))->whereYear('date', date('Y'))->get();
        return view('honorableMemberPay.index', compact('pays'));
    }

    public function get(Request $request)
    {
        $pays = HonorableMemberPay::get();
        return view('honorableMemberPay.index', compact('pays'));
    }

    public function create()
    {
        return view('honorableMemberPay.create');
    }
    public function fetch($honorable)
    {
        $woredas = HonorableMemberPay::where('honorable', $honorable)->select('woreda')->groupBy('woreda')->pluck('woreda');
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
            'member_id' => 'required',
            'name' => 'required',
            'position' => 'required',
            'amount' => 'required',
            'date' => 'required',
        ]);

        $honorableMemberPay = HonorableMemberPay::create($validated);

        return redirect()->route('honorableMemberPay.index')->with('success', 'HonorableMemberPay Created successfully');
    }

    public function show($id)
    {
        $honorableMemberPay = HonorableMemberPay::findOrFail($id);
    }

    public function edit($id)
    {
        $honorableMemberPay = HonorableMemberPay::findOrFail($id);

        return view('honorableMemberPay.edit', compact('honorableMemberPay'));
    }

    public function update(Request $request, $id)
    {
        $honorableMemberPay = HonorableMemberPay::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        } else {
            $last_thumb = $honorableMemberPay->image;
        }

        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $documentname = time() . '.' . $document->getClientOriginalExtension();
            $document->move(public_path('/Document'), $documentname);
        } else {
            $documentname = $honorableMemberPay->document;
        }

        $validated = $request->validate([]);


        $honorableMemberPay->update($validated);

        return redirect()->route('honorableMemberPay.index')->with('update', 'HonorableMemberPay Updated successfully');
    }

    public function destroy($id)
    {
        $honorableMemberPay = HonorableMemberPay::findOrFail($id);
        $honorableMemberPay->delete();

        return redirect()->route('honorableMemberPay.index')->with('delete', 'HonorableMemberPay Deleted successfully');
    }
}
