<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('Método de cierre de sesión revoca el token de usuario actual.', function () {
    // Ejemplo de datos de prueba
    $userData = [
        'email' => 'test@example.com',
        'password' => 'secret-password',
    ];

    // Crear un usuario de prueba
    $user = User::factory()->create($userData);

    // Autenticar al usuario y obtener un token de acceso
    $token = $user->createToken('test-device')->plainTextToken;

    // Simular una solicitud POST al método 'logout' con el token de acceso
    $response = $this
        ->withHeaders(['Accept' => 'application/json'])
        ->post('/api/logout', [], ['Authorization' => "Bearer $token"]);

    // Verificar que la respuesta sea exitosa (código de respuesta 200)
    $response->assertStatus(200);

    // Verificar que el token se ha revocado
    $this->assertEmpty($user->tokens);
});
