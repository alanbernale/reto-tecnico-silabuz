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

it('authenticated user can fetch details of a single artist', function () {
    // Crear un artista de prueba en la base de datos
    $artist = Artist::factory()->create();

    // Crear un usuario y autenticarlo
    $user = User::factory()->create();
    $token = $user->createToken('test-token')->plainTextToken;

    // Hacer una solicitud GET a la ruta de la API con el token de autenticación para obtener detalles del artista
    $response = $this->withHeaders(['Accept' => 'application/json'])
        ->get("api/artists/{$artist->id}", ['Authorization' => 'Bearer ' . $token]);

    // Verificar que la solicitud fue exitosa (código de respuesta 200)
    $response->assertStatus(200);

    // Verificar que el cuerpo de la respuesta contiene datos del artista
    $response->assertJson(['data' => $artist->toArray()]);
});

it('returns a 404 response when trying to fetch details of a non-existing artist', function () {
    // Crear un usuario y autenticarlo
    $user = User::factory()->create();
    $token = $user->createToken('test-token')->plainTextToken;

    // Intentar una solicitud GET a la ruta de la API con el token de autenticación para obtener detalles de un artista que no existe en la base de datos
    $response = $this->withHeaders(['Accept' => 'application/json'])
        ->get('/api/artists/999', ['Authorization' => 'Bearer ' . $token]);

    // Verificar que la solicitud devuelva un código de respuesta 404
    $response->assertStatus(404);
});
