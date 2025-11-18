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

                    <form action="zoneMember-pay" method="POST" enctype="multipart/form-data" style="display: flex; align-items: center;">
                        @csrf
                        <label for="zone" style="margin-right: 10px;">Zone</label>
                        <select name="model" id="model" class="form-control dynamic" data-dependent="woreda" style="display: inline-block;width:35%;margin-right:10px;">

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
                        <select name="woreda" id="woreda" class="form-control" style="display: inline-block;width:35%;margin-right:10px;">
                            <option value="">Select Woreda</option>
                        </select>
                        <button class="btn btn-sm btn-success" style="display: inline-block;">Fetch</button>
                    </form>


                    {{-- <a href="@yield('importRoute')" class="btn btn-sm btn-success">Import @yield('insert')</a> --}}
                </div>

                {{-- <div class="col-6 mb-3 align-content-end" style="text-align: right;">
                    <a href="zoneMember-export/{{ $zone }}" class="btn btn-sm btn-success">Download</a>
            </div> --}}



        </div>
        <div class="table-responsive">
            {{-- contains content --}}
            <table class="table table-striped table-sortable pb-1 mt-2">

                <thead>

                    <tr>
                        <th>Name </th>
                        <th>Zone</th>
                        <th>Woreda</th>
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
                        <td class="border py-2">{{ $pay->woreda }}</td>
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
@section('scripts')
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('select[name="model"]').on('change', function() {
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
