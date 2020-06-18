<?php 

namespace Awsw\Gesi;

use DateTime;

/**
 * Inicialización y métodos de la aplicación.
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
 * @version 0.0.4
 */

class App
{
    
    /**
     * @var string Instancia actual de la aplicación.
     */
    private static $instancia;

    /**
     * @var array $bbdd_datos              Datos de conexión a la base de datos.
     * @var string $bbdd_con               Conexión de la instancia a la base 
     *                                     de datos.
     * @var string $raiz                   Directorio raíz de la instalación.
     * @var string $url                    URL pública de la instalación.
     * @var string $nombre                 Nombre de la aplicación.
     * @var string $base_controlador       Base del front controller.
     * @var string $default_password       Contraseña por defecto para los 
     *                                     usuarios creados.
     * @var string $scheduleTimeStartLimit Límite de hora de inicio de los 
     *                                     horarios.
     * @var string $scheduleTimeEndLimit   Límite de hora de fom de los 
     *                                     horarios.
     * @var string $scheduleDayValid       Días válidos para los horarios.
     * @var bool $es_desarrollo            Indica si la aplicación esá en modo 
     *                                     desarrollo.
     */
    private $bbdd_datos;
    private $bbdd_con;
    private $raiz;
    private $url;
    private $nombre;
    private $base_controlador;
    private $default_password;
    private $scheduleTimeStartLimit;
    private $scheduleTimeEndLimit;
    private $scheduleDayValid;
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
    public function init(
        array $bbdd_datos,
        string $raiz,
        string $url,
        string $nombre,
        string $base_controlador,
        string $default_password,
        string $scheduleTimeStartLimit,
        string $scheduleTimeEndLimit,
        string $scheduleDayValid,
        bool $es_desarrollo)
    {
        $this->bbdd_con = null;

        $this->bbdd_datos = $bbdd_datos;
        $this->raiz = $raiz;
        $this->url = $url;
        $this->nombre = $nombre;
        $this->base_controlador = $base_controlador;
        $this->default_password = $default_password;
        $this->scheduleTimeStartLimit = $scheduleTimeStartLimit;
        $this->scheduleTimeEndLimit = $scheduleTimeEndLimit;
        $this->scheduleDayValid = $scheduleDayValid;
        $this->es_desarrollo = $es_desarrollo;

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

    /*
     *
     * Getters de las propiedades de la instancia.
     * 
     */

    public function getRaiz(): string
    {
        return $this->raiz;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getBaseControlador(): string
    {
        return $this->base_controlador;
    }

    public function getDefaultPassword(): string
    {
        return $this->default_password;
    }

    public function isDesarrollo(): bool
    {
        return $this->es_desarrollo;
    }

    public function getScheduleTimeStartLimit(): string
    {
        return $this->scheduleTimeStartLimit;
    }

    public function getScheduleTimeStartLimitMinutos(): int
    {
        $date = DateTime::createFromFormat('H:i', $this->scheduleTimeStartLimit);

        return $date->format('H') * 60 + $date->format('i');
    }

    public function getScheduleTimeEndLimit(): string
    {
        return $this->scheduleTimeEndLimit;
    }

    public function getScheduleTimeEndLimitMinutos(): int
    {
        $date = DateTime::createFromFormat('H:i', $this->scheduleTimeEndLimit);

        return $date->format('H') * 60 + $date->format('i');
    }

    public function getDuracionDiaMinutos(): int
    {
        return $this->getScheduleTimeEndLimitMinutos() - $this->getScheduleTimeStartLimitMinutos();
    }

    public function getScheduleDayValid(): string
    {
        return $this->scheduleDayValid;
    }
}

?>