<?php

namespace App\Http\Livewire;

use App\Exports\StudentsExport;
use App\Models\Student;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Students extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    public $search = '';

    public $paginate = 10;

    public $name;

    public $email;

    public $mobile;

    public $image;

    public $student_id;

    public $studentsQuery;

    public $isOpen = 0;

    public $checked = [];

    public $selectPage = false;

    public $selectAll = false;

    public $columns = ['Check', 'Id', 'Name', 'Email', 'Mobile', 'Image', 'Action'];

    public $selectedColumns = [];

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

    //This is for column visibility on the render of the page
    public function mount()
    {
        $this->selectedColumns = $this->columns;
    }

    //this is for visibility of olumn
    public function showColumn($column)
    {
        return in_array($column, $this->selectedColumns);
    }

    //this is the index method
    public function render()
    {
        $students = Student::search(trim($this->search))->orderBY($this->sortColumn, $this->sortOrder)->paginate($this->paginate);

        return view('students.index', compact('students'));
    }

    //this is to reset the modal after after insert
    private function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->mobile = '';
        $this->student_id = '';
        // $this->image = '';
    }
    //this is for the edit modal

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $this->student_id = $id;
        $this->name = $student->name;
        $this->email = $student->email;
        $this->mobile = $student->mobile;
    }
    //this checks if the check box is activated

    public function isChecked($student_id)
    {
        return in_array($student_id, $this->checked);
    }

    //this is to delete
    public function deleteRecords()
    {
        Student::whereKey($this->checked)->delete();
        $this->checked = [];
        $this->selectAll = false;
        $this->selectPage = false;
        session()->flash('delete', 'Selected Records were deleted Successfully');
    }

    //this is to update the whole page
    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->checked = Student::pluck('id')->map(fn ($item) => (string) $item)->toArray();
        } else {
            $this->checked = [];
        }
    }

    //this are to export the table in different format
    public function exportSelected()
    {
        $date = date('d-m-y');

        return (new StudentsExport)->forChecked($this->checked)->download('students'.$date.'.csv');
    }

    public function excelSelected()
    {
        $date = date('d-m-y');

        return (new StudentsExport)->forChecked($this->checked)->download('students'.$date.'.xlsx');
    }

    public function pdfSelected()
    {
        $date = date('d-m-y');

        return (new StudentsExport)->forChecked($this->checked)->download('students'.$date.'.pdf');
    }

    public function updatedChecked()
    {
        $this->selectPage = false;
    }

    public function selectAll()
    {
        $this->selectAll = true;
        $this->checked = $this->studentsQuery->pluck('id')->map(fn ($item) => (string) $item)->toArray();
    }

    public function store()
    {
        $dataValid = $this->validate([
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'image' => 'image|max:22024',
        ]);

        $dataValid['image'] = $this->image->store('student', 'public');

        Student::create($dataValid);

        session()->flash('message', 'Student Created Successfully.');
        $this->resetInputFields();
        $this->emit('studentAdded');
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
        ]);

        if ($this->image) {
            Storage::delete($this->image);

            if ($this->student_id) {
                $student = Student::find($this->student_id);
                $student->update([
                    'name' => $this->name,
                    'email' => $this->email,
                    'mobile' => $this->mobile,
                    'image' => $this->image->store('student', 'public'),
                ]);
            }
        } else {
            if ($this->student_id) {
                $student = Student::find($this->student_id);
                $student->update([
                    'name' => $this->name,
                    'email' => $this->email,
                    'mobile' => $this->mobile,

                ]);
            }
        }

        session()->flash('update', 'Student Updated Successfully.');
        $this->resetInputFields();
        $this->emit('studentUpdated');
    }

    public function delete($id)
    {
        Student::find($id)->delete();
        session()->flash('delete', 'Student Deleted Successfully.');
    }
}
