<?php
namespace App\Http\Controllers;

use App\Services\AuthorService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Controls the data flow into an author object and updates the view whenever data changes.
 */
class AuthorController extends Controller
{
    use ApiResponser;

    // Servicio que se usa para consumir el servicio de autores
    public $authorService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    /**
     * Retorna una lista de autores
     * @return Illuminate/Http/Response
     */
    public function index()
    {
        return $this->successResponse($this->authorService->obtainAuthors());
    }

    /**
     * Almacena un author dado
     * @return Illuminate/Http/Response
     */
    public function store(Request $request)
    {
        return $this->successResponse($this->authorService->createAuthor($request->all()), Response::HTTP_CREATED);
    }

    /**
     * Retorna un actor especifico
     * @return Illuminate/Http/Response
     */
    public function show($author)
    {
        return $this->successResponse($this->authorService->obtainAuthor($author));
    }

    /**
     * Actualiza los datos de un actor especifico
     * @return Illuminate/Http/Response
     */
    public function update(Request $request, $author)
    {
        return $this->successResponse($this->authorService->editAuthor($request->all(), $author));
    }

    /**
     * Elimina un autor existente
     * @return Illuminate/Http/Response
     */
    public function destroy($author)
    {
        return $this->successResponse($this->authorService->deleteAuthor($author));
    }
}
