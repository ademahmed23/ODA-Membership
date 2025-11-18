@extends('layouts.app', ['activePage' => 'roles', 'titlePage' => __('Role')])

@section('content')

{{-- <x-app-layout> --}}
@section('title','Roles')
<div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-success card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">work</i>
                            </div>
                            <p class="card-category">Roles</p>
                            <h3 class="card-title">{{ $roles->total() }}</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">date_range</i> Last 1 year
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
                                    <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Roles</a>
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

                                                    <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>

                                                    @endcan

                                                    @can('role-delete')

                                                    {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}

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
