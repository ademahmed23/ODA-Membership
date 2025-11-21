@extends('layouts.app')

@section('content')

{{-- @section('title','') --}}
{{-- <x-app-layout> --}}
<div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">


                    {{-- <div class="card card-stat">
                            <div class="card-header card-header-success card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icon">people</i>
                                </div>
                                <p class="card-category">@yield('title')</p>
                                <h3 class="card-title">{{ $count }}</h3>
                </div>
                <div class="card-footer">
                    <div class="stat">
                        <i class="material-icon">date_range</i> Last 1 year
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
<div class="alert alert-succes">
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
            {{-- <h4 class="card-title ">{{ $name }} Member Report</h4> --}}
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6 mb-3">
                    <form action="zoneMemberFee-report" method="POST" enctype="multipart/form-data" style="display: flex; align-items: center;">
                        @csrf
                        <label for="zone" style="margin-right: 10px;">Zone</label>
                        <select name="zone" id="zone" class="form-control dynamic" data-dependent="woreda" style="display: inline-block;width:35%;margin-right:10px;" required>
                            <option value="">Select Zone</option>
                            <option value="zone1">Arsii</option>
                            <option value="zone2">Arsii-Lixaa</option>
                            <option value="zone3">Baalee</option>
                            <option value="zone4">Baalee-Bahaa</option>
                            <option value="zone5">Booranaa</option>
                            <option value="zone6">Bunno- Baddalle</option>
                            <option value="zone7">Finfinnee</option>
                            <option value="zone8">Gujii</option>
                            <option value="zone9">Gujii-Lixaa</option>
                            <option value="zone10">Harargee-Bahaa</option>
                            <option value="zone11">Harargee-Lixaa</option>
                            <option value="zone12">Horroo-Guduruu-Wallaga</option>
                            <option value="zone13">Iluu-Abbaa-Booraa</option>
                            <option value="zone14">Jimmaa</option>
                            <option value="zone15">Qeellam-Wallaga</option>
                            <option value="zone16">Shawaa-Bahaa</option>
                            <option value="zone17">Shawaa-Kaabaa</option>
                            <option value="zone18">Shawaa-Kibbaaa-Lixaa</option>
                            <option value="zone19">Shawaa-Lixaa</option>
                            <option value="zone20">Wallaga-Bahaa</option>
                            <option value="zone21">Wallaga-Lixaa</option>
                        </select>
                        <label for="woreda" style="margin-right: 10px;">Woreda</label>
                        <select name="woreda" id="woreda" class="form-control" style="display: inline-block;width:35%;margin-right:10px;" required>
                            <option value="">Select Woreda</option>
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


                    {{-- <a href="@yield('importRoute')" class="btn btn-sm btn-succes">Import @yield('insert')</a> --}}
                </div>
                {{-- @if($export == true) --}}
                {{-- <form action="zoneMemberFee-Export" method="POST" enctype="multipart/form-data" style="display: flex; align-items: center;">
                    <input type="hidden" name="zone" value="{{ $zone }}">
                <input type="hidden" name="woreda" value="{{ $woreda }}">
                <input type="hidden" name="month" value="{{ $month }}">
                <input type="hidden" name="year" value="{{ $year }}">
                @csrf --}}

                {{-- <div class="col-6 mb-3 align-content-end" style="text-align: right;"> --}}
                    {{-- <button class="btn btn-sm btn-success">Download</button> --}}
                    {{-- <a href="zoneMemberFee-export/{{ $zone }}/{{ $woreda }}/{{ $month }}/{{ $year }}" class="btn btn-sm btn-success">Download</a> --}}
                </div>
                {{-- </form> --}}
                {{-- @endif --}}
            </div>
            <div class="table-responsive">
                {{-- contains content --}}
                <table class="table table-striped table-sortable pb-1 mt-2">

                    <thead>

                        <tr>
                            <th>Number </th>
                            <th>Zone</th>
                            <th>Woreda</th>
                            <th>Position</th>
                            <th>Date</th>
                            <th>Total</th>
                            </th>
                    </thead>
                    <tbody>
                        @foreach($organizations as $report)

                        <tr>
                            <td class="border py-2">{{ $report->id }}</td>
                            <td class="border py-2">{{ $report->zone }}</td>
                            <td class="border py-2">{{ $report->woreda }}</td>
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
@section('scripts')
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('select[name="zone"]').on('change', function() {
            console.log('change');
            var zone = jQuery(this).val();
            console.log(zone);
            if (zone) {
                jQuery.ajax({
                    url: 'fetchWoreda/' + zone
                    , type: "GET"
                    , dataType: "json"
                    , success: function(data) {
                        console.log(data);
                        jQuery('select[name="woreda"]').empty();
                        jQuery.each(data, function(key, value) {
                            $('select[name="woreda"]').append('<option value="' + value + '">' + value + '</option>');
                        });
                    }
                });
            } else {
                $('select[name="woreda"]').empty();
            }
        });
    });

</script>
@endsection
