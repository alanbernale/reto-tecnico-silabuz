<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Tag(
 *      name="Artists",
 *      description="Operaciones relacionadas con los artistas."
 * )
 */
class ArtistController extends Controller
{
    /**
     * Constructor del controlador
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Mostrar una lista del recurso.
     *
     * @OA\Get(
     *     path="/api/artists",
     *     summary="Obtener todos los artistas",
     *     tags={"Artists"},
     *     operationId="artistIndex",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de artistas",
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(ref="#/definitions/Artist")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        // Obtener todos los registros de artistas
        $artists = Artist::all();

        // Devolver una respuesta JSON con la lista de artistas
        return response()->json(['data' => $artists], Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Muestra el recurso especificado.
     *
     * @OA\Get(
     *     path="/api/artists/{id}",
     *     summary="Obtener los detalles de un artista",
     *     tags={"Artists"},
     *     operationId="artistShow",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del artista a consultar",
     *         required=true,
     *         @OA\Schema(type="uuid"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles del artista",
     *         @OA\Schema(ref="#/definitions/Artist")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Artista no encontrado"
     *     )
     * )
     */
    public function show(Artist $artist): JsonResponse
    {
        // Devolver una respuesta JSON con los detalles del artista
        return response()->json(['data' => $artist], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Artist $artist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Artist $artist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artist $artist)
    {
        //
    }
}
