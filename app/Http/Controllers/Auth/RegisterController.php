<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

/**
 * @OA\Tag(
 *      name="Authentication",
 *      description="Operaciones relacionadas con la autenticación."
 *  )
 */
class RegisterController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Registro de usuario",
     *     tags={"Authentication"},
     *     operationId="register",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Nombre del usuario",
     *         required=true,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="Dirección de correo electrónico del usuario",
     *         required=true,
     *         @OA\Schema(type="email"),
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="Contraseña del usuario",
     *         required=true,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         name="password_confirmation",
     *         in="query",
     *         description="Confirmación de contraseña",
     *         required=true,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         name="country",
     *         in="query",
     *         description="País del usuario",
     *         required=true,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Parameter(
     *         name="device_name",
     *         in="query",
     *         description="Nombre del dispositivo",
     *         required=true,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Registro exitoso",
     *         @OA\Schema(type="string", description="Token de acceso")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\Schema(
     *             type="object",
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="errors", type="object"),
     *         )
     *     )
     * )
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'country' => ['required', 'string', 'max:64'],
            'device_name' => ['required', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'country' => $request->country,
        ]);

        event(new Registered($user));

        return $user->createToken($request->device_name)->plainTextToken;
    }
}
