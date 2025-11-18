@extends('layouts.app')

@section('content')
<div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
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
                            <h4 class="card-title ">{{ $country }} Member Report</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-6 mb-3">

                                    <form action="countryMember-report" method="POST" enctype="multipart/form-data" style="display: flex; align-items: center;">
                                        @csrf
                                        <label for="country" style="margin-right: 10px;">Country</label>
                                        <select name="country" id="country" class="form-control" style="display: inline-block;width:35%;margin-right:10px;">
                                            <option value="">Select Country</option>
                                            @foreach($countries as $country)
                                            <option value="{{ $country->name }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        <button class="btn btn-sm btn-success" style="display: inline-block;">Fetch</button>
                                    </form>


                                    {{-- <a href="@yield('importRoute')" class="btn btn-sm btn-success">Import @yield('insert')</a> --}}
                                </div>

                                <div class="col-6 mb-3 align-content-end" style="text-align: right;">
                                    <a href="countryMember-export/{{ $country }}" class="btn btn-sm btn-success">Download</a>
                                </div>



                            </div>
                            <div class="table-responsive">
                                {{-- contains content --}}
                                <table class="table table-striped table-sortable pb-1 mt-2">

                                    <thead>

                                        <tr>
                                            <th>Number </th>
                                            <th>Country</th>
                                            <th>Position</th>
                                            <th>Total</th>
                                            </th>
                                    </thead>
                                    <tbody>
                                        @foreach($reports as $report)

                                        <tr>
                                            <td class="border py-2">{{ $report->id }}</td>
                                            <td class="border py-2">{{ $report->country }}</td>
                                            <td class="border py-2">{{ $report->position }}</td>
                                            <td class="border py-2">{{ $report->total }}</td>

                                        </tr>
                                        @endforeach
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
