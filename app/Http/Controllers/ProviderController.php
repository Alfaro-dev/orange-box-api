<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProviderRequest;
use App\Http\Requests\UpdateProviderRequest;
use App\Interfaces\ProviderRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    protected $providerRepository;

    public function __construct(ProviderRepositoryInterface $providerRepository)
    {
        $this->providerRepository = $providerRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : JsonResponse
    {
        $providers = $this->providerRepository->index($request);

        return $providers->getJsonResponse();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProviderRequest $request)
    {
        $provider = $this->providerRepository->store($request->all());

        return $provider->getJsonResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $provider = $this->providerRepository->getById($id);

        return $provider->getJsonResponse();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProviderRequest $request, string $id)
    {
        $provider = $this->providerRepository->update($request->all(), $id);

        return $provider->getJsonResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $provider = $this->providerRepository->delete($id);

        return $provider->getJsonResponse();
    }
}
