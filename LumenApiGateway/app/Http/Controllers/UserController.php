<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    use ApiResponser;

    public function __construct()
    {
        //
    }

    /**
     * Retorna una lista de usuarios
     * @return Illuminate/Http/Response
     */
    public function index()
    {
        // Retorna toda la lista de usuarios agregados
        $users = User::all();

        return $this->validResponse($users);
    }

    /**
     * Almacena un usuario dado
     * @return Illuminate/Http/Response
     */
    public function store(Request $request)
    {
        // Reglas de validación para los datos del usuario
        $rules = [
            'name'     => 'required|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ];

        // Se valida que las reglas se cumplan aplicandolas al request
        $this->validate($request, $rules);

        $fields             = $request->all();
        $fields["password"] = Hash::make($request->password);

        // Se crea al usuario usando el request dado, en caso de venir mas datos esos son ignorados
        $user = User::create($fields);

        return $this->validResponse($user, Response::HTTP_CREATED);

    }

    /**
     * Retorna un usuario especifico
     * @return Illuminate/Http/Response
     */
    public function show($user)
    {
        // Se busca el usuario con un is dado, si no existe se genera una exepcion
        $user = User::findOrFail($user);

        return $this->validResponse($user);
    }

    /**
     * Actualiza los datos de un usuario especifico
     * @return Illuminate/Http/Response
     */
    public function update(Request $request, $user)
    {
        // Se generan las reglas para validar los datos
        $rules = [
            'name'  => 'max:255',
            'email' => 'email|unique:users,email,' . $user, // Aplica la regla de unique a todos menos el $usuario que pasa por parametros
            'password' => 'min:8|confirmed',
        ];

        // Se ejecuta la validación de datos
        $this->validate($request, $rules);

        // Buscar al usuario por su llave, en caso de no encontrarse se generar una execpcion
        $user = User::findOrFail($user);

        // Se asignan los datos del request a los campos del usuario, si vienen mas datos son ignorados
        $user->fill($request->all());

        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        // Validar si hay cambios en el usuario
        if ($user->isClean()) {
            return $this->errorResponse('Al menos un valor debe cambiar', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Guardar el usuario en la base de datos
        $user->save();

        // Retornar el resultado de la actualización
        return $this->validResponse($user);
    }

    /**
     * Elimina un usuario existente
     * @return Illuminate/Http/Response
     */
    public function destroy($user)
    {
        // Buscar al usuario por su llave, en caso de no encontrarse se generar una execpcion
        $user = User::findOrFail($user);

        $user->delete();

        // Retornar el resultado de la actualización
        return $this->validResponse($user);
    }

    /**
     * Identificar el usuario actual
     * @return Illuminate/Http/Response
     */
    public function me(Request $request)
    {
        return $this->validResponse($request->user());
    }
}
