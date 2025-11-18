 <x-guest-layout>
     {{-- <x-jet-authentication-card>
         <x-slot name="logo">
             <x-jet-authentication-card-logo />
         </x-slot>

         <x-jet-validation-errors class="mb-4" /> --}}
     <div class="container" style="height: auto; margin-top:4%;">
         <div class="row align-items-center">
             <div class="col-md-9 ml-auto mr-auto mb-3 text-center">
                 {{-- <h3>{{ __('Log in to see how you can speed up your web development with out of the box CRUD for #User Management and more.') }} </h3> --}}
             </div>
             <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">

                 @if (session('status'))
                 <div class="mb-4 font-medium text-sm text-green-600">
                     {{ session('status') }}
                 </div>
                 @endif

                 <form class="form" method="POST" action="{{ route('login') }}">
                     @csrf

                     <div class="card card-login card-hidden mb-3">
                         <div class="card-header card-header-primary text-center">
                             <h4 class="card-title"><strong>{{ __('Login') }}</strong></h4>
                             <div class="social-line">
                                 <a href="#pablo" class="btn btn-just-icon btn-link btn-white">
                                     <i class="fa fa-facebook-square"></i>
                                 </a>
                                 <a href="#pablo" class="btn btn-just-icon btn-link btn-white">
                                     <i class="fa fa-twitter"></i>
                                 </a>
                                 <a href="#pablo" class="btn btn-just-icon btn-link btn-white">
                                     <i class="fa fa-google-plus"></i>
                                 </a>
                             </div>
                         </div>
                         <div class="card-body">
                             {{-- <p class="card-description text-center"></p> --}}
                             <br />
                             <div class="bmd-form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                 <div class="input-group">
                                     <div class="input-group-prepend">
                                         <span class="input-group-text">
                                             <i class="material-icons">email</i>
                                         </span>
                                     </div>
                                     <input type="email" name="email" class="form-control" placeholder="{{ __('Email...') }}" required>
                                 </div>
                                 @if ($errors->has('email'))
                                 <div id="email-error" class="error text-danger pl-3" for="email" style="display: block;">
                                     <strong>{{ $errors->first('email') }}</strong>
                                 </div>
                                 @endif
                             </div>
                             <div class="bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }} mt-3">
                                 <div class="input-group">
                                     <div class="input-group-prepend">
                                         <span class="input-group-text">
                                             <i class="material-icons">lock_outline</i>
                                         </span>
                                     </div>
                                     <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Password...') }}" required>
                                 </div>
                                 @if ($errors->has('password'))
                                 <div id="password-error" class="error text-danger pl-3" for="password" style="display: block;">
                                     <strong>{{ $errors->first('password') }}</strong>
                                 </div>
                                 @endif
                             </div>
                             <div class="form-check mr-auto ml-3 mt-3">
                                 <label class="form-check-label">
                                     <input class="form-check-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember me') }}
                                     <span class="form-check-sign">
                                         <span class="check"></span>
                                     </span>
                                 </label>
                             </div>
                         </div>
                         <div class="card-footer justify-content-center">
                             <button type="submit" class="btn btn-primary btn-link btn-lg">{{ __('Lets Go') }}</button>
                         </div>
                     </div>
                 </form>
             </div>
         </div>
     </div>


     {{--<form method="POST" action="{{ route('login') }}">

     @csrf

     <div>
         <x-jet-label for="email" value="{{ __('Email') }}" />
         <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
     </div>

     <div class="mt-4">
         <x-jet-label for="password" value="{{ __('Password') }}" />
         <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
     </div>

     <div class="block mt-4">
         <label for="remember_me" class="flex items-center">
             <x-jet-checkbox id="remember_me" name="remember" />
             <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
         </label>
     </div>

     <div class="flex items-center justify-end mt-4">
         @if (Route::has('password.request'))
         <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
             {{ __('Forgot your password?') }}
         </a>
         @endif

         <x-jet-button class="ml-4">
             {{ __('Log in') }}
         </x-jet-button>
     </div>
     </form>--}}
     {{-- </x-jet-authentication-card> --}}
 </x-guest-layout>


 {{-- <div class="container" style="height: auto;">
     <div class="row align-items-center">
         <div class="col-md-9 ml-auto mr-auto mb-3 text-center">
             <h3>{{ __('Log in to see how you can speed up your web development with out of the box CRUD for #User Management and more.') }} </h3>
 </div>
 <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
     <form class="form" method="POST" action="{{ route('login') }}">
         @csrf

         <div class="card card-login card-hidden mb-3">
             <div class="card-header card-header-primary text-center">
                 <h4 class="card-title"><strong>{{ __('Login') }}</strong></h4>
                 <div class="social-line">
                     <a href="#pablo" class="btn btn-just-icon btn-link btn-white">
                         <i class="fa fa-facebook-square"></i>
                     </a>
                     <a href="#pablo" class="btn btn-just-icon btn-link btn-white">
                         <i class="fa fa-twitter"></i>
                     </a>
                     <a href="#pablo" class="btn btn-just-icon btn-link btn-white">
                         <i class="fa fa-google-plus"></i>
                     </a>
                 </div>
             </div>
             <div class="card-body">
                 <p class="card-description text-center">{{ __('Or Sign in with ') }} <strong>admin@material.com</strong> {{ __(' and the password ') }}<strong>secret</strong> </p>
                 <div class="bmd-form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                     <div class="input-group">
                         <div class="input-group-prepend">
                             <span class="input-group-text">
                                 <i class="material-icons">email</i>
                             </span>
                         </div>
                         <input type="email" name="email" class="form-control" placeholder="{{ __('Email...') }}" value="{{ old('email', 'admin@material.com') }}" required>
                     </div>
                     @if ($errors->has('email'))
                     <div id="email-error" class="error text-danger pl-3" for="email" style="display: block;">
                         <strong>{{ $errors->first('email') }}</strong>
                     </div>
                     @endif
                 </div>
                 <div class="bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }} mt-3">
                     <div class="input-group">
                         <div class="input-group-prepend">
                             <span class="input-group-text">
                                 <i class="material-icons">lock_outline</i>
                             </span>
                         </div>
                         <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Password...') }}" value="{{ !$errors->has('password') ? "secret" : "" }}" required>
                     </div>
                     @if ($errors->has('password'))
                     <div id="password-error" class="error text-danger pl-3" for="password" style="display: block;">
                         <strong>{{ $errors->first('password') }}</strong>
                     </div>
                     @endif
                 </div>
                 <div class="form-check mr-auto ml-3 mt-3">
                     <label class="form-check-label">
                         <input class="form-check-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember me') }}
                         <span class="form-check-sign">
                             <span class="check"></span>
                         </span>
                     </label>
                 </div>
             </div>
             <div class="card-footer justify-content-center">
                 <button type="submit" class="btn btn-primary btn-link btn-lg">{{ __('Lets Go') }}</button>
             </div>
         </div>
     </form>
     {{-- <div class="row">

                     <div class="col-6">
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-light">
     <small>{{ __('Forgot password?') }}</small>
     </a>
     @endif
 </div>
 <div class="col-6 text-right">
     <a href="{{ route('register') }}" class="text-light">
         <small>{{ __('Create new account') }}</small>
     </a>
 </div>
 </div>--}

 </div>
 </div>
 </div> --}}
