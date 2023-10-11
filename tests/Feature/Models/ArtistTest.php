<?php

use App\Models\Artist;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('authenticated user can fetch a list of artists', function () {
    // Crear algunos artistas de prueba en la base de datos
    Artist::factory()->count(5)->create();

    // Crear un usuario y autenticarlo
    $user = User::factory()->create();
    $token = $user->createToken('test-token')->plainTextToken;

    // Hacer una solicitud GET a la ruta de la API con el token de autenticación para obtener detalles del artista
    $response = $this->withHeaders(['Accept' => 'application/json'])
        ->get('/api/artists', ['Authorization' => 'Bearer ' . $token]);

    // Verificar que la solicitud fue exitosa (código de respuesta 200)
    $response->assertStatus(200);

    // Verificar que el cuerpo de la respuesta contiene datos de artistas
    $response->assertJsonCount(5, 'data');
});
