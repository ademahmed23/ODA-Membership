<?php

namespace App\Imports;

use App\Models\City16;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class City16Import implements ToCollection
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
                    City16::create([
                        'id' => $this->id,
                        'first_name' => $row[0],
                        'middle_name' => $row[1],
                        'last_name' => $row[2],
                        'gender' => $row[3],
                        'age' => $row[4],
                        'address' => $row[5],
                        'contact_number' => $row[6],
                        'email' => $row[7],
                        'position' => $row[8],
                        'membership_type' => $row[9],
                        'membership_fee' => $row[10],
                    ]);
                } catch (\Exception $e) {
                    $error = 'Please check your excel file';
                }
            }
        }

        if ($error != null) {
            return redirect()->route('city16.index')->with('delete', $error);
        } else {
            return redirect()->route('city16.index')->with('success', 'Data imported successfully');
        }
    }
}
