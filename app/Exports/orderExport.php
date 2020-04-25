<?php

namespace App\Exports;

use App\cart;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class orderExport implements  FromView,ShouldAutoSize,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($id)
    {
        $this->id = $id;
        
    }
    public function view(): View
    {
        return view('admin.cart.export', [
            'cart' => cart::find($this->id)
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                // All headers - set font size to 14
                $cellRange = 'A0:W9';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(17);
                $cellRange = 'A2';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(17);
                $cellRange = 'A2:A50';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(17);
    
    
                // Apply array of styles to B2:G8 cell range
    
               
                $styleArray = [
                    'borders' => [
                            'outline' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['rgb' => 'FFFF00'],
    
                            ]
                        ],
                     'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                     ]
    
                ];
    
    
    
    
    
    
    
    
                $event->sheet->getDelegate()->getStyle("A5:F5")->applyFromArray($styleArray);
    
                $event->sheet->getStyle('A7:F7')->getFill()
                     ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                     ->getStartColor()->setARGB('FFFF00');
                $event->sheet->getStyle('A1:A6')->getFill()
                     ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                     ->getStartColor()->setARGB('FFFF00');
    
    
    
                     $alphabet = array('A','B','C','D','E','F');
    
    
                     for ($x=0; $x < count($alphabet); $x++) {
                         for ($i=1; $i < 20; $i++) {
         
         
         
                             $styleArray = [
                                 'borders' => [
                                         'outline' => [
                                             'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                            
         
                                         ]
                                     ],
                                  'alignment' => [
                                         'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                                  ]
         
                             ];
         
         
         
         
                         $frist = $alphabet[$x].$i.":";
                         $plus = $i+ 1;
                         $last = $alphabet[$x].$plus.":";
                         $event->sheet->getDelegate()->getStyle($frist.$last)->applyFromArray($styleArray);
                         $event->sheet->getStyle('A1:Z1')->getFill()
                         ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
         
         
                         if($x%2 == 1){
         
                             $frist = $alphabet[$x].$i.":";
                             $plus = $i+ 1;
                             $last = $alphabet[$x].$plus.":";
         
         
                             $event->sheet->getStyle($frist.$last)->getFill()
                             ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
         
         
                         }
         
         
                         }
                     }
    
    
                // Set first row to height 20
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(20);
    
                // Set A1:D4 range to wrap text in cells
                $event->sheet->getDelegate()->getStyle('A1:D4')
                    ->getAlignment()->setWrapText(true);
            },
        ];
    }
}
