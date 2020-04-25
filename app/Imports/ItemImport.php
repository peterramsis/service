<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\item;


class ItemImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach($rows as $row){
           
            $check = item::where("item_name",$row[0])->count();

            if($check != 1){

                $data = array(
                    "item_name" => $row[0] 
                );

                $item = item::create($data);
              
            }

        }
    }
}
