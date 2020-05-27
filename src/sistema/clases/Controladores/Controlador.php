<?php

/**
 * Controla las peticiones HTTP. Modelo front controller.
 *
 * @package awsw-gesi
 * Gesi
 * Aplicación de gestión de institutos de educación secundaria
 *
 * @author Andrés Ramiro Ramiro
 * @author Cintia María Herrera Arenas
 * @author Nicolás Pardina Popp
 * @author Pablo Román Morer Olmos
 * @author Juan Francisco Carrión Molina
 *
 * @version 0.0.4
 */

namespace Awsw\Gesi\Controladores;

abstract class Controlador
{

    private static $base = '';

    /**
     * @var bool $lastFound   Permite que al llegar a una ruta válida, se dejen 
     *                        de procesar el resto.
     * @var bool $lastEnabled Indica si hay que parar cuando se ha encontrado 
     *                        una ruta válida.
     */
    private static $lastFound = false;
    private static $lastEnabled = true;

    /**
     * Procesa una petición sin importar el método (GET, POST, etc.).
     * 
     * @param string $route
     * @param callable $handler
     * @param bool|null $last
     */
    public static function any(string $route, callable $handler, $last = null) : void
    {
        if (! self::$lastEnabled && ! self::$lastFound) {
            self::processRequest($route, $handler, $last);
        }
    }

    /**
     * Procesa una petición GET.
     * 
     * @param string $route
     * @param callable $handler
     * @param bool|null $last
     */
    public static function get(string $route, callable $handler, $last = null) : void
    {
        if (! self::$lastEnabled && ! self::$lastFound && $_SERVER['REQUEST_METHOD'] == 'GET') {
            self::processRequest($route, $handler, $last);
        }
    }

    /**
     * Procesa una petición POST.
     * 
     * @param string $route
     * @param callable $handler
     * @param bool|null $last
     */
    public static function post(string $route, callable $handler, $last = null) : void
    {
        if (! self::$lastEnabled && ! self::$lastFound && $_SERVER['REQUEST_METHOD'] == 'POST') {
            self::processRequest($route, $handler, $last);
        }
    }

    /**
     * Procesa una petición PATCH.
     * 
     * @param string $route
     * @param callable $handler
     * @param bool|null $last
     */
    public static function patch(string $route, callable $handler, $last = null) : void
    {
        if (! self::$lastEnabled && ! self::$lastFound && $_SERVER['REQUEST_METHOD'] == 'PATCH') {
            self::processRequest($route, $handler, $last);
        }
    }

    /**
     * Procesa una petición DELETE.
     * 
     * @param string $route
     * @param callable $handler
     * @param bool|null $last
     */
    public static function delete(string $route, callable $handler, $last = null) : void
    {
        if (! self::$lastEnabled && ! self::$lastFound && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
            self::processRequest($route, $handler, $last);
        }
    }

    /**
     * Procesa una petición en general.
     * 
     * @param string $route
     * @param callable $handler
     * @param bool|null $last   Indica si, una vez procesada esta petición, se
     *                          debe terminar la ejecución y no buscar en el
     *                          resto de las reglas.
     */
    public static function processRequest(string $route, callable $handler, $last = null) : void
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

            if ($last === true) {
                die();
            } else {
                self::$lastFound = true;
            }
        }
    }

    /**
     * Establece la base de la URL.
     */
    public static function setGetBase(string $base) : void
    {
        self::$base = $base;
    }

    /**
     * Establece si se debe parar al encontrar una entrada válida a verdadero.
     */
    public static function enableLast() : void
    {
        self::$lastEnabled = true;
    }

    /**
     * Establece si se debe parar al encontrar una entrada válida a falso.
     */
    public static function disableLast() : void
    {
        self::$lastEnabled = false;
    }

    /**
     * Se ejecuta cuando no se ha ejecutado ningún controlador anteriormente.
     */
    public static function default(callable $handler) : void
    {

        if (! self::$lastEnabled && ! self::$lastFound) {
            http_response_code(404);

            echo call_user_func($handler);
        }

    }

    /**
     * Lanza varios controladores de puntos de entrada.
     */
    abstract public static function controla() : void;
}

?>