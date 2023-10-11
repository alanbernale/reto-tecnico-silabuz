<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('login method validates and authenticates user', function () {
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

    // Simular una solicitud HTTP POST al método 'login'
    $response = $this->withHeaders(['Accept' => 'application/json'])
        ->post('/api/login', $userData);

    // Verificar que la respuesta sea exitosa (código 200)
    $response->assertStatus(200);

    // Verificar que se devuelve un token de autenticación
    $this->assertNotEmpty($response->content());
});

it('login method returns error for invalid credentials', function () {
    // Ejemplo de datos de prueba con credenciales incorrectas
    $invalidUserData = [
        'email' => 'test@example.com',
        'password' => 'wrong-password',
        'device_name' => 'test-device',
    ];

    // Simular una solicitud HTTP POST al método 'login' con credenciales incorrectas
    $response = $this->withHeaders(['Accept' => 'application/json'])
        ->post('/api/login', $invalidUserData);

    // Verificar que se devuelve un error de validación
    $response->assertStatus(422);

    // Verificar que el mensaje de error es correcto
    $response->assertJsonValidationErrors(['email']);
});

