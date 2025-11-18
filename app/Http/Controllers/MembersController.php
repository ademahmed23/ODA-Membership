<?php

namespace App\Http\Controllers;

use App\Models\Members;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Termwind\Components\Dd;

class MembersController
{
    public function index()
    {
        $count = Members::count();

        return view('member.index', compact('count'));
    }

    public function create()
    {
        return view('member.create');
    }

    public function store(Request $request)
    {

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $name_gen = hexdec(uniqid()) . '.' . $photo->getClientOriginalExtension();
            Image::make($photo)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        }
        $validated = $request->validate(
            [
                'name' => 'required',
                'email' => 'nullable|unique:members|',
                'phone' => 'nullable|unique:members|digits_between:9,14|numeric',
                'department' => 'nullable',
                'designation' => 'nullable',
                'workplace' => 'nullable',
                'photo' => 'nullable|mimes:jpg,jpeg,png|max:20048',
            ],
            [
                'name.required' => 'Please Input Name',
                'email.unique' => 'This Email Already Exists',
                'phone.unique' => 'This Phone Number Already Exists',
                'phone.digits_between' => 'Phone Number Must Be Between 9 To 14 Digits',
                'phone.numeric' => 'Phone Number Must Be Numeric',
                'photo.mimes' => 'Photo Must Be jpg,jpeg,png',
                'photo.max' => 'Photo Must Be Less Than 20MB',
            ]
        );


        $members = Members::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'department' => $validated['department'],
            'designation' => $validated['designation'],
            'workplace' => $validated['workplace'],
            'photo' => $last_thumb ?? null,
        ]);

        return redirect()->route('member.index')->with('success', 'Member Added Successfully');
    }

    public function show($id)
    {
        $member = Members::findOrFail($id);
    }

    public function edit($id)
    {
        $member = Members::findOrFail($id);

        return view('member.edit', compact('member'));
    }

    public function update(Request $request, $id)
    {
        $members = Members::findOrFail($id);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $name_gen = hexdec(uniqid()) . '.' . $photo->getClientOriginalExtension();
            Image::make($photo)->save('Photo/' . $name_gen);

            $last_thumb = 'Photo/' . $name_gen;
        }
        $validated = $request->validate(
            [
                'name' => 'required',
                // 'email' => 'nullable|unique:members|' . id,
                'email' => 'nullable|email:rfc,dns|unique:members,email,' . $members->id,
                'phone' => 'nullable|digits_between:9,14|numeric|unique:members,phone,' . $members->id,
                'department' => 'nullable',
                'designation' => 'nullable',
                'workplace' => 'nullable',
                'photo' => 'nullable|mimes:jpg,jpeg,png|max:20048',
            ],
            [
                'name.required' => 'Please Input Name',
                'email.unique' => 'This Email Already Exists',
                'phone.unique' => 'This Phone Number Already Exists',
                'phone.digits_between' => 'Phone Number Must Be Between 9 To 14 Digits',
                'phone.numeric' => 'Phone Number Must Be Numeric',
                'photo.mimes' => 'Photo Must Be jpg,jpeg,png',
                'photo.max' => 'Photo Must Be Less Than 20MB',
            ]
        );

        $members->update([
            'name' => $validated['name'] ?? $members->name,
            'email' => $validated['email'] ?? $members->email,
            'phone' => $validated['phone'] ?? $members->phone,
            'department' => $validated['department'] ?? $members->department,
            'designation' => $validated['designation'] ?? $members->designation,
            'workplace' => $validated['workplace'] ?? $members->workplace,
            'photo' => $last_thumb ?? $members->photo,
        ]);

        return redirect()->route('member.index')->with('update', 'Member Updated Successfully');
    }

    public function destroy($id)
    {
        $members = Members::findOrFail($id);
        $members->delete();

        return redirect()->route('member.index')->with('delete', 'Member Deleted Successfully');
    }
}
