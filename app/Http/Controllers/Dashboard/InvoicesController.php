<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Product;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class InvoicesController extends Controller
{
    public function index()
    {
        $invoces = Invoice::all();
        return view('dashboard.invoices.index');
    }

    public function create()
    {
        $clients = Client::all();
        $products = Product::all();

        return view('dashboard.invoices.create', compact('clients', 'products'));
    }

    public function add_product(Request $request)
    {
        // return $request->all();
        $product = Product::findOrFail($request->product_id);
        $client = Client::find($request->client);
        $price = $this->cut_ddv($request->price);
        Cart::add(
            $product->code,
            $product->name,
            $request->qty,
            $price,
            ['client' => $request->client]
        );

        $total = Cart::total();
        $subtotal = Cart::subtotal();
        $tax = Cart::tax();
        $all_items = Cart::content();
        return view('dashboard.invoices.partials.invoice_preview')
            ->with([
                'all_items' => $all_items,
                'company' => $client,
                'total' => $total,
                'subtotal' => $subtotal,
                'tax' => $tax
            ])->render();


    }

    private function cut_ddv($price)
    {
        return floatval($price) / ((18 / 100) + 1);
    }

    public function store(Request $request)
    {

        $company = Client::findOrFail($request->company_id);
        $date = date('Y-m-d', strtotime($request->date));
        $invoice_count = Invoice::all()->count() + 1;
//        $year = date('Y');
        $total_without_ddv = floatval(str_replace('.', '', Cart::subtotal()));
        $total_with_ddv = floatval(str_replace('.', '', Cart::total()));

        $invoice = new Invoice;
        $invoice->number = $invoice_count;
        $invoice->total_price = $total_with_ddv;
        $invoice->net_price = $total_without_ddv;
        $invoice->vat = $total_with_ddv - $total_without_ddv;
        $invoice->client_id = $company->id;
        $invoice->date = $date;
        $invoice->save();

        foreach(Cart::content() as $item)
        {
            $product = Product::where('code', $item->id)->first();
//            $product->decrement(['stock' => $item->qty]);
            $invoice->products()->attach([
                $product->id => [
                    'qty' => $item->qty,
                    'single_price' => $item->price
                ]
            ]);
        }

    }

    public function find_product(Request $request)
    {
        return Product::findOrFail($request->product_id)->code;
    }

    public function remove_product(Request $request)
    {
        Cart::remove($request->product);
        $company = Client::findOrFail($request->client);
        $total = Cart::total();
        $subtotal = Cart::subtotal();
        $all_items = Cart::content();
        return view('dashboard.invoices.partials.invoice_preview')
            ->with([
                'all_items' => $all_items,
                'company' => $company,
                'total' => $total,
                'subtotal' => $subtotal,
                'tax' => Cart::tax()
            ])->render();
    }
}
