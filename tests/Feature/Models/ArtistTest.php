<?php

use App\Models\Artist;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('El usuario autenticado puede obtener una lista de artistas.', function () {
    // Crear algunos artistas de prueba en la base de datos
    Artist::factory()->count(5)->create();

    // Crear un usuario y autenticarlo
    $user = User::factory()->create();
    $token = $user->createToken('test-token')->plainTextToken;

    // Hacer una solicitud GET a la ruta de la API con el token de autenticación para obtener los artistas
    $response = $this->withHeaders(['Accept' => 'application/json'])
        ->get('/api/artists', ['Authorization' => 'Bearer ' . $token]);

    // Verificar que la solicitud fue exitosa (código de respuesta 200)
    $response->assertStatus(200);

    // Verificar que el cuerpo de la respuesta contiene artistas
    $response->assertJsonCount(5, 'data');
});

test('El usuario autenticado puede obtener detalles de un solo artista.', function () {
    // Crear un artista de prueba en la base de datos
    $artist = Artist::factory()->create();

    // Crear un usuario y autenticarlo
    $user = User::factory()->create();
    $token = $user->createToken('test-token')->plainTextToken;

    // Hacer una solicitud GET a la ruta de la API con el token de autenticación para obtener el artista
    $response = $this->withHeaders(['Accept' => 'application/json'])
        ->get("api/artists/{$artist->id}", ['Authorization' => 'Bearer ' . $token]);

    // Verificar que la solicitud fue exitosa (código de respuesta 200)
    $response->assertStatus(200);

    // Verificar que el cuerpo de la respuesta contiene el artista
    $response->assertJson(['data' => $artist->toArray()]);
});

test('Devuelve una respuesta 404 al intentar obtener detalles de un artista no existente', function () {
    // Crear un usuario y autenticarlo
    $user = User::factory()->create();
    $token = $user->createToken('test-token')->plainTextToken;

    // Intentar una solicitud GET a la ruta de la API con el token de autenticación para un artista que no existe
    $response = $this->withHeaders(['Accept' => 'application/json'])
        ->get('/api/artists/999', ['Authorization' => 'Bearer ' . $token]);

    // Verificar que la solicitud devuelva un código de respuesta 404
    $response->assertStatus(404);
});
