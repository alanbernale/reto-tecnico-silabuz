<?php

use App\Models\Album;
use App\Models\Artist;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('Puede obtener una lista de álbumes', function () {
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
