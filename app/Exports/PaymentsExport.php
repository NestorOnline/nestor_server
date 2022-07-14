<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PaymentsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnWidths, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $payment_from = request()->input('payment_from');
        $payment_to = request()->input('payment_to');
        $orders = \App\Order::whereBetween('created_at', [$payment_from . ' 00:00:00', $payment_to . ' 23:59:59'])->get();
        $SETTLEDAMOUNT = 0;
        $output = [];
        $UTR = '';

        foreach ($orders as $key => $order) {
            $payment = \App\Payment::where('Order_ID', $order->id)->first();
            if ($payment && $payment->UTR == $UTR && $payment->UTR) {
                $output[$order->id][] = '';
                $output[$order->id][] = '';
                $output[$order->id][] = '';
                $output[$order->id][] = $order->Party_Code;
                $output[$order->id][] = $order->Party_Name;
                if ($order->cities) {
                    $output[$order->id][] = $order->cities->name;
                } else {
                    $output[$order->id][] = "";
                }
                $output[$order->id][] = $order->Order_No;
                $output[$order->id][] = $payment->SETTLED_ORDERID;
                $output[$order->id][] = $payment->created_at;
                $output[$order->id][] = $payment->SETTLEDAMOUNT;
                $output[$order->id][] = $order->WalletAmount;
                $output[$order->id][] = $order->Grand_Total;
                $output[$order->id][] = $order->Invoice_Code;
                $output[$order->id][] = $order->Invoice_No;
                $output[$order->id][] = $order->Invoice_Date;
                $output[$order->id][] = $order->Invoice_Amount;

            } else if ($payment && $payment->UTR != $UTR && $payment->UTR) {
                $SETTLEDAMOUNT = 0;
                $SETTLEDAMOUNT = \App\Payment::where('UTR', $payment->UTR)->sum('SETTLEDAMOUNT');
                $output[$order->id][] = $payment->UTR;
                $output[$order->id][] = $payment->SETTLED_DATE;
                $output[$order->id][] = $SETTLEDAMOUNT;
                $output[$order->id][] = $order->Party_Code;
                $output[$order->id][] = $order->Party_Name;
                if ($order->cities) {
                    $output[$order->id][] = $order->cities->name;
                } else {
                    $output[$order->id][] = "";
                }
                $output[$order->id][] = $order->Order_No;
                $output[$order->id][] = $payment->SETTLED_ORDERID;
                $output[$order->id][] = $payment->created_at;
                $output[$order->id][] = $payment->SETTLEDAMOUNT;
                $output[$order->id][] = $order->WalletAmount;
                $output[$order->id][] = $order->Grand_Total;
                $output[$order->id][] = $order->Invoice_Code;
                $output[$order->id][] = $order->Invoice_No;
                $output[$order->id][] = $order->Invoice_Date;
                $output[$order->id][] = $order->Invoice_Amount;
                $UTR = $payment->UTR;
            }
        }
        return collect($output);
    }

    public function headings(): array
    {

        $heading1 = array(
            'UTR NO.',
            'SETTLED DATE',
            'SETTLED AMOUNT',
            'PARTY CODE',
            'PARTY NAME',
            'CITY',
            'ORDER NO',
            'PAYMENT ORDER ID',
            'PAYMENT DATE',
            'PAYMENT AMOUNT',
            'REDEEM AMOUNT',
            'ORDER VALUE',
            'INVOICE CODE',
            'INVOICE NO.',
            'INVOICE DATE',
            'INVOICE AMOUNT',
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
            'L' => 30,
            'M' => 30,
            'N' => 30,
            'O' => 30,
            'P' => 30,
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
        $sheet->getStyle('A1:P1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00A7B5');
        $sheet->getStyle('A1:P1')->applyFromArray($style);
        $sheet->setTitle('Report');
    }

}