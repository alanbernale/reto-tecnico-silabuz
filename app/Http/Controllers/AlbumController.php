<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Tag(
 *      name="Albums",
 *      description="Operaciones relacionadas con los álbumes."
 * )
 */
class AlbumController extends Controller
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
     *     path="/api/albums",
     *     summary="Obtener todos los álbumes",
     *     tags={"Albums"},
     *     operationId="albumIndex",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de álbumes",
     *         @OA\Schema(
     *             type="array",
     *             @OA\Items(ref="#/definitions/Album")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        // Obtener todos los registros de álbumes
        $albums = Album::all();

        // Devolver una respuesta JSON con la lista de álbumes
        return response()->json(['data' => $albums], Response::HTTP_OK);
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
     *     path="/api/albums/{id}",
     *     summary="Obtener los detalles de un álbum",
     *     tags={"Albums"},
     *     operationId="albumShow",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del álbum a consultar",
     *         required=true,
     *         @OA\Schema(type="uuid"),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles del álbum",
     *         @OA\Schema(ref="#/definitions/Album")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Álbum no encontrado"
     *     )
     * )
     */
    public function show(Album $album): JsonResponse
    {
        // Devolver una respuesta JSON con los detalles del álbum
        return response()->json(['data' => $album], Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Album $album)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Album $album)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Album $album)
    {
        //
    }
}
