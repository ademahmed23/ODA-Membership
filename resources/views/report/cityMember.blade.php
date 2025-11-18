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
                            <h4 class="card-title ">{{ $name }} Member Report</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-6 mb-3">

                                    <form action="cityMember-report" method="POST" enctype="multipart/form-data" style="display: flex; align-items: center;">
                                        @csrf
                                        <label for="city" style="margin-right: 10px;">City</label>
                                        <select name="city" id="city" class="form-control" style="display: inline-block;width:35%;margin-right:10px;">
                                            <option value="">Select City</option>

                                            <option value="city1s">B-M-Adaamaa</option>
                                            <option value="city2s">B-M-Amboo</option>
                                            <option value="city3s">B-M-Asallaa</option>
                                            <option value="city4s">B-M-Baatuu</option>
                                            <option value="city5s">B-M-Bishooftuu</option>
                                            <option value="city6s">B-M-Buraayyuu</option>
                                            <option value="city7s">B-M-Dukam</option>
                                            <option value="city8s">B-M-Finfinnee</option>
                                            <option value="city9s">B-M-Galaan</option>
                                            <option value="city10s">B-M-Hoolotaa</option>
                                            <option value="city11s">B-M-Jimmaa</option>
                                            <option value="city12s">B-M-L_Xaafoo</option>
                                            <option value="city13s">B-M-Mojoo</option>
                                            <option value="city14s">B-M-Naqamtee</option>
                                            <option value="city15s">B-M-Roobee</option>
                                            <option value="city16s">B-M-Shaashaamannee</option>
                                            <option value="city17s">B-M-Sabbaataa</option>
                                            <option value="city18s">B-M-Sulultaa</option>
                                            <option value="city19s">B-M-Walisoo</option>
                                        </select>
                                        <button class="btn btn-sm btn-success" style="display: inline-block;">Fetch</button>
                                    </form>


                                    {{-- <a href="@yield('importRoute')" class="btn btn-sm btn-success">Import @yield('insert')</a> --}}
                                </div>

                                <div class="col-6 mb-3 align-content-end" style="text-align: right;">
                                    <a href="cityMember-export/{{ $city }}" class="btn btn-sm btn-success">Download</a>
                                </div>



                            </div>
                            <div class="table-responsive">
                                {{-- contains content --}}
                                <table class="table table-striped table-sortable pb-1 mt-2">

                                    <thead>

                                        <tr>
                                            <th>Number </th>
                                            <th>City</th>
                                            <th>Position</th>
                                            <th>Total</th>
                                            </th>
                                    </thead>
                                    <tbody>
                                        @foreach($reports as $report)

                                        <tr>
                                            <td class="border py-2">{{ $report->id }}</td>
                                            <td class="border py-2">{{ $report->city }}</td>
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
