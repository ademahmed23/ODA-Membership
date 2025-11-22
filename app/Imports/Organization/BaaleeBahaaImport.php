<?php

namespace App\Imports\Organization;

use App\Models\Organization\BaaleeBahaa;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class BaaleeBahaaImport implements ToCollection
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function collection(Collection $rows)
    {
        // Remove header row
        $rows->shift();

        $error = null;

        foreach ($rows as $row) {
            if (!empty($row[0])) {
                try {
                    BaaleeBahaa::create([
                        'id'                => $this->id,
                        'member_id'         => $row[0],
                        'organization_name' => $row[1],
                        'organization_type' => $row[2],
                        'woreda'            => $row[3],
                        'phone_number'      => $row[4],
                        'email'             => $row[5],
                        'payment_period'    => $row[6],
                        'member_started'    => $row[7],
                        'payment'           => $row[8],
                    ]);
                } catch (\Exception $e) {
                    $error = 'Please check your Excel file. Some rows contain invalid data.';
                }
            }
        }

        if ($error) {
            return redirect()
                ->route('baalee_bahaa.index')
                ->with('delete', $error);
        }

        return redirect()
            ->route('baalee_bahaa.index')
            ->with('success', 'Data imported successfully');
    }
}
