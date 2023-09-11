<?php
namespace App\Traits;

use Illuminate\Http\Response;

trait ApiResponser
{

    /**
     * Construir una respuesta de exito
     *
     * @param      string|array  $data
     * @param      int  $code
     *
     * @return     Illuminate\Http\Response  (Respuesta correcta del consumo)
     */
    public function successResponse($data, $code = Response::HTTP_OK)
    {

        return response($data, $code)->header('Content-Type', 'application/json');

    }

    /**
     * Construir una respuesta de exito
     *
     * @param      string|array  $data
     * @param      int  $code
     *
     * @return     Illuminate\Http\Response  (Respuesta correcta del consumo)
     */
    public function validResponse($data, $code = Response::HTTP_OK)
    {

        return response()->json([
            'data' => $data,
        ], $code);

    }

    /**
     * Construir un mensaje de error
     *
     * @param      string|array  $data
     * @param      int  $code
     *
     * @return     Illuminate\Http\Response  (Respuesta erronea del consumo)
     */
    public function errorResponse($message, $code)
    {

        return response()->json([
            'error' => $message,
            'code'  => $code,
        ], $code);

    }

    /**
     * Construir un error en formato json
     *
     * @param      string|array  $data
     * @param      int  $code
     *
     * @return     Illuminate\Http\Response  (Respuesta erronea del consumo)
     */
    public function errorMessage($message, $code)
    {

        return response($message, $code)->header('Content-Type', 'application/json');

    }
}
