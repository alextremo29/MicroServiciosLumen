<?php
namespace App\Http\Controllers;

use App\Models\Author;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorController extends Controller
{

    use ApiResponser;

    public function __construct()
    {
        //
    }

    /**
     * Retorna una lista de autores
     * @return Illuminate/Http/Response
     */
    public function index()
    {

        // Retorna toda la lista de autores agregados
        $authors = Author::all();

        return $this->successResponse($authors);
    }

    /**
     * Almacena un author dado
     * @return Illuminate/Http/Response
     */
    public function store(Request $request)
    {
        // Reglas de validación para los datos del autor
        $rules = [
            'name'    => 'required|max:255',
            'gender'  => 'required|max:255|in:male,female',
            'country' => 'required|max:255',
        ];

        // Se valida que las reglas se cumplan aplicandolas al request
        $this->validate($request, $rules);

        // Se crea al autor usando el request dado, en caso de venir mas datos esos son ignorados
        $author = Author::create($request->all());

        return $this->successResponse($author, Response::HTTP_CREATED);
    }

    /**
     * Retorna un actor especifico
     * @return Illuminate/Http/Response
     */
    public function show($author)
    {
        // Se busca el autor con un is dado, si no existe se genera una exepcion
        $author = Author::findOrFail($author);

        return $this->successResponse($author);
    }

    /**
     * Actualiza los datos de un actor especifico
     * @return Illuminate/Http/Response
     */
    public function update(Request $request, $author)
    {
        // Se generan las reglas para validar los datos
        $rules = [
            'name'    => 'max:255',
            'gender'  => 'max:255|in:male,female',
            'country' => 'max:255',
        ];

        // Se ejecuta la validación de datos
        $this->validate($request, $rules);

        // Buscar al autor por su llave, en caso de no encontrarse se generar una execpcion
        $author = Author::findOrFail($author);

        // Se asignan los datos del request a los campos del autor, si vienen mas datos son ignorados
        $author->fill($request->all());

        // Validar si hay cambios en el autor
        if ($author->isClean()) {
            return $this->errorResponse('Al menos un valor debe cambiar', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Guardar el autor en la base de datos
        $author->save();

        // Retornar el resultado de la actualización
        return $this->successResponse($author);

    }

    /**
     * Elimina un autor existente
     * @return Illuminate/Http/Response
     */
    public function destroy($author)
    {
        // Buscar al autor por su llave, en caso de no encontrarse se generar una execpcion
        $author = Author::findOrFail($author);

        $author->delete();

        // Retornar el resultado de la actualización
        return $this->successResponse($author);

    }
}
