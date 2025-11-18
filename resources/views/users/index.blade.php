@extends('layouts.app', ['activePage' => 'user', 'titlePage' => __('User')])

@section('content')

@section('title','Users')
<div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-success card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">people</i>
                            </div>
                            <p class="card-category">Users</p>
                            <h3 class="card-title">{{ $data->total() }}</h3>
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
