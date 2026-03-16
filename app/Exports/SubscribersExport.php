<?php

namespace App\Exports;

use App\Models\Subscriber;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SubscribersExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $columns;

    public function __construct($columns = [])
    {
        $this->columns = $columns ?: ['email', 'name'];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Subscriber::orderBy('created_at', 'desc')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        $headings = [];
        $columnLabels = [
            'id' => 'ID',
            'email' => 'Email',
            'name' => 'Name',
            'is_active' => 'Status',
            'subscribed_at' => 'Subscribed At',
            'unsubscribed_at' => 'Unsubscribed At',
        ];

        foreach ($this->columns as $column) {
            if (isset($columnLabels[$column])) {
                $headings[] = $columnLabels[$column];
            }
        }

        return $headings;
    }

    /**
     * @param mixed $subscriber
     * @return array
     */
    public function map($subscriber): array
    {
        $data = [];
        $columnData = [
            'id' => $subscriber->id,
            'email' => $subscriber->email,
            'name' => $subscriber->name ?? 'N/A',
            'is_active' => $subscriber->is_active ? 'Active' : 'Inactive',
            'subscribed_at' => $subscriber->subscribed_at ? $subscriber->subscribed_at->format('Y-m-d H:i:s') : 'N/A',
            'unsubscribed_at' => $subscriber->unsubscribed_at ? $subscriber->unsubscribed_at->format('Y-m-d H:i:s') : 'N/A',
        ];

        foreach ($this->columns as $column) {
            if (isset($columnData[$column])) {
                $data[] = $columnData[$column];
            }
        }

        return $data;
    }
}
