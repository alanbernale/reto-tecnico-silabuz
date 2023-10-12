<?php

namespace App\Http\Controllers;

use App\Models\Track;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Tag(
 *      name="Tracks",
 *      description="Operaciones relacionadas con las pistas."
 * )
 */
class TrackController extends Controller
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
     *     path="/api/tracks",
     *     summary="Obtener todos las pistas",
     *     tags={"Tracks"},
     *     operationId="trackIndex",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de psitas",
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(ref="#/definitions/Artist")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        // Obtener todos los registros de pistas
        $track = Track::all();

        // Devolver una respuesta JSON con la lista de pistas
        return response()->json(['data' => $track], Response::HTTP_OK);
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
     *     path="/api/tracks/{id}",
     *     summary="Obtener los detalles de una pista",
     *     tags={"Tracks"},
     *     operationId="trackShow",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la pista a consultar",
     *         required=true,
     *         @OA\Schema(type="uuid"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles de la pista",
     *         @OA\Schema(ref="#/definitions/Artist")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pista no encontrada"
     *     )
     * )
     */
    public function show(Track $track): JsonResponse
    {
        // Devolver una respuesta JSON con los detalles de la pista
        return response()->json(['data' => $track], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Track $track)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Track $track)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Track $track)
    {
        //
    }
}
