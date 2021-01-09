<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\ProductRequest\ProductStoreRequest;
use App\Http\Requests\ProductRequest\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Exception;
use Illuminate\Http\JsonResponse;


/**
 * @group Produkty
 *
 * Class ProductController
 * @package App\Http\Controllers\API
 */
class ProductController extends BaseController
{
    /**
     * Wyświetla listę wszystkich produktów
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $manufacturers = Product::all();
        return $this->sendResponse(
            ProductResource::collection($manufacturers),
            'Poprawne pobranie producentów.'
        );
    }

    /**
     * Dodawanie nowego produktu
     *
     * @param ProductStoreRequest $request
     * @return JsonResponse
     */
    public function store(ProductStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $product = Product::create($validated);

        return $this->sendResponse(
            new ProductResource($product),
            'Utworzono produkt.'
        );
    }

    /**
     * Wyświetlanie szczegółów wybranego produktu.
     *
     * @param int $productId
     * @return JsonResponse
     */
    public function show(int $productId): JsonResponse
    {
        $product = Product::find($productId);

        if (is_null($product)) {
            return $this->sendError('Brak takiego produktu');
        }

        return $this->sendResponse(
            new ProductResource($product),
            'Poprawne pobranie produktu.'
        );
    }

    /**
     * Modyfikacja produktu
     *
     * @param ProductUpdateRequest $request
     * @param Product $product
     * @return JsonResponse
     */
    public function update(ProductUpdateRequest $request, Product $product): JsonResponse
    {
        $validated = $request->validated();

        $product->name = $validated['name'];
        $product->save();

        return $this->sendResponse(
            new ProductResource($product),
            'Poprawne pobranie produktu.'
        );
    }

    /**
     * Usunięcie produktu
     *
     * @param Product $product
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Product $product):JsonResponse
    {
        $product->delete();

        return $this->sendResponse([], 'Produkt usunięty poprawnie');
    }
}
