@section('title','Student')
<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            @if (session()->has('message'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
                <span>
                    <b> </b> {{ session('message') }} </span>

            </div>
            @endif

            @if (session()->has('delete'))
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
                <span>
                    {{ session('delete') }}</span>

            </div>
            @endif
            @if (session()->has('update'))
            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
                <span>
                    {{ session('update') }}</span>

            </div>
            @endif



            {{-- <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert">
                <div class="flex">
                    <div>
                        <p class="text-sm">{{ session('message') }}</p>
        </div>
    </div>
</div> --}}


{{-- @if($isModalOpen) --}}
@include('students.create')
@include('students.edit')


<div class="row">
    <div class="col-md-12">

        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title ">Students</h4>
                <p class="card-category"> Here you can manage Students</p>

            </div>


            {{-- <button type="button" class="btn btn-primary" style="float: right; align-self: right;" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                            Add Student
                        </button></h5> --}}

            <div class="card-body">
                <div class="row">


                    @can('student-list')
                    <div class="col-12 text-right">
                        <div class=" col-md-4" style="width:25%; float: right;">
                            <input type="search" wire:model.debounce.500ms="search" class="form-control" placeholder="Search by name,email,phone,or address...">
                        </div>

                        <div class="d-flex align-items-center ml-4">
                            <label for="paginate" class="text-nowrap mr-2 mb-0" style="color:black;">Per Page</label>
                            <select wire:model="paginate" name="paginate" id="paginate" class="form-control form-control-sm" style="width:5%;">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>


                            </select>
                            <div>
                                @if ($checked)
                                <div class="dropdown ml-4">
                                    <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown">With Checked
                                        ({{ count($checked) }})</button>
                                    <div class="dropdown-menu">
                                        <a href="#" class="dropdown-item" type="button" onclick="confirm('Are you sure you want to delete these Records?') || event.stopImmediatePropagation()" wire:click="deleteRecords()">
                                            Delete
                                        </a>
                                        <a href="#" class="dropdown-item" type="button" onclick="confirm('Are you sure you want to export these Records?') || event.stopImmediatePropagation()" wire:click="exportSelected()">
                                            CSV
                                        </a>
                                        <a href="#" class="dropdown-item" type="button" onclick="confirm('Are you sure you want to export these Records?') || event.stopImmediatePropagation()" wire:click="excelSelected()">
                                            Excel
                                        </a>
                                        <a href="#" class="dropdown-item" type="button" onclick="confirm('Are you sure you want to export these Records?') || event.stopImmediatePropagation()" wire:click="pdfSelected()">
                                            PDF
                                        </a>


                                    </div>
                                </div>
                                @endif



                            </div>
                            <div class="dropdown ml-4">
                                <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown">Columns
                                </button>
                                <div class="dropdown-menu">
                                    @foreach($columns as $column)
                                    <li><input type="checkbox" wire:model="selectedColumns" value="{{$column}}">
                                        <label style="color:black;font-size:12px:">{{$column}}</label></li>
                                    @endforeach


                                </div>
                            </div>


                        </div>


                        {{-- @foreach($columns as $column)
                        <input type="checkbox" wire:model="selectedColumns" value="{{$column}}">
                        <label>{{$column}}</label>
                        @endforeach --}}



                        @can('student-create')

                        <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addStudentModal">Add Student</a>
                        @endcan

                    </div>


                </div>
                @if ($selectPage)
                <div class="col-md-10 mb-2">
                    @if ($selectAll)
                    <div>
                        You have selected all <strong>{{ $students->total() }}</strong> items.
                    </div>
                    @else
                    <div>
                        You have selected <strong>{{ count($checked) }}</strong> items,
                        {{-- Do you want to Select All
                        <strong>{{ $students->total() }}</strong>?
                        <a href="#" class="ml-2" wire:click="selectAll">Select All</a> --}}
                    </div>
                    @endif

                </div>
                @endif

                <div class="table-responsive text-nowrap">
                    <table class="table table-striped table-sortable">

                        <thead class=" text-primary">

                            <tr>
                                @if($this->showColumn('Check'))
                                <th><input type="checkbox" wire:model="selectPage"></th>
                                @endif
                                @if($this->showColumn('Id'))
                                <th>Number <i class="fa fa-fw fa-sort" wire:click="sortBy('id')"></i>


                                </th>

                                @endif
                                @if($this->showColumn('Name'))
                                <th>Name <i class="fa fa-fw fa-sort" wire:click="sortBy('name')"></i></th>



                                @endif
                                @if($this->showColumn('Email'))
                                <th>Email <i class="fa fa-fw fa-sort" wire:click="sortBy('email')"></i></th>


                                @endif
                                @if($this->showColumn('Mobile'))
                                <th>Mobile <i class="fa fa-fw fa-sort" wire:click="sortBy('mobile')"></i></th>


                                @endif
                                @if($this->showColumn('Image'))
                                <th>Image </th>


                                @endif

                                @if($this->showColumn('Action'))
                                <th>Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)

                            <tr class="@if ($this->isChecked($student->id))
                    table-primary
                @endif">
                                @if($this->showColumn('Check'))

                                <td><input type="checkbox" value="{{ $student->id }}" wire:model="checked"></td>
                                @endif
                                @if($this->showColumn('Id'))
                                <td class="border py-2">{{ $student->id }}</td>
                                @endif
                                @if($this->showColumn('Name'))
                                <td class="border px-2 py-2">{{ $student->name }}</td>
                                @endif
                                @if($this->showColumn('Email'))
                                <td class="border px-2 py-2">{{ $student->email}}</td>
                                @endif
                                @if($this->showColumn('Mobile'))
                                <td class="border px-2 py-2">{{ $student->mobile}}</td>
                                @endif
                                @if($this->showColumn('Image'))
                                <td class="border px-2 py-2"><a href="storage/{{$student->image }}" target="_blank"><img src="storage/{{ $student->image}}" width="50px" height="50px"></td>

                                @endif

                                @if($this->showColumn('Action'))
                                <td class="border px-2 py-2">
                                    @can('student-edit')
                                    <button data-bs-toggle="modal" data-bs-target="#updateStudentModal" wire:click.prevent="edit({{ $student->id }})" class="btn btn-info">Edit</button>
                                    @endcan

                                    @can('student-delete')
                                    <button onclick="confirm('Are you sure you want to delete this record?') || event.stopImmediatePropagation()" wire:click="delete({{ $student->id }})" class="btn btn-danger">Delete</button>
                                    @endcan
                                </td>
                                @endif

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $students->links() }}

                </div>
                @endcan

            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
