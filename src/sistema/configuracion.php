<?php

/**
 * Configuración de la aplicación y llamada a la inicialización.
 *
 * Los invitados verán información de acceso público.
 * Los usuarios que inicien sesión verán información
 * personalizada.
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

/**
 * Habilitar escritura estricta (strict typing) en PHP para mayor seguridad.
 */

declare(strict_types = 1);

/**
 * Definición de constantes.
 * 
 * La raíz y la URL no deben incluir el separador final (trailing slash).
 * 
 * La base del controlador se puede usar para ajustar el prefijo del
 * front controller.
 */

define('GESI_DB_HOST', 'localhost');
define('GESI_DB_USER', 'gesi');
define('GESI_DB_PASSWORD', 'gesigesi');
define('GESI_DB_NAME', 'gesidemo');
define('GESI_DB_TABLE_PREFIX', 'gesi_');

define('GESI_ROOT', '__DIR__');
define('GESI_URL', 'http://localhost:60001');
define('GESI_NOMBRE', 'Gesi');
define('GESI_BASE_CONTROLADOR', '');

define('GESI_DEFAULT_PASSWORD', 'holamundo');

define('GESI_SCHEDULE_TIME_START_LIMIT', '9:00');
define('GESI_SCHEDULE_TIME_END_LIMIT', '14:00');
define('GESI_SCHEDULE_DAY_VALID', 'LMXJV');

define('GESI_DESARROLLO', true);

/**
 * Habilitar errores para depuración.
 */

if (GESI_DESARROLLO) {
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
}

/**
 * Configuración de codificación y zona horaria.
 */

ini_set('default_charset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF.8');
setlocale(LC_TIME, 'es_ES');
date_default_timezone_set('Europe/Madrid');

/**
 * Preparar autocarga de clases registrando una función anónima como
 * implementación de __autoload().
 *
 * @see https://www.php.net/manual/en/function.spl-autoload-register.php
 * @see https://www.php-fig.org/psr/psr-4/
 */

spl_autoload_register(function ($class) {
    // Prefijo de espacio de nombres específico del proyecto.
    $prefix = 'Awsw\\Gesi\\';

    // Directorio base para el prefijo del espacio de nombres.
    $base_dir = __DIR__ . '/';

    // ¿La clase utiliza el prefijo del espacio de nombres?
    $len = strlen($prefix);

    if (strncmp($prefix, $class, $len) !== 0) {
        // No, entonces ir al siguiente autoloader.
        return;
    }

    // Obtener el nombre relativo de la clase.
    $relative_class = substr($class, $len);

    // Reemplazar el prefijo del espacio de nombres con directorio base,
    // reemplazar los separadores del espacio de nombres con separadores de
    // directorio en el nombre relativo de la clase y añadir la extensión de
    // PHP.
    $file = $base_dir . 'clases/' . str_replace('\\', '/', $relative_class) . '.php';

    // Si el fichero existe, cargarlo.
    if (file_exists($file)) {
        require $file;
    }
});

/**
 * Inicialización del objeto aplicación.
 */

$app = \Awsw\Gesi\App::getSingleton();

$app->init(
    array(
        'host' => GESI_DB_HOST,
        'user' => GESI_DB_USER,
        'password' => GESI_DB_PASSWORD,
        'name' => GESI_DB_NAME,
        'table_prefix' => GESI_DB_TABLE_PREFIX
    ),

    GESI_ROOT,
    GESI_URL,
    GESI_NOMBRE,
    GESI_BASE_CONTROLADOR,

    GESI_DEFAULT_PASSWORD,

    GESI_SCHEDULE_TIME_START_LIMIT,
    GESI_SCHEDULE_TIME_END_LIMIT,
    GESI_SCHEDULE_DAY_VALID,

    GESI_DESARROLLO
);
