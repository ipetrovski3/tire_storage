<?php

namespace App\Queries;

use App\Models\Product;

class TireQuery
{
    public function set_season($id)
    {
        return Product::whereHas('pattern', function ($q) use ($id) {
            $q->where('season_id', $id);
        });
    }
}
