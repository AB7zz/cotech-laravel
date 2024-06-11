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

    private function readData()
    {
        $path = storage_path($this->filePath);
        if (!File::exists($path)) {
            return [];
        }

        $data = File::get($path);
        return json_decode($data, true);
    }
}
