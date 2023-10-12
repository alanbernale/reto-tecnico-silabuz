<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\Track;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(SearchRequest $request)
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
