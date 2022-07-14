<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnWidths, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $products = \App\Product::all();
        $SETTLEDAMOUNT = 0;
        $output = [];
        $UTR = '';

        foreach ($products as $key => $product) {
            $output[$product->id][] = $key + 1;
            $output[$product->id][] = $product->generic_name;
            $output[$product->id][] = $product->brand_name;
            $output[$product->id][] = $product->product_code;
            $output[$product->id][] = $product->Product_ID;
            if ($product->ProductBrand_Code == 1) {
                $output[$product->id][] = 'Nestor';
            } elseif ($product->ProductBrand_Code == 2) {
                $output[$product->id][] = 'STERIHEAL';
            } elseif ($product->ProductBrand_Code == 3) {
                $output[$product->id][] = 'NECTARINE';
            } else {
                $output[$product->id][] = "";
            }

            $package = \App\Package::find($product->package_id);
            if ($package) {
                $output[$product->id][] = $package->name;
                $output[$product->id][] = $package->Packing_Description;
            } else {
                $output[$product->id][] = "";
                $output[$product->id][] = "";
            }

            if ($product->mrp_price) {
                $output[$product->id][] = $product->mrp_price->Price;
            } else {
                $output[$product->id][] = "";
            }
            if ($product->chemist_price) {
                $output[$product->id][] = $product->chemist_price->Price;
            } else {
                $output[$product->id][] = "";
            }

            if ($product->customer_mrp_price) {
                $output[$product->id][] = $product->customer_mrp_price->Price;
            } else {
                $output[$product->id][] = "";
            }

            if ($product->customer_price) {
                $output[$product->id][] = $product->customer_price->Price;
            } else {
                $output[$product->id][] = "";
            }
            if ($product->go_live == 1) {
                $output[$product->id][] = 'Available';
            } else {
                $output[$product->id][] = 'Upcoming Product';
            }

        }
        return collect($output);
    }

    public function headings(): array
    {

        $heading1 = array(
            'S NO.',
            'Generic Name',
            'Brand Name',
            'PRODUCT CODE',
            'PRODUCT ID',
            'BRAND',
            'B2B Packing',
            'B2C Packing',
            'B2B MRP',
            'B2B Purchase Price (Without GST)',
            'B2C MRP',
            'B2C Purchase Price (Without GST)',
            'Product Availablity',
        );
        return [
            $heading1,
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 50,
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