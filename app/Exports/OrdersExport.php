<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class OrdersExport implements FromCollection, WithHeadings, WithEvents
{
    protected $month;
    protected $year;
    protected $status;

    public function __construct($month, $year, $status)
    {
        $this->month = $month;
        $this->year = $year;
        $this->status = $status;
    }

    public function collection()
    {
        // Query orders dengan filter berdasarkan bulan, tahun, dan status
        $query = Order::with(['user', 'vehicle', 'driver']);

        if ($this->month) {
            $query->whereMonth('start_date', $this->month);
        }

        if ($this->year) {
            $query->whereYear('start_date', $this->year);
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        return $query->get()->map(function ($order) {
            return [
                'no' => $order->id,
                'vehicle' => $order->vehicle->vehicle_name,
                'driver' => $order->driver->name,
                'approver1' => $order->approver1->full_name,
                'approver2' => $order->approver2->full_name,
                'start_date' => $order->start_date,
                'end_date' => $order->end_date,
                'reason' => $order->reason,
                'status' => $order->status,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Vehicle',
            'Driver',
            'Approver 1',
            'Approver 2',
            'Start Date',
            'End Date',
            'Reason',
            'Status',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                // Menambahkan style untuk header
                $sheet->getStyle('A1:I1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => 'FFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => '1F509A'],
                    ],
                ]);

                // Menambahkan border hanya di bagian luar tabel
                $lastRow = $sheet->getHighestRow(); // Mendapatkan baris terakhir
                $sheet->getStyle('A1:I' . $lastRow)->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            },
        ];
    }
}
