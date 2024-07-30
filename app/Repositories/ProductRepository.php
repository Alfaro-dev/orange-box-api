<?php

namespace App\Repositories;

use App\Http\Resources\ProductResource;
use App\Http\Responses\Response;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request) : Response
    {
        $per_page = $request->per_page ?? 10;

        $products = Product::with('provider')->paginate($per_page);

        $collection = ProductResource::collection($products);

        $pagination =[
            'per_page' => $products->perPage(),
            'from' => $products->firstItem(),
            'to' => $products->lastItem(),
            'total' => $products->total(),
            'links' => [
                'next_page_url' => $products->nextPageUrl(),
                'prev_page_url' => $products->previousPageUrl()
            ]
        ];

        return Response::successWithPagination($collection, $pagination);
    }

    /**
     * Store a newly created resource in storage.
     * @param array $data
     * @return Response
     */
    public function store(array $data) : Response
    {
        $product = Product::create($data);

        $collection = new ProductResource($product);

        return Response::success($collection);
    }

    /**
     * Display the specified resource.
     * @param $id
     * @return Response
     */
    public function getById($id): Response
    {
        $product = Product::find($id);

        if (is_null($product)) {
            return Response::notFound('Product not found');
        }

        $collection = new ProductResource($product);

        return Response::success($collection);
    }

    /**
     * Update the specified resource in storage.
     * @param array $data
     * @param $id
     * @return Response
     */
    public function update(array $data, $id) : Response
    {
        $product = Product::find($id);

        if (is_null($product)) {
            return Response::notFound('Product not found');
        }

        $product->update($data);

        $collection = new ProductResource($product);

        return Response::success($collection);
    }

    /**
     * Remove the specified resource from storage.
     * @param $id
     * @return Response
     */
    public function delete($id) : Response
    {
        $product = Product::find($id);

        if (is_null($product)) {
            return Response::notFound('Product not found');
        }

        $product->delete();

        return Response::success();
    }
}
