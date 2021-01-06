<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\ManufacturerRequest\ManufacturerStoreRequest;
use App\Models\Manufacturer;
use Exception;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Manufacturer as ManufacturerResource;
use App\Http\Requests\ManufacturerRequest\ManufacturerUpdateRequest;

class ManufacturerController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $manufacturers = Manufacturer::all();
        return $this->sendResponse(
            ManufacturerResource::collection($manufacturers),
            'Poprawne pobranie producentów.'
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ManufacturerStoreRequest $request
     * @return JsonResponse
     */
    public function store(ManufacturerStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $manufacturer = Manufacturer::create($validated);

        return $this->sendResponse(
          new ManufacturerResource($manufacturer),
          'Utworzono producenta.'
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Manufacturer $manufacturer
     * @return JsonResponse
     */
    public function show(Manufacturer $manufacturer): JsonResponse
    {
        if (is_null($manufacturer)) {
            return $this->sendError('Brak takiego producenta');
        }

        return $this->sendResponse(
            new ManufacturerResource($manufacturer),
            'Poprawne pobranie producenta.'
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ManufacturerUpdateRequest $request
     * @param Manufacturer $manufacturer
     * @return JsonResponse
     */
    public function update(ManufacturerUpdateRequest $request, Manufacturer $manufacturer): JsonResponse
    {
        $validated = $request->validated();

        $manufacturer->name = $validated['name'];
        $manufacturer->save();

        return $this->sendResponse(
            new ManufacturerResource($manufacturer),
            'Poprawne pobranie producenta.'
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Manufacturer $manufacturer
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Manufacturer $manufacturer):JsonResponse
    {
        $manufacturer->delete();

        return $this->sendResponse([], 'Producent usunięty poprawnie');
    }
}
