@extends('layouts.components.index')

@section('model', 'Organization')
{{-- @section('count', $count) --}}
@section('title', 'Organization Members')
@section('insert', 'Organization')
@section('icons', 'building') {{-- choose a relevant icon --}}
{{-- @section('route', route('organization.create'))  --}}
{{-- @section('import', route('organization.import')) import route for org --}}
{{-- @section('filterAction', route('zone1.indexorg')) --}}
@section('filterName', 'org_type') {{-- for example --}}
@section('filterLabel', 'Organization Type')
@section('filterButton', 'Show Data')
@section('exportEnabled', true)
{{-- @section('exportRoute', url('organization-export/' . $orgType)) --}}
@section('exportText', 'Download')

@section('table')

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Org Name</th>
            <th>Org Type</th>
            <th>Founded In</th>
            <th>Fee amount</th>

            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($organizatons as $org)
        <tr>
            <td>{{ $org->org_name }}</td>
            <td>{{ $org->org_type }}</td>
            <td>{{ $org->woreda }}</td>
            <td>{{ $org->membership_fee }}</td>

            <td>
                <div class="dropdown">
                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                        id="actionDropdown{{ $org->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                        Actions
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="actionDropdown{{ $org->id }}">
                        {{-- Edit --}}
                        @can('organization-edit')
                        <li>
                            <a class="dropdown-item" href="{{ route('organization.edit', $org->id) }}">Edit</a>
                        </li>
                        @endcan

                        {{-- Delete --}}
                        @can('organization-delete')
                        <li>
                            <form action="{{ route('organization.destroy', $org->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button class="dropdown-item text-danger" type="submit">Delete</button>
                            </form>
                        </li>
                        @endcan
                    </ul>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- {!! $organizatons->links() !!} --}}

@endsection
