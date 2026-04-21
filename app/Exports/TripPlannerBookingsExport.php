<?php

namespace App\Exports;

use App\Models\TripPlanner;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TripPlannerBookingsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected array $columns;

    public function __construct(array $columns = [])
    {
        $this->columns = $columns ?: ['email', 'full_name'];
    }

    public function collection()
    {
        return TripPlanner::latest()->get();
    }

    public function headings(): array
    {
        $labels = [
            'id' => 'ID',
            'full_name' => 'Full Name',
            'nationality' => 'Nationality',
            'phone' => 'Phone',
            'email' => 'Email',
            'adults' => 'Adults',
            'children' => 'Children',
            'infants' => 'Infants',
            'arrival_date' => 'Arrival Date',
            'departure_date' => 'Departure Date',
            'message' => 'Message',
            'status' => 'Status',
        ];

        $headings = [];
        foreach ($this->columns as $column) {
            if (isset($labels[$column])) {
                $headings[] = $labels[$column];
            }
        }

        return $headings;
    }

    public function map($request): array
    {
        $map = [
            'id' => $request->id,
            'full_name' => $request->full_name,
            'nationality' => $request->nationality,
            'phone' => $request->phone ?: 'N/A',
            'email' => $request->email,
            'adults' => $request->adults,
            'children' => $request->children,
            'infants' => $request->infants,
            'arrival_date' => $request->arrival_date?->format('Y-m-d') ?? 'N/A',
            'departure_date' => $request->departure_date?->format('Y-m-d') ?? 'N/A',
            'message' => $request->message ?? 'N/A',
            'status' => $request->is_read ? 'Read' : 'Unread',
        ];

        $row = [];
        foreach ($this->columns as $column) {
            if (isset($map[$column])) {
                $row[] = $map[$column];
            }
        }

        return $row;
    }
}

