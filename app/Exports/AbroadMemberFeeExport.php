<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;


class AbroadMemberFeeExport implements FromCollection, WithMapping, WithHeadings
{

    use Exportable;

    protected $reports;

    public function __construct($reports)
    {
        $this->reports = $reports;
    }

    public function collection()
    {
        return $this->reports;
    }

    public function map($report): array
    {
        return [
            $report->country,
            $report->position,
            $report->date,
            $report->total,
        ];
    }

    public function headings(): array
    {
        return [
            'Country',
            'Position',
            'Date',
            'Total',
        ];
    }
}
