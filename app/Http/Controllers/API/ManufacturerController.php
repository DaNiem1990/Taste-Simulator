<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\ManufacturerRequest\ManufacturerStoreRequest;
use App\Http\Requests\ManufacturerRequest\ManufacturerUpdateRequest;
use App\Models\Manufacturer;
use Exception;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Manufacturer as ManufacturerResource;

/**
 * @group Producenci
 *
 * Zarządzanie producentami
 */
class ManufacturerController extends BaseController
{
    /**
     * Wyświetla listę producentów.
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
     * Dodaje producenta do listy
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
     * Wyświetla szczegóły wybranego producenta
     *
     * @param int $manufacturerId
     * @return JsonResponse
     */
    public function show(int $manufacturerId): JsonResponse
    {
        $manufacturer = Manufacturer::find($manufacturerId);

        if (is_null($manufacturer)) {
            return $this->sendError('Brak takiego producenta');
        }

        return $this->sendResponse(
            new ManufacturerResource($manufacturer),
            'Poprawne pobranie producenta.'
        );
    }

    /**
     * Aktualizuje wybranego producenta
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
            'Poprawna aktualizacja danych producenta.'
        );
    }

    /**
     * Usuwa wybranego producenta z listy.
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
