@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">Create Project</div>
        <div class="card-body">
            <form action="{{ route('project.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Zone & Woreda Dropdowns -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Zone</label>
                        <select name="zone" id="zone" class="form-control">
                            <option value="">Select Zone</option>
                            @foreach ($zones as $zone)
                                <option value="{{ $zone }}">{{ $zone }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Woreda / City</label>
                        <select name="woreda_or_city" id="woreda" class="form-control">
                            <option value="">Select Woreda</option>
                        </select>
                    </div>
                </div>

                <!-- Project Details -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="text" name="name" placeholder="Project Name" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="type" placeholder="Type" class="form-control">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="text" name="site" placeholder="Site" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <input type="number" name="numbers" placeholder="Numbers" class="form-control">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="text" name="started_year" placeholder="Started Year" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="address" placeholder="Address" class="form-control">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="text" name="progression" placeholder="Progression" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <input type="number" name="budget" placeholder="Budget" class="form-control">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="number" name="community_participation" placeholder="Community Participation" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <input type="number" name="deployed_budget" placeholder="Deployed Budget" class="form-control">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="number" name="total_budget" placeholder="Total Budget" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <input type="number" name="benefitiary" placeholder="Benefitiary" class="form-control">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="number" name="how_many_get_job" placeholder="How Many Get Job" class="form-control">
                    </div>
                </div>

                <button class="btn btn-success" type="submit">Create Project</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$('#zone').on('change', function() {
    let selectedZone = $(this).val();
    $('#woreda').html('<option value="">Loading...</option>');

    if (selectedZone) {
        $.ajax({
            url: "/fetch-woreda/" + selectedZone,
            type: "GET",
            success: function(data) {
                $('#woreda').empty();
                $('#woreda').append('<option value="">Select Woreda</option>');
                $.each(data, function(key, value) {
                    $('#woreda').append('<option value="'+value+'">'+value+'</option>');
                });
            }
        });
    } else {
        $('#woreda').html('<option value="">Select Woreda</option>');
    }
});
</script>
@endsection
