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
 * @version 0.0.2
 */

namespace Awsw\Gesi\Controladores;

abstract class Controlador
{

	private static $base = '';

	/**
	 * Permite que al llegar a una ruta válida, se dejen de procesar el resto.
	 */
	private static $last = false;

	/**
	 * Procesa una petición sin importar el método (GET, POST, etc.)
	 */
	public static function go(string $route, callable $handler) : void
	{

		if (! self::$last) {
			self::processRequest($route, $handler);
		}

	}

	/**
	 * Procesa una petición GET
	 */
	public static function get(string $route, callable $handler) : void
	{

		if (! self::$last && $_SERVER['REQUEST_METHOD'] == 'GET') {
			self::processRequest($route, $handler);
		}

	}

	/**
	 * Procesa una petición POST
	 */
	public static function post(string $route, callable $handler) : void
	{

		if (! self::$last && $_SERVER['REQUEST_METHOD'] == 'POST') {
			self::processRequest($route, $handler);
		}

	}

	/**
	 * Procesa una petición en general
	 */
	public static function processRequest(string $route, callable $handler) : void
	{
		/**
		 * # al principio y al final son delimitadores de la expresión regular.
		 *
		 * ^ y $ son metacaracteres de expresiones regulares que se utilizan como
		 * anclas de inicio y fin, respectivamente.
		 */

		if (preg_match('#^' . self::$base . $route . '$#', $_SERVER['REQUEST_URI'], $matches) == 1) {
			array_shift($matches);
			echo call_user_func_array($handler, $matches);

			self::$last = true;
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
	 * Se ejecuta cuando no se ha ejecutado ningún controlador anteriormente.
	 */
	public static function default(callable $handler) : void
	{

		if (! self::$last) {
			echo call_user_func($handler);
		}

	}

	/**
	 * Lanza varios controladores de puntos de entrada.
	 */
	abstract public static function controla() : void;

}