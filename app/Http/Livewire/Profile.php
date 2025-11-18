<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Profile extends Component
{
    public $name;

    public $email;

    public $profile_id;

    public function render()
    {
        $user_id = Auth::user()->id;
        $profile = User::where('id', $user_id)->first();
        // $this->profile_id = $profile->id;
        // $this->name = $profile->name;
        // $this->email = $profile->email;
        return view('livewire.profile', compact('profile'));
    }

    // public function edit($id)
    // {
    //     $user_id = Auth::user()->id;
    //     $

    //     $this->profile_id = $id;
    //     $this->name = $profile->name;
    //     $this->email = $profile->email;
    // }
    public function updateProfile()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required',

        ]);
        $user_id = Auth::user()->id;
        $profile = User::find($user_id);
        $profile->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        session()->flash('message', 'Profile Updated Successfully.');
        // $this->resetInputFields();
        $this->emit('profileUpdated');
    }
}
