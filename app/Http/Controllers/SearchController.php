<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\Track;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Tag(
 *      name="Search",
 *      description="Operaciones relacionadas con la búsqueda."
 *  )
 */
class SearchController extends Controller
{
    /**
     * Constructor del controlador
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Método para el manejo de la búsqueda de pistas. Devuelve una colección de pistas.
     *
     * @param SearchRequest $request
     * @return JsonResponse
     *
     * @OA\Get(
     *      path="/api/search",
     *      summary="Buscar pistas por nombre, nombre de artistas y nombre de álbumes",
     *      tags={"Search"},
     *      operationId="searchInvoke",
     *      @OA\Parameter(
     *          name="q",
     *          in="query",
     *          description="Término de búsqueda",
     *          required=true,
     *          @OA\Schema(type="string"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Búsqueda exitosa",
     *          @OA\Schema(
     *              type="array",
     *              @OA\Items(ref="#/definitions/Track")
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Error de validación",
     *          @OA\Schema(
     *              type="object",
     *              @OA\Property(property="message", type="string"),
     *              @OA\Property(property="errors", type="object"),
     *          )
     *      )
     *  )
     */
    public function __invoke(SearchRequest $request): JsonResponse
    {
        // Obtener el campo "q" validado
        $validated = $request->validated();

        // Obtener el término de búsqueda desde la solicitud
        $searchTerm = $validated['q'];

        // Realizar la consulta de búsqueda en el modelo Track, relacionando Artist y Album
        $results = Track::where('title', 'LIKE', '%' . $searchTerm . '%')
            ->orWhereHas('artist', function ($query) use ($searchTerm) {
                $query->where('name', 'LIKE', '%' . $searchTerm . '%');
            })
            ->orWhereHas('album', function ($query) use ($searchTerm) {
                $query->where('title', 'LIKE', '%' . $searchTerm . '%');
            })
            ->get();

        // Devolver una respuesta JSON con la lista de pistas
        return response()->json(['data' => $results], Response::HTTP_OK);
    }
}
