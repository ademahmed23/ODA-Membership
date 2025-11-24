@extends('layouts.app', ['activePage' => 'user', 'titlePage' => __('User')])
@section('content')

@section('title','Users')
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
                                        <i class="bx bxs-group" style="font-size: 2.5em;color:blue;"></i>
                                        {{-- <i class="bx bxs-user-circle"></i> --}}
                                    </div>
                                </div>
                                <span>Users</span>
                                <h3 class="card-title text-nowrap mb-1">{{ $data->total() }}</h3>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Users</h4>
                            <p class="card-category"> Here you can manage users</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-right" style="text-align: right;">
                                    <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Add User</a>




                                </div>


                            </div>
                            @include('users.create')
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
                                            <th>
                                                Email
                                            </th>
                                            <th>
                                                Roles
                                            </th>
                                            <th class="text-right" width="25%">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $user)

                                        <tr>
                                            <td>{{ ++$i }}</td>

                                            <td>{{ $user->name }}</td>

                                            <td>{{ $user->email }}</td>
                                            <td>

                                                @if(!empty($user->getRoleNames()))

                                                @foreach($user->getRoleNames() as $v)

                                                <label>
                                                    {{ $v }}</label>

                                                @endforeach

                                                @endif

                                            </td>


                                            <td class="td-actions text-right">
                                                <div class="flex items-center space-x-4 text-sm">

                                                    @can('user-edit')

                                                    <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>

                                                    @endcan

                                                    @can('user-delete')

                                                    {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}

                                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}

                                                    {!! Form::close() !!}

                                                    @endcan

                                                </div>

                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                {!! $data->render() !!}








                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
