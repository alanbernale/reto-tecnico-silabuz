<?php

use App\Models\Album;
use App\Models\Artist;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('El usuario autenticado puede obtener una lista de álbumes.', function () {
    // Crear algunos artistas y álbumes de prueba en la base de datos
    Artist::factory()->count(5)->create();
    Album::factory()->count(5)->create();

    // Crear un usuario y autenticarlo
    $user = User::factory()->create();
    $token = $user->createToken('test-token')->plainTextToken;

    // Hacer una solicitud GET a la ruta de la API con el token de autenticación para obtener los álbumes
    $response = $this->withHeaders(['Accept' => 'application/json'])
        ->get('/api/albums', ['Authorization' => 'Bearer ' . $token]);

    // Verificar que la solicitud fue exitosa (código de respuesta 200)
    $response->assertStatus(200);

    // Verificar que el cuerpo de la respuesta contiene álbumes
    $response->assertJsonCount(5, 'data');
});

test('El usuario autenticado puede obtener detalles de un solo álbum', function () {
    // Crear un artista y álbum de prueba en la base de datos
    Artist::factory()->create();
    $album = Album::factory()->create();

    // Crear un usuario y autenticarlo
    $user = User::factory()->create();
    $token = $user->createToken('test-token')->plainTextToken;

    // Hacer una solicitud GET a la ruta de la API con el token de autenticación para obtener el álbum
    $response = $this->withHeaders(['Accept' => 'application/json'])
        ->get("api/albums/{$album->id}", ['Authorization' => 'Bearer ' . $token]);

    // Verificar que la solicitud fue exitosa (código de respuesta 200)
    $response->assertStatus(200);

    // Verificar que el cuerpo de la respuesta contiene el álbum
    $response->assertJson(['data' => $album->toArray()]);
});

test('Devuelve una respuesta 404 al intentar recuperar detalles de un álbum que no existe', function () {
    // Crear un usuario y autenticarlo
    $user = User::factory()->create();
    $token = $user->createToken('test-token')->plainTextToken;

    // Hacer una solicitud GET a la ruta de la API con el token de autenticación para un álbum que no existe
    $response = $this->withHeaders(['Accept' => 'application/json'])
        ->get('/api/albums/999', ['Authorization' => 'Bearer ' . $token]);

    // Verificar que la solicitud devuelva un código de respuesta 404
    $response->assertStatus(404);
});
