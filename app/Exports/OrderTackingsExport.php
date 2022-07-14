<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OrderTackingsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnWidths, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        $orders = \App\Order::where('created_at', '>', '2022-04-01 00:00:00')->orderBy('id', 'DESC')->get();
        foreach ($orders as $key => $order) {
            $output[$order->id][] = $key + 1;
            $output[$order->id][] = $order->created_at->format('d-M-Y');
            if ($order->states) {
                $output[$order->id][] = $order->states->name;
            } else {
                $output[$order->id][] = '';
            }
            $output[$order->id][] = '';
            $output[$order->id][] = $order->Party_Name;
            $output[$order->id][] = $order->Grand_Total;
            $output[$order->id][] = $order->Tracking_ID;
            if ($order->ProcessingOn) {
                $output[$order->id][] = $order->ProcessingOn->format('d-M-Y');
            } else {
                $output[$order->id][] = '';
            }
            if ($order->PackedOn) {
                $output[$order->id][] = $order->PackedOn->format('d-M-Y');
            } else {
                $output[$order->id][] = '';
            }

            if ($order->DispatchedOn) {
                $output[$order->id][] = $order->DispatchedOn->format('d-M-Y');
            } else {
                $output[$order->id][] = '';
            }
            if ($order->DeliveredOn) {
                $output[$order->id][] = $order->DeliveredOn->format('d-M-Y');
                $output[$order->id][] = 'Delievered';
            } else {
                $output[$order->id][] = '';
                $output[$order->id][] = 'Not Delievered';
            }
        }
        return collect($output);
    }
    public function headings(): array
    {
        $heading1 = array(
            'S. No.',
            'Date',
            'State',
            'HQ Name',
            'Party Name',
            'Order Value',
            'Docket No.',
            'ProcessingOn',
            'PackedOn',
            'DispatchedOn',
            'DeliveredOn',
            'DeliverY Status',
        );
        return [
            $heading1,
        ];
    }
    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 30,
            'C' => 30,
            'D' => 30,
            'E' => 30,
            'F' => 30,
            'G' => 30,
            'H' => 30,
            'I' => 30,
            'J' => 30,
            'K' => 30,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $style = array(
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => 'ffffff'),
                'size' => 10,
                'name' => 'Arial',
            ), 'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'ffffff'],
                ],
            ],
        );
        $sheet->getStyle('A1:K1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00A7B5');
        $sheet->getStyle('A1:K1')->applyFromArray($style);
        $sheet->setTitle('Report');
    }
}