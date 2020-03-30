<?php 

/**
 * Métodos relacionados con las vistas y la generación de contenido visible 
 * para el usuario en el navegador.
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

namespace Awsw\Gesi;

class Vista
{
	// Título de la página actual.
	private static $pagina_actual_nombre;

	// Id de la página actual.
	private static $pagina_actual_id;

	private const DIRECTORIO_COMUN = __DIR__ . "/../comun/";

	/**
	 * Establece el nombre y el id de la página actual.
	 * 
	 * @param string $nombre Nombre de la página actual.
	 * @param string $id Identificador de la página actual.
	 */
	public static function setPaginaActual(string $nombre, string $id) : void
	{
		self::$pagina_actual_nombre = $nombre;
		self::$pagina_actual_id = $id;
	}

	/**
	 * Devuelve el nombre de la página actual.
	 * 
	 * @return string Nombre de la página actual.
	 */
	public static function getPaginaActualNombre() : string
	{
		return self::$pagina_actual_nombre;
	}

	/**
	 * Incluye la cabecera HTML.
	 */
	public static function incluirCabecera() : void
	{
		require_once self::DIRECTORIO_COMUN . "cabecera.php";
	}

	/**
	 * Incluye el pie HTML.
	 */
	public static function incluirPie() : void
	{
		require_once self::DIRECTORIO_COMUN . "pie.php";
	}
}