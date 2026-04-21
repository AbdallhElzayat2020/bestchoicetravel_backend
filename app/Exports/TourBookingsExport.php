<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TourBookingsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected array $columns;

    public function __construct(array $columns = [])
    {
        $this->columns = $columns ?: ['email', 'full_name'];
    }

    public function collection()
    {
        return Booking::with('tour')->latest()->get();
    }

    public function headings(): array
    {
        $labels = [
            'id' => 'ID',
            'tour' => 'Tour',
            'full_name' => 'Customer',
            'email' => 'Email',
            'phone' => 'Phone',
            'nationality' => 'Nationality',
            'no_of_travellers' => 'Travellers',
            'total_price' => 'Total Price',
            'status' => 'Status',
            'notes' => 'Notes',
        ];

        $headings = [];
        foreach ($this->columns as $column) {
            if (isset($labels[$column])) {
                $headings[] = $labels[$column];
            }
        }

        return $headings;
    }

    public function map($booking): array
    {
        $map = [
            'id' => $booking->id,
            'tour' => $booking->tour->title ?? 'N/A',
            'full_name' => $booking->full_name,
            'email' => $booking->email,
            'phone' => $booking->phone ?? 'N/A',
            'nationality' => $booking->nationality ?? 'N/A',
            'no_of_travellers' => $booking->no_of_travellers ?? 1,
            'total_price' => $booking->total_price,
            'status' => ucfirst((string) $booking->status),
            'notes' => $booking->notes ?? 'N/A',
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

