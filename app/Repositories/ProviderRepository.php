<?php

namespace App\Repositories;

use App\Http\Resources\ProviderResource;
use App\Http\Responses\Response;
use App\Interfaces\ProviderRepositoryInterface;
use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderRepository implements ProviderRepositoryInterface
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request) : Response
    {
        $per_page = $request->per_page ?? 10;

        $providers = Provider::paginate($per_page);

        $collection = ProviderResource::collection($providers);

        $pagination =[
            'per_page' => $providers->perPage(),
            'from' => $providers->firstItem(),
            'to' => $providers->lastItem(),
            'total' => $providers->total(),
            'links' => [
                'next_page_url' => $providers->nextPageUrl(),
                'prev_page_url' => $providers->previousPageUrl()
            ]
        ];

        return Response::successWithPagination($collection, $pagination);
    }

    /**
     * Display the specified resource.
     * @param $id
     * @return Response
     */
    public function getById($id): Response
    {
        $provider = Provider::find($id);

        if (is_null($provider)) {
            return Response::notFound('Provider not found');
        }

        $collection = new ProviderResource($provider);

        return Response::success($collection);
    }

    /**
     * Store a newly created resource in storage.
     * @param array $data
     * @return Response
     */
    public function store(array $data) : Response
    {
        $provider = Provider::create($data);

        $collection = new ProviderResource($provider);

        return Response::success($collection);
    }

    /**
     * Update the specified resource in storage.
     * @param array $data
     * @param $id
     * @return Response
     */
    public function update(array $data, $id): Response
    {
        $provider = Provider::find($id);

        if (is_null($provider)) {
            return Response::notFound('Provider not found');
        }

        $provider->update($data);

        $collection = new ProviderResource($provider);

        return Response::success($collection);
    }

    /**
     * Remove the specified resource from storage.
     * @param $id
     * @return Response
     */
    public function delete($id): Response
    {
        $provider = Provider::find($id);

        if (is_null($provider)) {
            return Response::notFound('Provider not found');
        }

        $provider->delete();

        return Response::success('Provider deleted successfully');
    }
}
