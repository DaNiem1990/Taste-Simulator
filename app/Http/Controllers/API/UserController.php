<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\UserRequest\UserStoreRequest;
use App\Http\Requests\UserRequest\UserUpdateRequest;
use App\Http\Resources\UserHidden as UserHiddenResource;
use App\Models\User;
use App\Repositories\Eloquent\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Response;


/**
 * @group Zarządzanie użytkownikami
 *
 * Zarządzanie użytkownikami
 * @package App\Http\Controllers\API
 */
class UserController extends BaseController
{

    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Wyświetla listę userów
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->sendResponse(
            UserResource::collection(
                $this->userRepository->getUsersListByUser(Auth::user())
            ),
            'Pobrano użytkowników.'
        );
    }

    /**
     * Zapisuje nowego użytkownika
     *
     * @param UserStoreRequest $request
     * @return JsonResponse
     */
    public function store(UserStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $user = User::create($validated);

        return $this->sendResponse(
            new UserResource($user),
            'Dodano użytkownika'
        );
    }

    /**
     * Wyświetla info o użytkowniku
     *
     * @param int $user_id
     * @return JsonResponse
     */
    public function show(int $user_id): JsonResponse
    {
        $user = $this->userRepository->getUserByUser(Auth::user(), $user_id);

        if ($user->id > 0) {
            return $this->sendResponse(
                new UserResource($user),
                'Poprawne pobranie użytkownika.'
            );
        }

        return $this->sendError('Brak takiego użytkownika');
    }

    /**
     * Aktualizuje dane o użytkowniku
     *
     * @param UserUpdateRequest $request
     * @param \App\Models\User $user
     * @return JsonResponse
     */
    public function update(UserUpdateRequest $request, User $user): JsonResponse
    {
        $validated = $request->validated();

        $user->name = $validated['name'];
        if ($validated['password'].notNullValue()) {
            $user->name = bcrypt($validated['password']);
        }
        $user->email = $validated['email'];
        $user->remember_token =  $validated['remember_token'];
        $user->isadmin =  $validated['isadmin'];
        $user->only_friends =  $validated['only_friends'];
        $user->is_active =  $validated['is_active'];
        $user->save();

        return $this->sendResponse('not implemented');
    }

    /**
     * Dezaktywuje użytkownika
     *
     * @param int $user_id
     * @return JsonResponse
     */
    public function destroy(int $user_id): JsonResponse
    {
        $user = User::find($user_id);

        if (is_null($user)) {
            return $this->sendError('Brak takiego użytkownika');
        }
        $user->is_active = false;
        $user->save();

        return $this->sendResponse(
            new UserResource($user),
            'Zablokowano użytkownika.'
        );
    }


    /**
     * Przywraca użytkownika
     *
     * @param int $user_id
     * @return JsonResponse
     */
    public function restore(int $user_id): JsonResponse
    {
        $user = User::find($user_id);

        if (is_null($user)) {
            return $this->sendError('Brak takiego użytkownika');
        }
        $user->is_active = true;
        $user->save();

        return $this->sendResponse(
            new UserResource($user),
            'Aktywowano użytkownika.'
        );
    }
}
