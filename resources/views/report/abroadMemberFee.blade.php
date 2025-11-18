@extends('layouts.app')

@section('content')

<div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">

                </div>
                @if (session()->has('success'))
                <div class="alert alert-succe">
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
                                    <form action="abroadMemberFee-report" method="POST" enctype="multipart/form-data" style="display: flex; align-items: center;">
                                        @csrf
                                        <label for="country" style="margin-right: 10px;">Country</label>
                                        <select name="country" id="country" class="form-control dynamic" data-dependent="woreda" style="display: inline-block;width:35%;margin-right:10px;" required>
                                            <option value="">Select Country</option>
                                            @foreach ($countries as $country)
                                            <option value="{{ $country->name }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>

                                        <label for="month" style="margin-right: 10px;">Month</label>
                                        <select name="month" id="month" class="form-control" style="display: inline-block;width:35%;margin-right:10px;" required>
                                            <option value="">Select Month</option>
                                            <option value="01">January</option>
                                            <option value="02">February</option>
                                            <option value="03">March</option>
                                            <option value="04">April</option>
                                            <option value="05">May</option>
                                            <option value="06">June</option>
                                            <option value="07">July</option>
                                            <option value="08">August</option>
                                            <option value="09">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>
                                        <label for="year" style="margin-right: 10px;">Year</label>
                                        <select name="year" id="year" class="form-control" style="display: inline-block;width:35%;margin-right:10px;" required>
                                            <option value="">Select Year</option>
                                            {{-- dynamically generate the year starting from today to ten years to the past --}}
                                            @for ($i = 0; $i < 10; $i++) <option value="{{ date('Y') - $i }}">{{ date('Y') - $i }}</option>
                                                @endfor
                                        </select>

                                        <button class="btn btn-sm btn-success" style="display: inline-block;">Fetch</button>
                                    </form>


                                    {{-- <a href="@yield('importRoute')" class="btn btn-sm btn-succe">Import @yield('insert')</a> --}}
                                </div>
                                @if($export == true)
                                {{-- <form action="countryMemberFee-Export" method="POST" enctype="multipart/form-data" style="display: flex; align-items: center;">
                    <input type="hidden" name="country" value="{{ $country }}">
                                <input type="hidden" name="woreda" value="{{ $woreda }}">
                                <input type="hidden" name="month" value="{{ $month }}">
                                <input type="hidden" name="year" value="{{ $year }}">
                                @csrf --}}

                                <div class="col-6 mb-3 align-content-end" style="text-align: right;">
                                    {{-- <button class="btn btn-sm btn-succes">Download</button> --}}
                                    <a href="abroadMemberFee-export/{{ $country }}/{{ $month }}/{{ $year }}" class="btn btn-sm btn-succe">Download</a>
                                </div>
                                {{-- </form> --}}
                                @endif
                            </div>
                            <div class="table-responsive">
                                {{-- contains content --}}
                                <table class="table table-striped table-sortable pb-1 mt-2">

                                    <thead>

                                        <tr>
                                            <th>Number </th>
                                            <th>Country</th>
                                            <th>Position</th>
                                            <th>Date</th>
                                            <th>Total</th>
                                            </th>
                                    </thead>
                                    <tbody>
                                        @foreach($reports as $report)

                                        <tr>
                                            <td class="border py-2">{{ $report->id }}</td>
                                            <td class="border py-2">{{ $report->country }}</td>
                                            <td class="border py-2">{{ $report->position }}</td>
                                            @if($report->date)
                                            <td class="border py-2">{{ $report->date }}</td>
                                            @else
                                            <td class="border py-2">-</td>
                                            @endif
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
