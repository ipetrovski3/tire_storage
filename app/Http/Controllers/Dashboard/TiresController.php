<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\TireService;
use Illuminate\Http\Request;

class TiresController extends Controller
{
    public function store($id, Request $request)
    {
        $request->validate([
            'brand' => 'required',
            'pattern' => 'required',
            'width' => 'required',
            'height' => 'required',
            'radius' => 'required',
        ]);
        $tire_service = new TireService($request->all(), $id);
        $tire_service->store_tire();
    }
}
