<?php

namespace App\Http\Livewire;

use App\Models\Zone1;
use App\Models\Zone2;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\WeeklyProgram;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use App\Exports\WeeklyProgramExport;

class MembersReport extends Component
{
    public $zone = 'zone1s';
    public $name = 'Arsii';


    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $search = "";

    public $paginate = 8;
    public $isOpen = 0;
    public  $report_id;
    public $checked = [];
    public $selectPage = false;
    public $selectAll = false;
    public $sortColumn = 'created_at';
    public $sortOrder = 'desc';

    //Sorting By feature
    public function sortBy($field)
    {
        if ($this->sortColumn === $field) {

            $this->sortOrder = $this->sortOrder === 'desc' ? 'asc' : 'desc';
        } else {
            $this->sortOrder = 'desc';
        }
        $this->sortColumn = $field;
    }

    public function render()
    {
        // $zone_all = All_zone::findorfail();

        // $zone = $this->zone;
        if ($this->zone == 'zone1s') {
            $this->name = 'Arsii';
        } elseif ($this->zone == 'zone2s') {
            $this->name = 'Arsii-Lixaa';
        } elseif ($this->zone == 'zone3s') {
            $this->name = 'Baalee';
        } elseif ($this->zone == 'zone4s') {
            $this->name = 'Baalee-Bahaa';
        } elseif ($this->zone == 'zone5s') {
            $this->name = 'Booranaa';
        } elseif ($this->zone == 'zone6s') {
            $this->name = 'Bunno- Baddalle';
        } elseif ($this->zone == 'zone7s') {
            $this->name = 'Finfinnee';
        } elseif ($this->zone == 'zone8s') {
            $this->name = 'Gujii';
        } elseif ($this->zone == 'zone9s') {
            $this->name = 'Gujii-Lixaa';
        } elseif ($this->zone == 'zone10s') {
            $this->name = 'Harargee-Bahaa';
        } elseif ($this->zone == 'zone11s') {
            $this->name = 'Harargee-Lixaa';
        } elseif ($this->zone == 'zone12s') {
            $this->name = 'Horroo-Guduruu-Wallaga';
        } elseif ($this->zone == 'zone13s') {
            $this->name = 'Iluu-Abbaa-Booraa';
        } elseif ($this->zone == 'zone14s') {
            $this->name = 'Jimmaa';
        } elseif ($this->zone == 'zone15s') {
            $this->name = 'Qeellam-Wallaga';
        } elseif ($this->zone == 'zone16s') {
            $this->name = 'Shawaa-Bahaa';
        } elseif ($this->zone == 'zone17s') {
            $this->name = 'Shawaa-Kaabaa';
        } elseif ($this->zone == 'zone18s') {
            $this->name = 'Shawaa-Kibbaaa-Lixaa';
        } elseif ($this->zone == 'zone19s') {
            $this->name = 'Shawaa-Lixaa';
        } elseif ($this->zone == 'zone20s') {
            $this->name = 'Wallaga-Bahaa';
        } elseif ($this->zone == 'zone21s') {
            $this->name = 'Wallaga-Lixaa';
        }

        $reports = DB::table($this->zone)
            ->select('woreda', 'position','name','first_name', DB::raw('count(*) as total'))
            ->groupBy('position', 'woreda')
            ->get();
        $id = 1;
        foreach ($reports as $report) {
            $report->id = $id++;
            $report->zone = $this->name;
            $report->woreda = $report->woreda;
            $report->position = $report->position;
            $report->total = $report->total;
        }


 

        // dd($reports);

        return view('livewire.members-report', compact('reports'));
    }

    public function isChecked($report_id)
    {
        return in_array($report_id, $this->checked);
    }
    // Export
    public function exportSelected()
    {
        $date = date('d-m-y');

        // return (new WeeklyProgramExport)->forChecked($this->checked)->download("WeeklyProgram" . $date . ".csv");
    }

    public function excelSelected()
    {
        $date = date('d-m-y');

        // return (new WeeklyProgramExport)->forChecked($this->checked)->download("WeeklyProgram" . $date . ".xlsx");
    }
}
