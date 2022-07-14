<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ChemistWithAddToCardsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnWidths, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $user_add_to_cards = \App\Addtocard::select('user_id')->distinct()->get();
        $output = [];
        foreach ($user_add_to_cards as $key => $user_add_to_card) {
            $user = \App\User::find($user_add_to_card->user_id);
            $chemist = null;
            if ($user) {
                $chemist = \App\Chemist::where('user_id', $user->id)->first();
            }
            if ($user && $chemist) {
                $output[$user->id][] = $user->created_at->format('d-M-Y');
                $output[$user->id][] = $user->mobile;
                $output[$user->id][] = $chemist->Party_Name;
                $output[$user->id][] = $chemist->Party_Code;
                $output[$user->id][] = $chemist->Contact_Person;
                $output[$user->id][] = $chemist->DL_No;
                $output[$user->id][] = $chemist->DL_File;
                $output[$user->id][] = $chemist->Email_ID;
                if ($chemist->city) {
                    $output[$user->id][] = $chemist->city->name;
                } else {
                    $output[$user->id][] = "";
                }
                if ($chemist->state) {
                    $output[$user->id][] = $chemist->state->name;
                } else {
                    $output[$user->id][] = "";
                }
                $output[$user->id][] = $chemist->PIN;
                $output[$user->id][] = $user->role;
                $output[$user->id][] = $chemist->GSTIN;
            }
        }
        return collect($output);
    }
    public function headings(): array
    {

        $heading1 = array(
            'Date',
            'Mobile No',
            'Party Name',
            'Party Code',
            'Conatct Person',
            'DL No.',
            'DL File',
            'Email ID',
            'City',
            'State',
            'PIN',
            'Party Type',
            'GST No.',
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
        $sheet->getStyle('A1:M1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00A7B5');
        $sheet->getStyle('A1:M1')->applyFromArray($style);
        $sheet->setTitle('Report');
    }
}