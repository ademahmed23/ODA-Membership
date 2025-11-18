@extends('layouts.app')

@section('content')

{{-- @section('title','') --}}
{{-- <x-app-layout> --}}
<div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">


                    {{-- <div class="card card-stats">
                            <div class="card-header card-header-success card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">people</i>
                                </div>
                                <p class="card-category">@yield('title')</p>
                                <h3 class="card-title">{{ $count }}</h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">date_range</i> Last 1 year
                    </div>
                </div>

            </div> --}}
            {{-- <div class="col-lg-12 col-md-12 col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                {{-- insert icons dynamically from variable --}
                                <i class="bx bxs-@yield('icons')" style="font-size: 2.5em;color:green;"></i>
                                {{-- <i class="bx bxs-user-circle"></i> --}
                            </div>
                        </div>
                        <span>@yield('title')</span>
                        <h3 class="card-title text-nowrap mb-1">{{ $count }}</h3>
        </div>
    </div>
</div> --}}
</div>
@if (session()->has('success'))
<div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <i class="bx bxs-x" style="font-size: 2em;color:green;"></i>
    </button>
    <span>
        <b> </b> {{ session('success') }} </span>

</div>
@endif

@if (session()->has('delete'))
<div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <i class="bx bxs-x" style="font-size: 2em;color:red;"></i>
    </button>
    <span>
        {{ session('delete') }}</span>

</div>
@endif
@if (session()->has('update'))
<div class="alert alert-warning">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <i class="bx bxs-x" style="font-size: 2em;color:orange;"></i>
    </button>
    <span>
        {{ session('update') }}</span>

</div>
@endif

<div class="col-md-12">
    <div class="card">
        <div class="card-header card-header-primary">
            @if($model != null)
            <h4 class="card-title ">{{ $model }} Member Report</h4>
            @else
            <h4 class="card-title ">Member Report</h4>
            @endif
        </div>
        <div class="card-body">
            <div class="row">

                <div class="col-6 mb-3">

                    <form action="cityMember-pay" method="POST" enctype="multipart/form-data" style="display: flex; align-items: center;">
                        @csrf
                        <label for="city" style="margin-right: 10px;">City</label>
                        <select name="model" id="model" class="form-control dynamic" data-dependent="woreda" style="display: inline-block;width:35%;margin-right:10px;">

                            <option value="">Select City</option>

                            <option value="city1">B-M-Adaamaa</option>
                            <option value="city2">B-M-Amboo</option>
                            <option value="city3">B-M-Asallaa</option>
                            <option value="city4">B-M-Baatuu</option>
                            <option value="city5">B-M-Bishooftuu</option>
                            <option value="city6">B-M-Buraayyuu</option>
                            <option value="city7">B-M-Dukam</option>
                            <option value="city8">B-M-Finfinnee</option>
                            <option value="city9">B-M-Galaan</option>
                            <option value="city10">B-M-Hoolotaa</option>
                            <option value="city11">B-M-Jimmaa</option>
                            <option value="city12">B-M-L_Xaafoo</option>
                            <option value="city13">B-M-Mojoo</option>
                            <option value="city14">B-M-Naqamtee</option>
                            <option value="city15">B-M-Roobee</option>
                            <option value="city16">B-M-Shaashaamannee</option>
                            <option value="city17">B-M-Sabbaataa</option>
                            <option value="city18">B-M-Sulultaa</option>
                            <option value="city19">B-M-Walisoo</option>
                        </select>
                        <button class="btn btn-sm btn-success" style="display: inline-block;">Fetch</button>
                    </form>


                    {{-- <a href="@yield('importRoute')" class="btn btn-sm btn-success">Import @yield('insert')</a> --}}
                </div>

                {{-- <div class="col-6 mb-3 align-content-end" style="text-align: right;">
                    <a href="cityMember-export/{{ $city }}" class="btn btn-sm btn-success">Download</a>
            </div> --}}



        </div>
        <div class="table-responsive">
            {{-- contains content --}}
            <table class="table table-striped table-sortable pb-1 mt-2">

                <thead>

                    <tr>
                        <th>Name </th>
                        <th>City</th>
                        <th>Position</th>
                        <th>Amount</th>
                        <th>Payment Date</th>
                </thead>
                <tbody>
                    {{-- check if pays exist --}}
                    @if($pays != null)
                    @forelse($pays as $pay)
                    <tr>
                        <td class="border py-2">{{ $pay->name }}</td>
                        <td class="border py-2">{{ $pay->model }}</td>
                        <td class="border py-2">{{ $pay->position }}</td>
                        <td class="border py-2">{{ $pay->amount }}</td>
                        <td class="border py-2">{{ $pay->date }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No Data Found</td>
                    </tr>
                    @endforelse
                    @else
                    <tr>
                        <td colspan="6" class="text-center">No Data Found</td>
                    </tr>
                    @endif
                </tbody>
            </table>

        </div>
    </div>
</div>

</div>
</div>
</div>
</div>
</div>
{{-- </x-app-layout> --}}
@endsection
