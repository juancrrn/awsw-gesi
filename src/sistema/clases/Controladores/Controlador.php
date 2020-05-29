<?php

/**
 * Controla las peticiones HTTP. Modelo front controller.
 *
 * @package awsw-gesi
 * Gesi
 * Aplicación de gestión de institutos de educación secundaria
 *
 * @author Andrés Ramiro Ramiro
 * @author Nicolás Pardina Popp
 * @author Pablo Román Morer Olmos
 * @author Juan Francisco Carrión Molina
 *
 * @version 0.0.4-beta.01
 */

namespace Awsw\Gesi\Controladores;

abstract class Controlador
{

    private static $base = '';

    /**
     * Procesa una petición sin importar el método (GET, POST, etc.).
     * 
     * @param string $route
     * @param callable $handler
     * @param bool|null $last
     */
    public static function any(string $route, callable $handler): void
    {
        self::processRequest($route, $handler);
    }

    /**
     * Procesa una petición GET.
     * 
     * @param string $route
     * @param callable $handler
     */
    public static function get(string $route, callable $handler): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            self::processRequest($route, $handler);
        }
    }

    /**
     * Procesa una petición POST.
     * 
     * @param string $route
     * @param callable $handler
     */
    public static function post(string $route, callable $handler): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            self::processRequest($route, $handler);
        }
    }

    /**
     * Procesa una petición PATCH.
     * 
     * @param string $route
     * @param callable $handler
     */
    public static function patch(string $route, callable $handler): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
            self::processRequest($route, $handler);
        }
    }

    /**
     * Procesa una petición DELETE.
     * 
     * @param string $route
     * @param callable $handler
     */
    public static function delete(string $route, callable $handler): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            self::processRequest($route, $handler);
        }
    }

    /**
     * Procesa una petición en general.
     * 
     * @param string $route
     * @param callable $handler
     */
    public static function processRequest(string $route, callable $handler): void
    {
        /**
         * # al principio y al final son delimitadores de la expresión regular.
         *
         * ^ y $ son metacaracteres de expresiones regulares que se utilizan como
         * anclas de inicio y fin, respectivamente.
         */

        $getParamsRegEx = '(\?.*)?';
        
        if (preg_match('#^' . self::$base . $route . $getParamsRegEx . '$#', $_SERVER['REQUEST_URI'], $matches) == 1) {
            array_shift($matches);
            echo call_user_func_array($handler, $matches);

            die();
        }
    }

    /**
     * Establece la base de la URL.
     */
    public static function setGetBase(string $base): void
    {
        self::$base = $base;
    }

    /**
     * Se ejecuta cuando no se ha ejecutado ningún controlador anteriormente.
     */
    public static function default(callable $handler): void
    {
        http_response_code(404);
        
        echo call_user_func($handler);
    }

    /**
     * Lanza varios controladores de puntos de entrada.
     */
    abstract public static function controla(): void;
}

?>