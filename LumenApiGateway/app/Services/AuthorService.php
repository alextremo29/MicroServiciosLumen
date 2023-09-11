<?php
namespace App\Services;

use App\Traits\ConsumesExternalService;

/**
 *
 */
class AuthorService
{
    use ConsumesExternalService;

    // URL base para realizar el consumo del servicio de autores
    public $baseUri;

    // Clave de autorización para el consumo de los servicios de autores
    public $secret;
    function __construct()
    {
        $this->baseUri = config('services.authors.base_uri');
        $this->secret  = config('services.authors.secret');
    }

    /**
     * Traer el listado de autores desde el micro servicio de autores
     */
    public function obtainAuthors()
    {
        return $this->performRequest('GET', '/authors');
    }

    /**
     * Crea una nueva instancia de un autor en usando el micro servicio de autores
     *
     * @param      Request  $data   Datos de la petición, que contiene la información del autor
     *
     * @return     string  Retorna la respuesta del servicio de autores, que corresponde a la instancia creada
     */
    public function createAuthor($data)
    {
        return $this->performRequest('POST', '/authors', $data);
    }

    /**
     * Obtiene un autor especifico desde el servicio de autores
     *
     * @param      integer  $author  Id del autor que se quiere obtener
     *
     * @return     string Retorna la respuesta del servicio de autores, que corresponde a la instancia consultada
     */
    public function obtainAuthor($author)
    {
        return $this->performRequest('GET', "/authors/{$author}");
    }

    /**
     * actualiza un autor especifico desde el servicio de autores
     *
     * @param      integer  $author  Id del autor que se quiere obtener
     *
     * @return     string Retorna la respuesta del servicio de autores, que corresponde a la instancia consultada
     */
    public function editAuthor($data, $author)
    {
        return $this->performRequest('PUT', "/authors/{$author}", $data);
    }

    /**
     * Obtiene un autor especifico desde el servicio de autores
     *
     * @param      integer  $author  Id del autor que se quiere obtener
     *
     * @return     string Retorna la respuesta del servicio de autores, que corresponde a la instancia consultada
     */
    public function deleteAuthor($author)
    {
        return $this->performRequest('DELETE', "/authors/{$author}");
    }
}
