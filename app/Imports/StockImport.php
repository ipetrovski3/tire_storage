<?php

namespace App\Imports;

use App\Models\Brand;
use App\Models\pattern;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StockImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $row_width = $row['shirina'];
        $row_height = $row['visina'];
        $row_radius = $row['dijametar'];
        $row_pattern = $row['shara'];
        $row_brand = $row['brend'];

        $brand = $this->find_or_create('brand', $row_brand);
        $pattern = $this->find_or_create('pattern', $row_pattern, $brand);

        return new Product([

            'brand_id' => $brand->id,
            'pattern_id' => $pattern->id,
            'location' => $this->set_location($row_width, $row_height, $row_radius),
            'name' => $this->set_name(
                $brand->name,
                $pattern->name,
                $row_width,
                $row_height,
                $row_radius
            ),
            'code' => $this->generate_code($brand->id),
            'category_id' => 1,
            'income_price' => 0,
            'stock' => $row['kolicina'],
        ]);
    }




    private function set_location($width, $height, $radius)
    {
        $location_elements = [$width, $height, $radius];
        return join('', $location_elements);
    }

    private function set_name($brand, $pattern, $width, $height, $radius)
    {
        return $width . '/' .
            $height . 'R' .
            $radius . ' ' .
            $brand . ' ' . $pattern;
    }

    private function generate_code($brand_id)
    {

        $brand_code = sprintf('%02d', $brand_id);
        $model = new Product;
        $model_number = $model->get()->last() == null ? 1 : $model->get()->last()->id + 1;
        $model_code = sprintf('%03d',$model_number);

        return join('', [1, $brand_code, $model_code]);
    }

    private function find_or_create($model, $name, $b = null)
    {
        switch ($model) {
            case 'brand':

                $brand = Brand::where('name', 'like', $name)->first();
                if ($brand == null) {
                    return Brand::create(['name' => ucfirst($name), 'category_id' => 1]);
                } else {
                    return $brand;
                }
                break;
            case 'pattern':
                if ($name != null) {
                    $fix_name = str_replace(' ', '', $name);
                } else {
                    $fix_name = $b->name;
                }
                $pattern = Pattern::where('name', 'like', '%' . $fix_name . '%')->first();
                if ($pattern == null) {
                    return Pattern::create(['name' => $fix_name, 'brand_id' => $b->id]);
                } else {
                    return $pattern;
                }
                break;
        }
    }


}
