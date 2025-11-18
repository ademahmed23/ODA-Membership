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
                            <h4 class="card-title ">{{ $region }} Member Report</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-6 mb-3">

                                    <form action="regionMember-report" method="POST" enctype="multipart/form-data" style="display: flex; align-items: center;">
                                        @csrf
                                        <label for="region" style="margin-right: 10px;">Region</label>
                                        <select name="region" id="region" class="form-control" style="display: inline-block;width:35%;margin-right:10px;">
                                            <option value="">Select Region</option>
                                            <option value="Afar">Afar</option>
                                            <option value="Amhara">Amhara</option>
                                            <option value="Benishangul-Gumuz">Benishangul-Gumuz</option>
                                            <option value="Dire Dawa">Dire Dawa</option>
                                            <option value="Gambela">Gambela</option>
                                            <option value="Harari">Harari</option>
                                            <option value="Oromia">Oromia</option>
                                            <option value="Somali">Somali</option>
                                            <option value="Sidama">Sidama</option>
                                            <option value="Tigray">Tigray</option>
                                            <option value="Addis Ababa">Addis Ababa</option>


                                        </select>
                                        <button class="btn btn-sm btn-success" style="display: inline-block;">Fetch</button>
                                    </form>


                                    {{-- <a href="@yield('importRoute')" class="btn btn-sm btn-success">Import @yield('insert')</a> --}}
                                </div>

                                <div class="col-6 mb-3 align-content-end" style="text-align: right;">
                                    <a href="regionMember-export/{{ $region }}" class="btn btn-sm btn-success">Download</a>
                                </div>



                            </div>
                            <div class="table-responsive">
                                {{-- contains content --}}
                                <table class="table table-striped table-sortable pb-1 mt-2">
                                    <thead>

                                        <tr>
                                            <th>Number </th>
                                            <th>Region</th>
                                            <th>Position</th>
                                            <th>Total</th>
                                            </th>
                                    </thead>
                                    <tbody>
                                        @foreach($reports as $report)

                                        <tr>
                                            <td class="border py-2">{{ $report->id }}</td>
                                            <td class="border py-2">{{ $report->region }}</td>
                                            <td class="border py-2">{{ $report->position }}</td>
                                            <td class="border py-2">{{ $report->total }}</td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {!! $reports->link() !!}


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
