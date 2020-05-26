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

	// Base del front controller.
	private $base_controlador;

	// Contraseña por defecto para los usuarios creados.
	private $default_password;

	// Indica si la aplicación esá en modo desarrollo.
	private $es_desarrollo;

	/**
	 * Constructor. Al ser privado, asegura que solo habrá una única instancia * de la clase (patrón singleton).
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
	public function init($bbdd_datos, $raiz, $url, $base_controlador, $default_password, $es_desarrollo)
	{
		$this->bbdd_datos = $bbdd_datos;
		$this->raiz = $raiz;
		$this->url = $url;
		$this->base_controlador = $base_controlador;
		$this->default_password = $default_password;
		$this->es_desarrollo = $es_desarrollo;
		$this->bbdd_con = null;

		session_start();

		// Inicializar gestión de la sesión de usuario.
		Sesion::init();
	}

	/**
	 * Inicia una conexión con la base de datos.
	 */
	public function bbddCon() : \mysqli
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
				throw new \Exception("Error al conectar con la base de datos.", 0, $e);
			}

			try {
				$this->bbdd_con->set_charset("utf8mb4");
			} catch (\mysqli_sql_exception $e) {
				throw new \Exception("Error al configurar la codificación de la base de datos.", 1);
			}
		}

		return $this->bbdd_con;
	}

	/**
	 * Directorio raíz de la instalación.
	 */
	public function getRaiz() : string
	{
		return $this->raiz;
	}

	/**
	 * URL pública de la instalación.
	 */
	public function getUrl() : string
	{
		return $this->url;
	}

	/**
	 * Base del front controller.
	 */
	public function getBaseControlador() : string
	{
		return $this->base_controlador;
	}

	/**
	 * Contraseña por defecto.
	 */
	public function getDefaultPassword() : string
	{
		return $this->default_password;
	}

	/**
	 * Indica si la app está en modo desarrollo.
	 * 
	 * Esto sirve para cachés de CSS, etc.
	 */
	public function isDesarrollo() : bool
	{
		return $this->es_desarrollo;
	}

}

?>
