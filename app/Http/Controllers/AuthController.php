<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\JsonResponse;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class AuthController extends Controller
{


    /**
     * Redirect the user to the Provider authentication page.
     *
     * @param $provider
     * @return JsonResponse
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->stateless()->scopes(['https://www.googleapis.com/auth/drive', 'https://www.googleapis.com/auth/spreadsheets'])->redirect();
    }

    /**
     * Obtain the user information from Provider.
     *
     * @param $provider
     * @return JsonResponse
     */
    public function handleProviderCallback()
    {
        try {
            $google_user = Socialite::driver('google')->stateless()->user();
        } catch (ClientException $exception) {
            return response()->json(['error' => 'Invalid credentials provided.'], 422);
        }
        $user = User::where('google_id', $google_user->id)->first();

        if($user) {
            $user->update([
                'google_token' => $google_user->token,
                'google_refresh_token' => $google_user->refreshToken,
            ]);
        } else {
            $user = User::create([
                'name' => $google_user->name,
                'email' => $google_user->email,
                'google_id' => $google_user->id,
                'google_token' => $google_user->token,
                'google_refresh_token' => $google_user->refreshToken
            ]);
        }
        $token = $user->createToken('token-name')->plainTextToken;

        return response()->json($user, 200, ['Access-Token' => $token]);
    }
}
