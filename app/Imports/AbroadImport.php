<?php

namespace App\Imports;

use App\Models\Abroad;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class AbroadImport implements ToCollection
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
                    Abroad::create([
                        'id' => $this->id,
                        'first_name' => $row[0],
                        'middle_name' => $row[1],
                        'last_name' => $row[2],
                        'gender' => $row[3],
                        'age' => $row[4],
                        'country' => $row[5], // <--- 'country' => $row[5], instead of 'address
                        'address' => $row[6],
                        'contact_number' => $row[7],
                        'email' => $row[8],
                        'position' => $row[8],
                        'membership_type' => $row[10],
                        'membership_fee' => $row[11],
                    ]);
                } catch (\Exception $e) {
                    $error = 'Please check your excel file';
                }
            }
        }

        if ($error != null) {
            return redirect()->route('abroad.index')->with('delete', $error);
        } else {
            return redirect()->route('abroad.index')->with('success', 'Data imported successfully');
        }
    }
}
