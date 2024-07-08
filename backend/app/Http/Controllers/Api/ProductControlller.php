<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductControlller extends Controller
{
    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function getData(Request $request)
    {
        $key = $request->get('key_search');
        $data = Product::select(['id', 'brand', 'model', 'screen_size', 'color', 'harddisk', 'cpu', 'ram', 'OS', 'special_features', 'graphics', 'graphics_coprocessor', 'cpu_speed', 'rating', 'price']);
        
        if ($key != null ) {
            $data = $data->where('brand', 'like', '%'. $key .'%')
                        ->orWhere('model', 'like', '%'. $key .'%');
        }

        $data = $data->paginate(20);
        // response with json
        return response()->json(['response_code' => '00', 'description' => 'Data Products', 'data' => $data]);
    }
}
