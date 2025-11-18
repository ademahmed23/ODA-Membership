<?php

namespace App\Imports;

use App\Models\Zone13;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class Zone13Import implements ToCollection
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        $rows->shift();
        $error = null;
        foreach ($rows as $row) {
            if ($row[0] != null) {
                try {
                    Zone13::create([
                        'id' => $this->id,
                        'member_id' => $row[0],
                        'first_name' => $row[1],
                        'middle_name' => $row[2],
                        'last_name' => $row[3],
                        'gender' => $row[4],
                        'age' => $row[5],
                        'education_level' =>$row[6],
                        'address' => $row[7],
                        'contact_number' => $row[8],
                        'woreda' => $row[9],
                        'email' => $row[10],
                        'position' => $row[11],
                        'membership_type' => $row[12],
                        'membership_fee' => $row[13],
                    ]);
                } catch (\Exception $e) {
                    $error = 'Please check your excel file';
                }
            }
        }

        if ($error != null) {
            return redirect()->route('zone13.index')->with('delete', $error);
        } else {
            return redirect()->route('zone13.index')->with('success', 'Data imported successfully');
        }
    }
}
