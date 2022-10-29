<?php

namespace App\Imports;

use App\Models\Brand;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BrandImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $name = $row['brend'];
//
//        if  (!Brand::where('name', $name)->exists()) {
////            return new Brand([
////                'name' => ucfirst($name),
////                'category_id' => 1
////            ]);
////        }
    }
}
