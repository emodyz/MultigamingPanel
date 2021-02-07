<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;

class LoginController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function __invoke(Request $request)
    {
        $request->validate([
          'email' => 'required|email',
          'password' => 'required',
          'device_name' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
              'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        if ($user->two_factor_secret) {
            if (!$request->has(['two_factor_code', 'two_factor_recovery_code'])) {
                return response()->json([
                  'message' => 'Two Factor authentication required.',
                ], Response::HTTP_I_AM_A_TEAPOT);
            }

            $recoveryCode = $request->get('two_factor_recovery_code');
            $code = $request->get('two_factor_code');

            if ($recoveryCode && $this->isValidRecoveryCode($user, $request->get('two_factor_recovery_code'))) {
                $user->replaceRecoveryCode($recoveryCode);
            } else if (!$code || !$this->isValidCode($user, $code)) {
                throw ValidationException::withMessages([
                  'two_factor' => ['The provided two factor are incorrect.'],
                ]);
            }
        }

        $token = $user->createToken($request->device_name);

        return response()->json([
          'access_token' => Str::after($token->plainTextToken, '|'),
          'user' => UserResource::make($user)
        ]);
    }

    /**
     * Check if the recovery code is valid.
     *
     * @param  User  $user
     * @param  string  $recoveryCode
     * @return string|null
     */
    public function isValidRecoveryCode(User $user, string $recoveryCode): ?string
    {
        return collect($user->recoveryCodes())
          ->first(fn($code) => hash_equals($recoveryCode, $code) ? $code : null);
    }

    /**
     * Check if the two factor code is valid.
     *
     * @param  User  $user
     * @param  string  $code
     * @return bool
     */
    public function isValidCode(User $user, string $code): bool
    {
        return app(TwoFactorAuthenticationProvider::class)
          ->verify(decrypt($user->two_factor_secret), $code);
    }
}
