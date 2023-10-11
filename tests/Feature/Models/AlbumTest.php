<?php

use App\Models\Album;
use App\Models\Artist;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('authenticated user can fetch a list of albums', function () {
    // Crear algunos álbumes de prueba en la base de datos
    Artist::factory()->count(5)->create();
    Album::factory()->count(5)->create();

    // Crear un usuario y autenticarlo
    $user = User::factory()->create();
    $token = $user->createToken('test-token')->plainTextToken;

    // Hacer una solicitud GET a la ruta de la API con el token de autenticación para obtener detalles del álbum
    $response = $this->withHeaders(['Accept' => 'application/json'])
        ->get('/api/albums', ['Authorization' => 'Bearer ' . $token]);

    // Verificar que la solicitud fue exitosa (código de respuesta 200)
    $response->assertStatus(200);

    // Verificar que el cuerpo de la respuesta contiene datos de álbumes
    $response->assertJsonCount(5, 'data');
});

it(' authenticated user can fetch details of a single album', function () {
    // Crear un álbum de prueba en la base de datos
    Artist::factory()->create();
    $album = Album::factory()->create();

    // Crear un usuario y autenticarlo
    $user = User::factory()->create();
    $token = $user->createToken('test-token')->plainTextToken;

    // Hacer una solicitud GET a la ruta de la API con el token de autenticación para obtener detalles del álbum
    $response = $this->getJson("api/albums/{$album->id}", ['Authorization' => 'Bearer ' . $token]);

    // Verificar que la solicitud fue exitosa (código de respuesta 200)
    $response->assertStatus(200);

    // Verificar que el cuerpo de la respuesta contiene datos del álbum
    $response->assertJson(['data' => $album->toArray()]);
});

it('returns a 404 response when trying to fetch details of a non-existing album', function () {
    // Crear un usuario y autenticarlo
    $user = User::factory()->create();
    $token = $user->createToken('test-token')->plainTextToken;

    // Intentar una solicitud GET a la ruta de la API con el token de autenticación para obtener detalles de un album que no existe en la base de datos
    $response = $this->getJson('/api/albums/999', ['Authorization' => 'Bearer ' . $token]);

    // Verificar que la solicitud devuelva un código de respuesta 404
    $response->assertStatus(404);
});
