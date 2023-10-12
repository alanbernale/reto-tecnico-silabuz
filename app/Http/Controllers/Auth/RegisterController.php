<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

/**
 * @OA\Tag(
 *      name="Authentication",
 *      description="Operaciones relacionadas con la autenticación."
 *  )
 */
class RegisterController extends Controller
{
    /**
     * Método para el manejo de registro de usuarios. Devuelve un Token de acceso.
     *
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
    public function register(RegisterRequest $request)
    {
        // Obtener los datos de entrada validados
        $validated = $request->validated();

        // Se crea un nuevo usuario con los datos de entrada
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'country' => $validated['country'],
        ]);

        // Se lanza un evento de nuevo usuario registrado
        event(new Registered($user));

        // Se retorna el token de acceso etiquetado con el nombre del dispositivo
        return $user->createToken($validated['device_name'])->plainTextToken;
    }
}
