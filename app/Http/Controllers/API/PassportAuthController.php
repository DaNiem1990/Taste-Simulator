<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\User;

/**
 * @group Użytkownicy
 * @package App\Http\Controllers\API
 */
class PassportAuthController extends Controller
{
    /**
     * Rejestracja nowego użytkownika
     *
     * @bodyParam name string required Nazwa użytkownika (min. 4 znaki)
     * @bodyParam email string required Email użytkownika
     * @bodyParam password string required Hasło użytkownika (min. 8 znaków)
     * @response token string Token umożliwiający dostęp do zasobów wymagających logowania
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken('Laravel8PassportAuth')->accessToken;

        return response()->json(['token' => $token], 200);
    }

    /**
     * Logowanie
     *
     * @bodyParam email string required Email użytkownika
     * @bodyParam password string required Hasło użytkownika
     * @response token string Token umożliwiający dostęp do zasobów wymagających logowania
     */
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('Laravel8PassportAuth')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    /**
     * Informacje o użytkowniku
     *
     * @response UserInfo object Informacje o aktualnie zalogowanym użytkowniku
     */
    public function userInfo()
    {

        $user = auth()->user();

        return response()->json(['user' => $user], 200);

    }
}
