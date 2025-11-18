<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class StudentsExport implements FromQuery
{
    use Exportable;

    protected $students;

    protected $selectedColumns;

    // public function __construct($students, $selectedColumns)
    // {
    //     $this->students = $students;
    //     $this->selectedColumns = $selectedColumns;
    // }
    public function forChecked($students)
    {
        $this->students = $students;

        return $this;
    }
    // public function forSelected($selectedColumns)
    // {
    //     $this->selectedColumns = $selectedColumns;

    //     return $this;
    // }

    public function query()
    {
        return Student::query()->whereKey($this->students);
        // return Student::query()->get($this->selectedColumns);
    }
}
