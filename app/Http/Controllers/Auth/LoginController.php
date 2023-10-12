<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Info(
 *     title="API Deezer Clone",
 *     version="1.0",
 *     description="API Deezer Clone para prueba técnica de Silabuz.",
 *     @OA\Contact(name="Alan Bernal E.")
 * )
 *
 * @OA\Server(
 *     url="https://reto-tecnico-silabuz.test/",
 *     description="API server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     in="header",
 *     name="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 * )
 *
 * @OA\Tag(
 *      name="Authentication",
 *      description="Operaciones relacionadas con la autenticación."
 * )
 */
class LoginController extends Controller
{
    /**
     * Constructor del controlador
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['logout']);
    }

    /**
     * Método para el manejo de inicio de sesión. Devuelve un Token de acceso.
     *
     * @OA\Post(
     *     path="/api/login",
     *     summary="Autenticación de usuarios",
     *     tags={"Authentication"},
     *     operationId="login",
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
     *         name="device_name",
     *         in="query",
     *         description="Nombre del dispositivo",
     *         required=true,
     *         @OA\Schema(type="string"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Inicio de sesión exitoso",
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
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciales incorrectas",
     *         @OA\Schema(
     *             type="object",
     *             @OA\Property(property="message", type="string"),
     *         )
     *     )
     * )
     */
    public function login(LoginRequest $request)
    {
        // Obtener los datos de entrada validados
        $validated = $request->validated();

        // Buscar el usuario relacionado con el email proporcionado
        $user = User::where('email', $validated['email'])->first();

        // Si no existe usuario con el email proporcionado o la contraseña es incorrecta se lanza un error de validación
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Se retorna el token de acceso etiquetado con el nombre del dispositivo
        return $user->createToken($validated['device_name'])->plainTextToken;
    }

    /**
     * Método para el cierre de sesión. Elimina el token de acceso.
     *
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Desautenticación de usuarios",
     *     tags={"Authentication"},
     *     operationId="logout",
     *     @OA\Response(
     *         response=200,
     *         description="Sesión cerrada exitosamente",
     *         @OA\Schema(
     *             type="object",
     *             @OA\Property(property="token", type="string", description="El token fue eliminado.")
     *         )
     *     )
     * )
     */
    public function logout(Request $request)
    {
        // Se elimina el token de acceso de la solicitud
        $request->user()->currentAccessToken()->delete();

        // Se retorna una respuesta en formato JSON
        return response()->json([
            'token' => 'The token was removed.'
        ], Response::HTTP_OK);
    }
}
