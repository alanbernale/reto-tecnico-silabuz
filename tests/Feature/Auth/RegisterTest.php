<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('register method creates a new user and returns an access token', function () {
    // Ejemplo de datos de prueba para el registro
    $userData = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'secret-password',
        'password_confirmation' => 'secret-password',
        'country' => 'Test Country',
        'device_name' => 'test-device',
    ];

    // Simular una solicitud HTTP POST al método 'register' con los datos de registro
    $response = $this->withHeaders(['Accept' => 'application/json'])
        ->post('/api/register', $userData);

    // Verificar que la respuesta sea exitosa (código 200)
    $response->assertStatus(200);

    // Verificar que se devuelve un token de acceso
    $this->assertNotEmpty($response->content());

    // Verificar que el usuario se ha creado en la base de datos
    $this->assertDatabaseHas('users', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'country' => 'Test Country',
    ]);
});
