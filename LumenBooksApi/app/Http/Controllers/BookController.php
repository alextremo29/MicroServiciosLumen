<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{

    use ApiResponser;

    public function __construct()
    {
        //
    }

    /**
     * Retorna una lista de libros
     * @return Illuminate/Http/Response
     */
    public function index()
    {
        // Retorna toda la lista de autores agregados
        $books = Book::all();

        return $this->successResponse($books);
    }

    /**
     * Almacena un libro dado
     * @return Illuminate/Http/Response
     */
    public function store(Request $request)
    {
        // Reglas de validación para los datos del autor
        $rules = [
            'title'       => 'required|max:255',
            'description' => 'required|max:255',
            'price'       => 'required|min:1',
            'author_id'   => 'required|min:1',
        ];

        // Se valida que las reglas se cumplan aplicandolas al request
        $this->validate($request, $rules);

        // Se crea al autor usando el request dado, en caso de venir mas datos esos son ignorados
        $book = Book::create($request->all());

        return $this->successResponse($book, Response::HTTP_CREATED);

    }

    /**
     * Retorna un libro especifico
     * @return Illuminate/Http/Response
     */
    public function show($book)
    {
        // Se busca el autor con un is dado, si no existe se genera una exepcion
        $book = Book::findOrFail($book);

        return $this->successResponse($book);
    }

    /**
     * Actualiza los datos de un libro especifico
     * @return Illuminate/Http/Response
     */
    public function update(Request $request, $book)
    {
        // Se generan las reglas para validar los datos
        $rules = [
            'title'       => 'max:255',
            'description' => 'max:255',
            'price'       => 'min:1',
            'author_id'   => 'min:1',
        ];

        // Se ejecuta la validación de datos
        $this->validate($request, $rules);

        // Buscar al autor por su llave, en caso de no encontrarse se generar una execpcion
        $book = Book::findOrFail($book);

        // Se asignan los datos del request a los campos del autor, si vienen mas datos son ignorados
        $book->fill($request->all());

        // Validar si hay cambios en el autor
        if ($book->isClean()) {
            return $this->errorResponse('Al menos un valor debe cambiar', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Guardar el autor en la base de datos
        $book->save();

        // Retornar el resultado de la actualización
        return $this->successResponse($book);
    }

    /**
     * Elimina un autor existente
     * @return Illuminate/Http/Response
     */
    public function destroy($book)
    {
        // Buscar al autor por su llave, en caso de no encontrarse se generar una execpcion
        $book = Book::findOrFail($book);

        $book->delete();

        // Retornar el resultado de la actualización
        return $this->successResponse($book);
    }
}
