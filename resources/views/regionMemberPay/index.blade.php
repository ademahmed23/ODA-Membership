@extends('layouts.app')

@section('content')

{{-- @section('title','') --}}
{{-- <x-app-layout> --}}
<div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">

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
                            @if($region != null)
                            <h4 class="card-title ">{{ $region }} Member Report</h4>
                            @else
                            <h4 class="card-title ">Member Report</h4>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-6 mb-3">

                                    <form action="regionMember-pay" method="POST" enctype="multipart/form-data" style="display: flex; align-items: center;">
                                        @csrf
                                        <label for="region" style="margin-right: 10px;">Region</label>
                                        <select name="region" id="region" class="form-control dynamic" data-dependent="woreda" style="display: inline-block;width:35%;margin-right:10px;">

                                            <option value="">Select Region</option>
                                            @foreach ($regions as $region)
                                            <option value="{{ $region->name }}">{{ $region->name }}</option>
                                            @endforeach

                                        </select>
                                        <button class="btn btn-sm btn-success" style="display: inline-block;">Fetch</button>
                                    </form>


                                    {{-- <a href="@yield('importRoute')" class="btn btn-sm btn-success">Import @yield('insert')</a> --}}
                                </div>

                                {{-- <div class="col-6 mb-3 align-content-end" style="text-align: right;">
                    <a href="regionMember-export/{{ $region }}" class="btn btn-sm btn-success">Download</a>
                            </div> --}}



                        </div>
                        <div class="table-responsive">
                            {{-- contains content --}}
                            <table class="table table-striped table-sortable pb-1 mt-2">

                                <thead>

                                    <tr>
                                        <th>Region</th>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Amount</th>
                                        <th>Payment Date</th>
                                </thead>
                                <tbody>
                                    {{-- check if pays exist --}}
                                    @if($pays != null)
                                    @forelse($pays as $pay)
                                    <tr>
                                        <td class="border py-2">{{ $pay->region }}</td>
                                        <td class="border py-2">{{ $pay->name }}</td>
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
