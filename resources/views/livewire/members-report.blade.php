<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">



            <div class="row">

                <div class="col-md-12">

                    <div class="card elevation-2" style="border-radius: 2px;">

                        <div class="card-header m-2">

                            <h3 class="card-title">Zone Members Report</h3>

                        </div>



                        <div class=" row">


                            <div class="col-12 text-right">

                                <div class="d-flex align-items-center ml-4">

                                    <div>
                                        @if ($checked)
                                        <div class="dropdown ml-4">
                                            <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="material-icons">file_download</i>
                                                ({{ count($checked) }})</button>
                                            <div class="dropdown-menu">
                                                <a href="#" class="dropdown-item" type="button" onclick="confirm('Are you sure you want to export these Records?') || event.stopImmediatePropagation()" wire:click="excelSelected()">
                                                    Excel
                                                </a>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <br />
                                    &nbsp;&nbsp;
                                    <label for="zone" class="text-nowrap mr-3 mb-0" style="color:black;">Zone</label>
                                    <select wire:model="zone" id="zone" class="form-control" style="width:10%;">
                                        <option value="">Select Zone</option>
                                        <option value="zone1s">Zone 1</option>
                                        <option value="zone2s">Zone 2</option>
                                        <option value="zone3s">Zone 3</option>
                                        <option value="zone4s">Zone 4</option>
                                    </select>
                                    <br /> &nbsp;&nbsp;
                                </div>
                            </div>


                            <div class="table-responsive text-nowrap">
                                <table class="table table-striped table-sortable pb-1 mt-2">

                                    <thead>

                                        <tr>
                                            <th><input type="checkbox" wire:model="selectPage"></th>
                                            <th>Number <i class="fa fa-fw fa-sort" wire:click="sortBy('id')"></i>
                                            <th>Zone</th>
                                            <th>Woreda</th>
                                            <th>Position</th>
                                            <th>Total</th>
                                            </th>
                                    </thead>
                                    <tbody>
                                        @foreach($reports as $report)

                                        <tr class="@if ($this->isChecked($report->id))
                    table-primary
                @endif">
                                            <td><input type="checkbox" value="{{ $report->id }}" wire:model="checked"></td>
                                            <td class="border py-2">{{ $report->id }}</td>
                                            <td class="border py-2">{{ $report->zone }}</td>
                                            <td class="border py-2">{{ $report->woreda }}</td>
                                            <td class="border py-2">{{ $report->position }}</td>
                                            <td class="border py-2">{{ $report->total }}</td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
