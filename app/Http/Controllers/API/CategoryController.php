<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CategoryRequest\CategoryStoreRequest;
use App\Http\Requests\CategoryRequest\CategoryUpdateRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Category as CategoryResource;


/**
 * @group Kategorie
 *
 * Zarządzanie kategoriami
 */
class CategoryController extends BaseController
{
    /**
     * Wyświetla listę dostępnych kategorii
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $categories = Category::all();
        return $this->sendResponse(
            CategoryResource::collection($categories),
            'Poprawne pobranie kategorii.'
        );
    }

    /**
     * Dodaje nową kategorię degustacji do listy.
     *
     * @param CategoryStoreRequest $request
     * @return JsonResponse
     */
    public function store(CategoryStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $category = Category::create($validated);

        return $this->sendResponse(
            new CategoryResource($category),
            'Utworzono kategorię.'
        );
    }

    /**
     * Wyświetla wybraną kategorię
     *
     * @param int $categoryId
     * @return JsonResponse
     */
    public function show(int $categoryId): JsonResponse
    {
        $category = Category::find($categoryId);
        if (!is_null($category)) {
            return $this->sendResponse(
                new CategoryResource($category),
                'Poprawne pobranie kategorii.'
            );
        }
        return $this->sendError('Brak takiej kategorii');

    }

    /**
     * Aktualizuje wybraną kategorię.
     *
     * @param CategoryUpdateRequest $request
     * @param Category $category
     * @return JsonResponse
     */
    public function update(CategoryUpdateRequest $request, Category $category): JsonResponse
    {
        $validated = $request->validated();

        $category->name = $validated['name'];
        $category->save();

        return $this->sendResponse(
            new CategoryResource($category),
            'Poprawne pobranie kategorii.'
        );
    }

    /**
     * Usuwa wybraną kategorię z listy.
     *
     * @param Category $category
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Category $category):JsonResponse
    {
        $category->delete();

        return $this->sendResponse([], 'Kategoria usunięta poprawnie');
    }
}
