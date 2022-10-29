<?php

namespace App\Services;

use App\Models\Brand;
use App\Models\pattern;
use App\Models\Product;

class TireService
{
    private $request;
    private $cat_id;

    public function __construct($request, $cat_id)
    {
        $this->request = (object) $request;
        $this->cat_id = $cat_id;
    }

    public function store_tire()
    {
        $tire = new Product;
        $tire->name = $this->set_name();
        $tire->category_id = $this->cat_id;
        $tire->retail_price = $this->request->price ?? 0;
        $tire->location = $this->set_location();
        $tire->brand_id = $this->request->brand;
        $tire->pattern_id = $this->request->pattern;
        $tire->code = $this->generate_code($tire);
        $tire->save();
    }

    private function set_location()
    {
        $location_elements = [$this->request->width, $this->request->height, $this->request->radius];
        return join('', $location_elements);
    }

    private function set_name()
    {
        $brand = Brand::find($this->request->brand)->name;
        $pattern = Pattern::find($this->request->pattern)->name;
        return $this->request->width . '/' .
            $this->request->height . 'R' .
            $this->request->radius . ' ' .
            $brand . ' ' . $pattern;
    }

    private function generate_code($model)
    {
        $brand_code = sprintf('%02d', $this->request->brand);
        $model_number = $model->get()->last() == null ? 1 : $model->get()->last()->id + 1;
        $model_code = sprintf('%03d',$model_number);

        return join('', [$this->cat_id, $brand_code, $model_code]);
    }
}
