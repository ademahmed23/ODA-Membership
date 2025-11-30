@extends('layouts.app')

@section('content')
    <div>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- Stats Card -->
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="col-lg-12 col-md-12 col-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                            {{-- insert icons dynamically from variable --}}
                                            <i class="bx bxs-business" style="font-size: 3em;color:green;"></i>
                                            {{-- <i class="bx bxs-user-circle"></i> --}}
                                        </div>
                                    </div>
                                    <span>Projects</span>
                                    <h3 class="card-title text-nowrap mb-1">{{ $count }}</h3>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>

                <!-- Flash Messages -->
                @foreach (['success', 'delete', 'update'] as $msg)
                    @if (session()->has($msg))
                        <div
                            class="alert alert-{{ $msg == 'update' ? 'warning' : ($msg == 'delete' ? 'danger' : 'success') }}">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="bx bxs-x"
                                    style="font-size: 2em; color: {{ $msg == 'update' ? 'orange' : ($msg == 'delete' ? 'red' : 'green') }}"></i>
                            </button>
                            <span>{{ session($msg) }}</span>
                        </div>
                    @endif
                @endforeach

                <!-- Project Table -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Project Report</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-6">
                                    <!-- Filter Form -->
                                    <form action="{{ route('project.index') }}" method="GET"
                                        style="display: flex; align-items: center;">
                                        @csrf
                                        <label for="zone" style="margin-right: 10px;">Zone</label>
                                        <select name="zone" id="zone" class="form-control dynamic"
                                            data-dependent="woreda"
                                            style="display: inline-block;width:35%;margin-right:10px;">
                                            <option value="">Select Zone</option>
                                            @foreach ($zones as $zone)
                                                <option value="{{ $zone }}"
                                                    {{ request('zone') == $zone ? 'selected' : '' }}>{{ $zone }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <label for="woreda" style="margin-right: 10px;">Woreda/City</label>
                                        <select name="woreda" id="woreda" class="form-control"
                                            style="display: inline-block;width:35%;margin-right:10px;">
                                            <option value="">Select Woreda</option>
                                            @if (!empty($woredas))
                                                @foreach ($woredas as $woreda)
                                                    <option value="{{ $woreda }}"
                                                        {{ request('woreda') == $woreda ? 'selected' : '' }}>
                                                        {{ $woreda }}</option>
                                                @endforeach
                                            @endif
                                        </select>

                                        <button class="btn btn-sm btn-success" style="display: inline-block;">Fetch</button>
                                    </form>
                                </div>
                                <div class="col-3 mb-3 align-content-center" style="text-align: right;">
                                    <a href="{{ route('project.create') }}" class="btn btn-sm btn-success">Add project</a>
                                </div>
                            </div>

                            <div class="table-responsive  table-strip">
                                <table class="table table-strip table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Zone</th>
                                            <th>Woreda/City</th>
                                            <th>Name</th>
                                            <th>Project Type</th>
                                            <th>Site</th>
                                            <th>Address</th>
                                            <th>Progression</th>
                                            <th>Community Participation</th>
                                            <th>Started Year</th>
                                            <th>Budget</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($reports as $report)
                                            <tr>
                                                <td>{{ $report->id }}</td>
                                                <td>{{ $report->zone }}</td>
                                                <td>{{ $report->woreda_or_city }}</td>
                                                <td>{{ $report->name }}</td>
                                                <td>{{ $report->type }}</td>
                                                <td>{{ $report->site }}</td>
                                                <td>{{ $report->address }}</td>
                                                <td>{{ $report->progression }}</td>
                                                <td>{{ $report->community_participation }}</td>
                                                <td>{{ $report->started_year }}</td>
                                                <td>{{ number_format($report->budget, 2) }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-secondary dropdown-toggle"
                                                            type="button" id="actionDropdown{{ $report->id }}"
                                                            data-bs-toggle="dropdown">
                                                            Actions
                                                        </button>

                                                        <ul class="dropdown-menu"
                                                            aria-labelledby="actionDropdown{{ $report->id }}">

                                                            {{-- Edit --}}
                                                            @can('gujii-edit')
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('project.edit', $report->id) }}">
                                                                        Edit
                                                                    </a>
                                                                </li>
                                                            @endcan

                                                            {{-- Delete --}}
                                                            @can('gujii-delete')
                                                                <li>
                                                                    <form action="{{ route('project.destroy', $report->id) }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Are you sure?');">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button class="dropdown-item text-danger"
                                                                            type="submit">
                                                                            Delete
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                            @endcan

                                                            {{-- Payment --}}

                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="12" class="text-center">No project found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {!! $reports->links() !!}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        jQuery(document).ready(function() {
            jQuery('select[name="zone"]').on('change', function() {
                var zone = jQuery(this).val();
                if (zone) {
                    jQuery.ajax({
                        url: '/project/fetchWoredas/' + zone,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            jQuery('select[name="woreda"]').empty();
                            jQuery.each(data, function(key, value) {
                                $('select[name="woreda"]').append('<option value="' +
                                    value + '">' + value + '</option>');
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
