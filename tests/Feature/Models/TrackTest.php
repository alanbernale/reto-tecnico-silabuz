<?php

use App\Models\Album;
use App\Models\Artist;
use App\Models\Track;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('El usuario autenticado puede obtener una lista de pistas.', function () {
    // Crear algunos artistas, álbumes y pistas de prueba en la base de datos
    Artist::factory()->count(5)->create();
    Album::factory()->count(5)->create();
    Track::factory()->count(5)->create();

    // Crear un usuario y autenticarlo
    $user = User::factory()->create();
    $token = $user->createToken('test-token')->plainTextToken;

    // Hacer una solicitud GET a la ruta de la API con el token de autenticación para obtener las pistas
    $response = $this->withHeaders(['Accept' => 'application/json'])
        ->get('/api/tracks', ['Authorization' => 'Bearer ' . $token]);

    // Verificar que la solicitud fue exitosa (código de respuesta 200)
    $response->assertStatus(200);

    // Verificar que el cuerpo de la respuesta contiene pistas
    $response->assertJsonCount(5, 'data');
});

test('El usuario autenticado puede obtener detalles de una sola pista', function () {
    // Crear un artista, album y track de prueba en la base de datos
    Artist::factory()->create();
    Album::factory()->create();
    $track = Track::factory()->create();

    // Crear un usuario y autenticarlo
    $user = User::factory()->create();
    $token = $user->createToken('test-token')->plainTextToken;

    // Hacer una solicitud GET a la ruta de la API con el token de autenticación para obtener la pista
    $response = $this->withHeaders(['Accept' => 'application/json'])
        ->get("api/tracks/{$track->id}", ['Authorization' => 'Bearer ' . $token]);

    // Verificar que la solicitud fue exitosa (código de respuesta 200)
    $response->assertStatus(200);

    // Verificar que el cuerpo de la respuesta contiene la pista
    $response->assertJson(['data' => $track->toArray()]);
});

test('Devuelve una respuesta 404 al intentar recuperar detalles de una pista no existente', function () {
    // Crear un usuario y autenticarlo
    $user = User::factory()->create();
    $token = $user->createToken('test-token')->plainTextToken;

    // Hacer una solicitud GET a la ruta de la API con el token de autenticación para una pista que no existe
    $response = $this->withHeaders(['Accept' => 'application/json'])
        ->get('/api/tracks/999', ['Authorization' => 'Bearer ' . $token]);

    // Verificar que la solicitud devuelva un código de respuesta 404
    $response->assertStatus(404);
});
