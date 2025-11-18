{{-- @section('title','Profile') --}}
@extends('layouts.app')
@section('content')
<div>

    <div class="content">

        <div class="row">
            <div class="col-md-12">


                @if (session()->has('message'))
                <div class="alert alert-warning">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="material-icons">close</i>
                    </button>
                    <span>
                        {{ session('message') }}</span>

                </div>
                @endif


                <form class="form-horizontal">



                    {{-- <input type="hidden" name="_token" value="u1oqXZXNh33LCFsuR87oiWM0bAY7c1wtNWWIa1Jg"> <input type="hidden" name="_method" value="put"> --}}
                    {{-- <div class="card ">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Edit Profile</h4>
                            <p class="card-category">User information</p>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                {{-- <input type="hidden" name="id" wire:model="profile_id" /> --}

                                <label class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-7">
                                    <div class="form-group">
                                        <input class="form-control" name="name" id="input-name" type="text" placeholder="Name" value="{{ $profile->name }}" required="true" aria-required="true" />

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-7">
                                    <div class="form-group">
                                        <input class="form-control" name="email" id="input-email" type="email" placeholder="Email" value="{{ $profile->email }}" required="true" aria-required="true" />

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ml-auto mr-auto">
                            <button type="button" wire:click.prevent="updateProfile()" class="btn btn-primary">Save</button>

                        </div>
                    </div> --}}
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    {{-- <input type="hidden" name="_token" value="u1oqXZXNh33LCFsuR87oiWM0bAY7c1wtNWWIa1Jg"> <input type="hidden" name="_method" value="put"> --}}
                    <div class="card ">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Change password</h4>
                            <p class="card-category">Password</p>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <label class="col-sm-2 col-form-label" for="input-current-password">Current Password</label>
                                <div class="col-sm-7">
                                    <div class="form-group">
                                        <input class="form-control" input type="password" name="old_password" id="input-current-password" placeholder="Current Password" value="" required />
                                        @error('old_password')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label" for="input-password">New Password</label>
                                <div class="col-sm-7">
                                    <div class="form-group">
                                        <input class="form-control" name="password" id="input-password" type="password" placeholder="New Password" value="" required />
                                        @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label" for="input-password-confirmation">Confirm New Password</label>
                                <div class="col-sm-7">
                                    <div class="form-group">
                                        <input class="form-control" name="password_confirmation" id="input-password-confirmation" type="password" placeholder="Confirm New Password" value="" required />
                                        @error('password_confirmation')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ml-auto mr-auto">
                            <button type="submit" class="btn btn-primary">Change password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
