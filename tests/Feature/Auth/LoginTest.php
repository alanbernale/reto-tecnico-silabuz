<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('Método de inicio de sesión usuario validado y autenticado', function () {
    // Ejemplo de datos de prueba
    $userForm = [
        'email' => 'test@example.com',
        'password' => 'secret-password',
    ];

    // Datos para login
    $userData = array_merge($userForm, [
        'device_name' => 'test-device'
    ]);

    // Crear un usuario de prueba
    $user = User::factory()->create($userForm);

    // Simular una solicitud POST al método 'login'
    $response = $this->withHeaders(['Accept' => 'application/json'])
        ->post('/api/login', $userData);

    // Verificar que la respuesta sea exitosa (código de respuesta 200)
    $response->assertStatus(200);

    // Verificar que se devuelve un token de autenticación
    $this->assertNotEmpty($response->content());
});

test('Método de inicio de sesión devuelve un error por credenciales no válidas.', function () {
    // Ejemplo de datos de prueba con credenciales incorrectas
    $invalidUserData = [
        'email' => 'test@example.com',
        'password' => 'wrong-password',
        'device_name' => 'test-device',
    ];

    // Simular una solicitud POST al método 'login' con credenciales incorrectas
    $response = $this->withHeaders(['Accept' => 'application/json'])
        ->post('/api/login', $invalidUserData);

    // Verificar que se devuelve un error de validación (código de respuesta 422)
    $response->assertStatus(422);

    // Verificar que el mensaje de error es correcto
    $response->assertJsonValidationErrors(['email']);
});

