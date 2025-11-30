@extends('layouts.components.index')
@section('model', 'Buunnoo Beddellee')
@section('count', $count)
@section('title', 'Buunnoo Beddellee')
@section('insert', 'Buunnoo Beddellee')
@section('icons', 'layout')
@section('route', route('zone6.create'))
@section('import', route('zone6.import'))
@section('filterAction', route('zone6.index'))
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
                    {{-- <th>#</th> --}}
                    <th>id</th>
                    <th>Member ID</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Woreda</th>

                    <th>Gender</th>
                    <th>Age</th>
                    <th>Education</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Position</th>
                    <th>Membership Type</th>
                    <th>Membership Fee</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $key => $report)
                    <tr>
                        {{-- <td>{{ ++$i }}</td> --}}
                        <td>{{ $report->id }}</td>
                        <td>{{ $report->member_id }}</td>
                        <td>{{ $report->first_name }}</td>
                        <td>{{ $report->middle_name }}</td>
                        <td>{{ $report->last_name }}</td>
                        <td>{{ $report->woreda }}</td>
                        <td>{{ $report->gender }}</td>
                        <td>{{ $report->age }}</td>
                        <td>{{ $report->education_level }}</td>
                        <td>{{ $report->address }}</td>
                        <td>{{ $report->contact_number }}</td>
                        <td>{{ $report->email }}</td>
                        <td>{{ $report->position }}</td>
                        <td>{{ $report->membership_type }}</td>
                        <td>{{ $report->membership_fee }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                    id="actionDropdown{{ $report->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="actionDropdown{{ $report->id }}">
                                    {{-- Edit --}}
                                    @can('zone6-edit')
                                        <li>
                                            <a class="dropdown-item" href="{{ route('zone6.edit', $report->id) }}">Edit</a>
                                        </li>
                                    @endcan

                                    {{-- Delete --}}
                                    @can('zone6-delete')
                                        <li>
                                            <form action="{{ route('zone6.destroy', $report->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="dropdown-item text-danger" type="submit">Delete</button>
                                            </form>
                                        </li>
                                    @endcan

                                    {{-- Pay / Paid --}}
                                    <li>
                                        @if ($report->has_paid)
                                            <span class="dropdown-item text-success">Paid</span>
                                        @else
                                            <a class="dropdown-item text-warning"
                                                href="{{ route('zone6.pay', $report->id) }}">Pay</a>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    {{-- @endsection --}}
    @endsection

