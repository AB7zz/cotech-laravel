<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class productController extends Controller
{
    private $filePath = 'app/data/products.json';

    public function index()
    {
        $products = $this->readData();
        $sumTotalValue = array_reduce($products, function ($carry, $product) {
            return $carry + $product['totalValueNumber'];
        }, 0);

        return view('coalition.index', compact('products', 'sumTotalValue'));
    }

    public function store(Request $request){
        $request->validate([
            'product_name' => 'required|string',
        ]);

        $products = $this->readData();

        $newProduct = [
            'id' => uniqid(),
            'productName' => $request->product_name,
            'quantityInStock' => $request->quantity_in_stock,
            'pricePerItem' => $request->price_per_item,
            'dateTimeSubmitted' => now()->toDateTimeString(),
            'totalValueNumber' => $request->quantity_in_stock * $request->price_per_iterm,
        ];

        $products[] = $newProduct;

        $this->writeData($products);

        return response()->json(['success' => true, 'products' => $products, 'sumTotalValue' => array_sum(array_column($products, 'totalValueNumber'))]);
    }

    public function edit($id){
        $products = $this->readData();
        $product = collect($products)->firstWhere('id', $id);
        if(!$product){
            return redirect()->route('coalition.index')->withErrors(['Product not found.']);
        }

        return view('coalition.edit', compact('product'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'product_name' => 'required|string',
            'quantity_in_stock' => 'required|integer',
            'price_per_item' => 'required|numeric',
        ]);

        $products = $this->readData();
        $productIndex = collect($products)->search(function($product) use ($id){
            return $product['id'] == $id;
        });

        if($productIndex == false){
            return redirect()->route('coalition.index')->withErrors(['Product not found.']);
        }

        $products[$productIndex]['productName'] = $request->product_name;
        $products[$productIndex]['quantityInStock'] = $request->quantity_in_stock;
        $products[$productIndex]['pricePerItem'] = $request->price_per_item;
        $products[$productIndex]['totalValueNumber'] = $request->quantity_in_stock * $request->price_per_item;
        
        $this->writeData($products);

        return redirect()->route('coalition.index')->with('success', 'Product updated successfully.');
    }

    private function readData()
    {
        $path = storage_path($this->filePath);
        if (!File::exists($path)) {
            return [];
        }

        $data = File::get($path);
        return json_decode($data, true);
    }

    private function writeData($data){
        $path = storage_path($this->filePath);
        File::put($path, json_encode($data, JSON_PRETTY_PRINT));
    }
}
