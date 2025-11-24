@extends('layouts.app', ['activePage' => 'roles', 'titlePage' => __('Role')])

@section('content')

    {{-- <x-app-layout> --}}
@section('title', 'Roles')
<div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="col-lg-12 col-md-12 col-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        {{-- insert icons dynamically from variable --}}
                                        <i class="bx bxs-group" style="font-size: 2.5em;color:green;"></i>
                                        {{-- <i class="bx bxs-user-circle"></i> --}}
                                    </div>
                                </div>
                                <span>Roles</span>
                                <h3 class="card-title text-nowrap mb-1">{{ $roles->total() }}</h3>
                            </div>

                        </div>

                    </div>

                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Roles</h4>
                            <p class="card-category"> Here you can manage Roles</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-right" style="text-align: right;">
                                    @can('role-create')
                                        <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal">Add Roles</a>
                                    @endcan



                                </div>


                            </div>
                            @include('roles.create')
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class=" text-primary">
                                        <tr>
                                            <th>
                                                Number
                                            </th>
                                            <th>
                                                Name
                                            </th>
                                            <th class="text-right" width="25%">>
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles as $key => $role)
                                            <tr>
                                                <td>{{ ++$i }}</td>

                                                <td>{{ $role->name }}</td>



                                                <td class="td-actions text-right" style="width:75px;overflow: hidden;">

                                                    <div class="flex items-center space-x-4 text-sm">
                                                        @can('role-edit')
                                                            <a class="btn btn-primary"
                                                                href="{{ route('roles.edit', $role->id) }}">Edit</a>
                                                        @endcan

                                                        @can('role-delete')
                                                            {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id], 'style' => 'display:inline']) !!}

                                                            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}

                                                            {!! Form::close() !!}
                                                        @endcan

                                                    </div>

                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                {!! $roles->render() !!}










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
