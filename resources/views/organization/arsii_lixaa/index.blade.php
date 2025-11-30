@extends('layouts.components.index')

@section('model','Arsii Lixaa')
@section('count',$count)
@section('title','Arsii Lixaa')
@section('insert','Arsii Lixaa')
@section('icons','layout')
@section('route',route('arsii_lixaa.create'))
@section('import',route('arsii_lixaa.import'))
@section('filterAction', route('arsii_lixaa.index'))
@section('filterName', 'woreda')
@section('filterLabel', 'Woreda')
@section('filterButton', 'Show Data')
@section('exportEnabled', true)
@section('exportRoute', url('zoneMember-export/' . $zone . '/' . $woreda))
@section('exportText', 'Download')

@section('table')

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Member ID</th>
            <th>Organization Name</th>
            <th>Organization Type</th>
            <th>Woreda</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Payment Period</th>
            <th>Member Started</th>
            <th>Payment Amount</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reports as $key => $report)
        <tr>
            <td>{{ $report->id }}</td>
            <td>{{ $report->member_id }}</td>
            <td>{{ $report->organization_name }}</td>
            <td>{{ $report->organization_type }}</td>
            <td>{{ $report->woreda }}</td>
            <td>{{ $report->phone_number }}</td>
            <td>{{ $report->email }}</td>
            <td>{{ $report->payment_period }}</td>
            <td>{{ $report->member_started }}</td>
            <td>{{ $report->payment }}</td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="actionDropdown{{ $report->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                        Actions
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="actionDropdown{{ $report->id }}">
                        {{-- Edit --}}
                        @can('arsii_lixaa-edit')
                        <li>
                            <a class="dropdown-item" href="{{ route('arsii_lixaa.edit', $report->id) }}">Edit</a>
                        </li>
                        @endcan

                        {{-- Delete --}}
                        @can('arsii_lixaa-delete')
                        <li>
                            <form action="{{ route('arsii_lixaa.destroy', $report->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button class="dropdown-item text-danger" type="submit">Delete</button>
                            </form>
                        </li>
                        @endcan

                        {{-- Pay / Paid --}}
                        <li>
                            @if($report->has_paid)
                                <span class="dropdown-item text-success">Paid</span>
                            @else
                                <a class="dropdown-item text-warning" href="{{ route('arsii_lixaa.pay', $report->id) }}">Pay</a>
                            @endif
                        </li>
                    </ul>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


<p class="text-muted">Select a woreda to see members.</p>

@endsection
