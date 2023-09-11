<?php
namespace App\Http\Controllers;

use App\Services\AuthorService;
use App\Services\BookService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{
    use ApiResponser;

    // Servicio que se usa para consumir el servicio de libros
    public $bookService;

    // Servicio que se usa para consumir el servicio de autores
    public $authorService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BookService $bookService, AuthorService $authorService)
    {
        $this->bookService   = $bookService;
        $this->authorService = $authorService;
    }

    /**
     * Retorna una lista de libros
     * @return Illuminate/Http/Response
     */
    public function index()
    {
        return $this->successResponse($this->bookService->obtainBooks());
    }

    /**
     * Almacena un libro dado
     * @return Illuminate/Http/Response
     */
    public function store(Request $request)
    {
        // Se consume el servicio de autores, si este falla se genera una exepción lo que detiene todo el proceso
        $this->authorService->obtainAuthor($request->author_id);

        return $this->successResponse($this->bookService->createBook($request->all()), Response::HTTP_CREATED);
    }

    /**
     * Retorna un libro especifico
     * @return Illuminate/Http/Response
     */
    public function show($book)
    {
        return $this->successResponse($this->bookService->obtainBook($book));
    }

    /**
     * Actualiza los datos de un libro especifico
     * @return Illuminate/Http/Response
     */
    public function update(Request $request, $book)
    {
        return $this->successResponse($this->bookService->editBook($request->all(), $book));
    }

    /**
     * Elimina un autor existente
     * @return Illuminate/Http/Response
     */
    public function destroy($book)
    {
        return $this->successResponse($this->bookService->deleteBook($book));
    }
}
