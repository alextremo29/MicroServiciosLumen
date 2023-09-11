<?php
namespace App\Services;

use App\Traits\ConsumesExternalService;

/**
 *
 */
class BookService
{
    use ConsumesExternalService;

    // URL base para realizar el consumo del servicio de libros
    public $baseUri;

    // Clave de autorización para el consumo de los servicios de autores
    public $secret;
    function __construct()
    {
        $this->baseUri = config('services.books.base_uri');
        $this->secret  = config('services.books.secret');
    }

    /**
     * Traer el listado de libros desde el micro servicio de libros
     */
    public function obtainBooks()
    {
        return $this->performRequest('GET', '/books');
    }

    /**
     * Crea una nueva instancia de un libro en usando el micro servicio de libros
     *
     * @param      Request  $data   Datos de la petición, que contiene la información del libro
     *
     * @return     string  Retorna la respuesta del servicio de libros, que corresponde a la instancia creada
     */
    public function createBook($data)
    {
        return $this->performRequest('POST', '/books', $data);
    }

    /**
     * Obtiene un libro especifico desde el servicio de libros
     *
     * @param      integer  $book  Id del libro que se quiere obtener
     *
     * @return     string Retorna la respuesta del servicio de libros, que corresponde a la instancia consultada
     */
    public function obtainBook($book)
    {
        return $this->performRequest('GET', "/books/{$book}");
    }

    /**
     * actualiza un libro especifico desde el servicio de libros
     *
     * @param      integer  $book  Id del libro que se quiere obtener
     *
     * @return     string Retorna la respuesta del servicio de libros, que corresponde a la instancia consultada
     */
    public function editBook($data, $book)
    {
        return $this->performRequest('PUT', "/books/{$book}", $data);
    }

    /**
     * Obtiene un libro especifico desde el servicio de libros
     *
     * @param      integer  $book  Id del libro que se quiere obtener
     *
     * @return     string Retorna la respuesta del servicio de libros, que corresponde a la instancia consultada
     */
    public function deleteBook($book)
    {
        return $this->performRequest('DELETE', "/books/{$book}");
    }
}
