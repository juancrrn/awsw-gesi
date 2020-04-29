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

namespace Awsw\Gesi\Vistas;

use Awsw\Gesi\App;

class Vista
{
	// Título de la página actual.
	private static $pagina_actual_nombre;

	// Id de la página actual.
	private static $pagina_actual_id;

	// Directorio donde se encuentran los ficheros comunes.
	private const DIRECTORIO_COMUN = __DIR__ . "/../../comun/";

	// Valor de $_SESSION donde se almacenan los mensajes.
	private const SESSION_MENSAJES = "gesi_mensajes";

	/**
	 * Establece el nombre y el id de la página actual.
	 * 
	 * @param string $nombre Nombre de la página actual.
	 * @param string $id Identificador de la página actual.
	 */
	private static function setPaginaActual(string $nombre, string $id) : void
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
	 * Devuelve el id de la página actual.
	 * 
	 * @return string Id de la página actual.
	 */
	public static function getPaginaActualId() : string
	{
		return self::$pagina_actual_id;
	}

	/**
	 * Incluye la cabecera HTML.
	 */
	private static function incluirCabecera() : void
	{
		require_once self::DIRECTORIO_COMUN . "cabecera.php";
	}

	/**
	 * Incluye el pie HTML.
	 */
	private static function incluirPie() : void
	{
		require_once self::DIRECTORIO_COMUN . "pie.php";
	}

	/**
	 * 
	 * Mensajes para el usuario.
	 * 
	 */

	/**
	 * Añade un mensaje de error a la cola de mensajes para el usuario.
	 * 
	 * @param string $message Mensaje a mostrar al usuario.
	 * @param string $header_location Opcional para redirigir al mismo tiempo 
	 * que se encola el mensaje.
	 */
	public static function encolaMensajeError(string $mensaje, string $header_location = null) : void
	{
		$_SESSION[self::SESSION_MENSAJES][] = array(
			"tipo" => "error",
			"contenido" => $mensaje
		);

		if ($header_location !== null) {
			header("Location: " . App::getSingleton()->getUrl() . $header_location);
			die();
		}
	}

	/**
	 * Añade un mensaje de éxito a la cola de mensajes para el usuario.
	 * 
	 * @param string $message Mensaje a mostrar al usuario.
	 * @param string $header_location Opcional para redirigir al mismo tiempo 
	 * que se encola el mensaje.
	 */
	public static function encolaMensajeExito(string $mensaje, string $header_location = null) : void
	{
		$_SESSION[self::SESSION_MENSAJES][] = array(
			"tipo" => "exito",
			"contenido" => $mensaje
		);

		if ($header_location !== null) {
			header("Location: " . App::getSingleton()->getUrl() . $header_location);
			die();
		}
	}

	/**
	 * Imprime todos los mensajes de la cola de mensajes.
	 */
	public static function imprimeMensajes() : void
	{
		if (! empty($_SESSION[self::SESSION_MENSAJES])) {
			echo '<div class="wrapper"><div id="mensajes" class="container">';

			foreach ($_SESSION[self::SESSION_MENSAJES] as $clave => $mensaje) {
				echo '<div class="mensaje ' . $mensaje["tipo"] . '"><p>' . $mensaje["contenido"] . '</p></div>';

				// Eliminar mensaje de la cola tras mostrarlo.
				unset($_SESSION[self::SESSION_MENSAJES][$clave]);
			}

			echo '</div></div>';
		}
	}

	/**
	 * Comprueba si hay algún mensaje de error en la cola de mensajes.
	 */
	public static function hayMensajesError() : bool
	{
		if (! empty($_SESSION[self::SESSION_MENSAJES])) {
			foreach ($_SESSION[self::SESSION_MENSAJES] as $mensaje) {
				if ($mensaje["tipo"] == "error") {
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * Dibuja una vista completa.
	 */
	public static function dibuja(Modelo $vista) : void
	{
		$vista->procesaAntesDeLaCabecera();

		self::setPaginaActual($vista->getNombre(), $vista->getId());
		
		self::incluirCabecera();

		self::imprimeMensajes();

		$vista->procesa();

		self::incluirPie();
	}
}