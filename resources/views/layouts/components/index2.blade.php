  @extends('layouts.app')

  @section('content')
      {{-- @section('title', '') --}}
      {{-- <x-app-layout> --}}
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
                                              <i class="bx bxs-@yield('icons')" style="font-size: 2.5em;color:green;"></i>
                                              {{-- <i class="bx bxs-user-circle"></i> --}}
                                          </div>
                                      </div>
                                      <span>@yield('title')</span>
                                      <h3 class="card-title text-nowrap mb-1">{{ $count }}</h3>
                                  </div>

                              </div>

                          </div>

                      </div>
                      {{-- <div class="col-lg-3 col-md-6 col-sm-6">
                           <div class="col-lg-12 col-md-12 col-12 mb-4">
                               <div class="card">
                                   <div class="card-body">
                                       <div class="card-title d-flex align-items-start justify-content-between">
                                           <div class="avatar flex-shrink-0">
                                               {{-- insert icons dynamically from variable 
                                               <i class="bx bxs-@yield('icons')" style="font-size: 2.5em;color:green;"></i>
                                               {{-- <i class="bx bxs-user-circle"></i> 
                                           </div>
                                       </div>
                                       <span>{{__('Kuyyuu')}} </span>
                                       <h3 class="card-title text-nowrap mb-1">{{ $count_woreda}}</h3>
                                   </div>

                               </div>

                           </div>

                       </div> --}}
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
                                  <h4 class="card-title ">@yield('title')</h4>
                              </div>





                              <div class="card-body">

                                  <div class="row">

                                      <div class="col-3 mb-3 align-content-end" style="text-align: right;">
                                          <form action="@yield('import')" method="POST" enctype="multipart/form-data">
                                              @csrf
                                              <input type="file" name="file" class="form-control">
                                              <button class="btn btn-sm btn-success" style="text-align: right;">Import
                                                  @yield('insert')</button>
                                          </form>
                                      </div>


                                      {{-- <div class="col-6 mb-3">
                                          <form method="GET" action="@yield('filterAction')" class="mb-3">
                                              <div class="row">
                                                  <div class="col-6 mb-3">
                                                      <select name="@yield('filterName', 'woreda')" class="form-control" required>
                                                          <option value="">-- Select @yield('filterLabel', 'Woreda') --</option>
                                                          @foreach ($woredas as $w)
                                                              <option value="{{ $w }}"
                                                                  {{ ($selectedWoreda ?? '') == $w ? 'selected' : '' }}>
                                                                  {{ $w }}</option>
                                                          @endforeach
                                                      </select>
                                                  </div>
                                                  <div class="col-md-3">
                                                      <button type="submit"
                                                          class="btn btn-success mb-2">@yield('filterButton', 'Show Data')</button>
                                                  </div>


                                              </div>

                                          </form>
                                      </div> --}}
                                      <div class="col-3 mb-3 align-content-center" style="text-align: right;">
                                          <a href="@yield('route')" class="btn btn-sm btn-success">Add
                                              @yield('insert')</a>
                                      </div>
                                  </div>

                                  <div class="table-responsive table-strip">
                                      {{-- contains content --}}
                                      @yield('table')
                                  </div>
    {{-- {!! $reports->links() !!} --}}

                              </div>
                          </div>

                      </div>
                  </div>
              </div>
          </div>
      </div>
      {{-- </x-app-layout> --}}
  @endsection
