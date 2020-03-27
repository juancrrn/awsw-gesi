<?php

/**
 * Inicialización y métodos de la aplicación.
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

class App
{
	// Nombre de la cookie de sesión.
	const NOMBRE_SESION = "gesi_sesion";

	// Instancia actual de la aplicación.
	private static $instancia;

	// Datos de conexión a la base de datos.
	private $bbdd_datos;

	// Conexión de la instancia a la base de datos.
	private $bbdd_con;

	// Directorio raíz de la instalación.
	private $raiz;

	// URL pública de la instalación.
	private $url;

	/**
	 * Constructor. Al ser privado, asegura que solo habrá
	 * una única instancia de la clase (patrón singleton).
	 */
	private function __construct()
	{
	}

	/**
	 * Evita que se pueda utilizar el operador clone.
	 */
	public function __clone()
	{
		throw new \Exception("Clonar no tiene sentido.");
	}


	/**
	 * Evita que se pueda utilizar serialize().
	 */
	public function __sleep()
	{
		throw new \Exception("Serializar no tiene sentido.");
	}

	/**
	 * Evita que se pueda utilizar unserialize().
	 */
	public function __wakeup()
	{
		throw new \Exception("Deserializar no tiene sentido.");
	}

	/**
	 * Instanciar la aplicación.
	 */
	public static function getSingleton()
	{
		if (! self::$instancia instanceof self) {
			self::$instancia = new self;
		}

		return self::$instancia;
	}

	/**
	 * Inicializar la instancia.
	 */
	public function init($bbdd_datos, $raiz, $url)
	{
		$this->bbdd_datos = $bbdd_datos;

		$this->raiz = $raiz;

		// Añadir barra de directorio final.
		$raiz_len = mb_strlen($raiz);
		if ($raiz_len > 0 && $raiz[$raiz_len - 1] !== "/") {
			$this->raiz .= "/";
		}

		$this->url = $url;

		// Añadir barra de directorio final.
		$url_len = mb_strlen($url);
		if ($url_len > 0 && $raiz[$url_len - 1] !== "/") {
			$this->url .= "/";
		}

		$this->bbdd_con = null;

		session_start();
	}

	/**
	 * Inicia la sesión de un usuario.
	 *
	 * @requires No hay ninguna sesión ya iniciada.
	 */
	public function doLogin(Usuario $user)
	{
		$_SESSION[self::NOMBRE_SESION] = $user->getId();
	}

	/**
	 * Cierra la sesión de un usuario.
	 */
	public function doLogout()
	{
		unset($_SESSION[self::NOMBRE_SESION]);

		session_destroy();

		session_start();
	}

	/**
	 * Devuelve el is del usuario que ha iniciado sesión.
	 *
	 * @requires Un usuario ha iniciado sesión previamente.
	 */
	public function idLogueado()
	{
		return $_SESSION[self::NOMBRE_SESION];
	}

	/**
	 * Inicia una conexión con la base de datos.
	 */
	public function bbddConecta()
	{
		if (! $this->bbdd_con) {
			$host = $this->bbdd_datos["host"];
			$user = $this->bbdd_datos["user"];
			$password = $this->bbdd_datos["password"];
			$name = $this->bbdd_datos["name"];

			$driver = new \mysqli_driver();

			try {
				$this->bbdd_con = new \mysqli($host, $user, $password, $name);
			} catch (\mysqli_sql_exception $e) {
				throw new \Exception("Error al conectar con la base de datos.", 0, $e)
			}

			try {
				$this->bbdd_con->set_charset("utf8mb4");
			} catch (\mysqli_sql_exception $e) {
				throw new \Exception("Error al configurar la codificación de la base de datos.", 1);
			}
		}

		return $this->bbdd_con;
	}
}

?>