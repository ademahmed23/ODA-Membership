@extends('layouts.app')

@section('content')
{{-- <x-app-layout> --}}

    {{-- <div> --}}
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="row">

                        <div class="col-lg-12 margin-tb">

                            <div class="pull-left">

                                <h2>@yield('type') @yield('title')</h2>

                            </div>

                            <div class="pull-right">

                                <a class="btn btn-primary" href="@yield('back')"> Back</a>

                            </div>

                        </div>

                    </div>


                    @if (count($errors) > 0)

                    <div class="alert alert-danger">

                        <strong>Whoops!</strong> There were some problems with your input.<br><br>

                        <ul>

                            @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                    @endif

                    <div class="card col-sm-8">

                        <div class="card-body ">
                            <div class="row">
                                <div class="col-sm-12">
                                    @yield('form')
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    {{-- </div> --}}
{{-- </x-app-layout> --}}
@endsection
