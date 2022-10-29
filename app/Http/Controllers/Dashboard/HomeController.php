<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Imports\BrandImport;
use App\Imports\StockImport;
use App\Models\Product;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function stock()
    {
        $products = Product::all();
        return view('dashboard.stock', compact('products'));
    }

    public function import_stock(Request $request)
    {
        Excel::import(new BrandImport, $request->stock);
        Excel::import(new StockImport, $request->stock);

        return redirect()->back();
    }

    public function search(Request $request)
    {
        $products = Product::where('location', $request->location)->get();
        return view('dashboard.partials._stock_table')->with(['products' => $products])->render();
        // return $request->all();
    }
}
