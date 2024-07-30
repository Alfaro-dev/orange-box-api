<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Provider;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function importData(Request $request)
    {
        $provider_data = json_decode(file_get_contents(database_path('data/providers.json')), true);

        foreach ($provider_data as $provider) {
            Provider::create($provider);
        }

        $provider_data = json_decode(file_get_contents(database_path('data/products.json')), true);

        foreach ($provider_data as $product) {
            Product::create($product);
        }

        return response()->json(['message' => 'Data imported successfully']);
    }
}
