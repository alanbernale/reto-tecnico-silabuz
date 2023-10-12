<?php

use App\Models\Album;
use App\Models\Artist;
use App\Models\Track;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('search method returns correct results', function () {
    // Crear algunos datos de prueba en la base de datos
    $artist = Artist::factory()->create(['name' => 'Test Artist']);
    $album = Album::factory()->create(['title' => 'Test Album']);
    $track = Track::factory()->create(['title' => 'Test Track', 'artist_id' => $artist->id, 'album_id' => $album->id]);

    // Crear un usuario y autenticarlo
    $user = User::factory()->create();
    $token = $user->createToken('test-token')->plainTextToken;

    // Simular una solicitud HTTP POST al método '__invoke' con un término de búsqueda
    $response = $this->withHeaders(['Accept' => 'application/json'])
        ->get('/api/search?q=Test', ['Authorization' => 'Bearer ' . $token]);

    // Verificar que la respuesta sea exitosa (código 200)
    $response->assertStatus(200);

    // Verificar que la respuesta contiene los resultados correctos
    $response->assertJson(['data' => [
        [
            'title' => 'Test Track',
            'artist' => ['name' => 'Test Artist'],
            'album' => ['title' => 'Test Album'],
        ],
    ]]);
});
