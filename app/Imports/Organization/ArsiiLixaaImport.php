<?php

namespace App\Imports\Organization;

use App\Models\Organization\ArsiiLixaa;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class ArsiiLixaaImport implements ToCollection
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @param Collection $rows
     *
     * @return void
     */
    public function collection(Collection $rows)
    {
        // Remove header row
        $rows->shift();

        $error = null;

        foreach ($rows as $row) {
            if ($row[0] != null) {
                try {
                    ArsiiLixaa::create([
                        'id' => $this->id,
                        'member_id' => $row[0],
                        'organization_name' => $row[1],
                        'organization_type' => $row[2],
                        'woreda' => $row[3],
                        'phone_number' => $row[4],
                        'email' => $row[5],
                        'payment_period' => $row[6],
                        'member_started' => $row[7],
                        'paymemt' => $row[8],
                    ]);

                } catch (\Exception $e) {
                    $error = 'Please check your Excel file. Row might have invalid data.';
                }
            }
        }

        if ($error != null) {
            return redirect()->route('arsii_lixaa.index')->with('delete', $error);
        } else {
            return redirect()->route('arsii_lixaa.index')->with('success', 'Data imported successfully');
        }
    }
}
