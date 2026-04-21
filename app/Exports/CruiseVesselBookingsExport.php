<?php

namespace App\Exports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CruiseVesselBookingsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected array $columns;

    public function __construct(array $columns = [])
    {
        $this->columns = $columns ?: ['email', 'name'];
    }

    public function collection()
    {
        return Contact::query()->cruiseVesselEnquiries()->latest()->get();
    }

    public function headings(): array
    {
        $labels = [
            'id' => 'ID',
            'vessel' => 'Vessel',
            'name' => 'Customer',
            'email' => 'Email',
            'phone' => 'Phone',
            'subject' => 'Subject',
            'message' => 'Message',
            'category_id' => 'Category ID',
            'sub_category_id' => 'Sub Category ID',
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

    public function map($contact): array
    {
        $map = [
            'id' => $contact->id,
            'vessel' => $contact->cruiseVesselTitle() ?? 'N/A',
            'name' => $contact->name,
            'email' => $contact->email,
            'phone' => $contact->phone ?: 'N/A',
            'subject' => $contact->subject ?? 'N/A',
            'message' => $contact->message ?? 'N/A',
            'category_id' => $contact->category_id ?? 'N/A',
            'sub_category_id' => $contact->sub_category_id ?? 'N/A',
            'status' => $contact->is_read ? 'Read' : 'Unread',
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

