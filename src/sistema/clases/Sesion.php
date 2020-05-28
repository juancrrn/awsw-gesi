<?php

/**
 * Métodos de sesión de usuario.
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

use Awsw\Gesi\Datos\Usuario;
use Awsw\Gesi\Vistas\Vista;

class Sesion
{
	// Valor de $_SESSION donde se almacena la información de sesión.
	const SESSION_SESION = "gesi_sesion";

    // Usuario que ha iniciado sesión.
    private static $usuario_en_sesion = null;

    /**
     * Inicializa la gestión de la sesión de usuario.
     */
    public static function init() : void
    {
        session_start();
        
        if (
            isset($_SESSION[self::SESSION_SESION]) &&
            is_object($_SESSION[self::SESSION_SESION]) &&
            $_SESSION[self::SESSION_SESION] instanceof Usuario
        ) {
            self::$usuario_en_sesion = $_SESSION[self::SESSION_SESION];
        }
    }

	/**
	 * Inicia la sesión de un usuario.
	 *
	 * @requires No hay ninguna sesión ya iniciada.
	 */
	public static function inicia(Usuario $usuario) : void
	{
        // Actualizamos la última vez que el usuario inició sesión a ahora.
        $usuario->dbActualizaUltimaSesion();

        // Por seguridad, forzamos que se genere una nueva cookie de sesión por 
        // si la han capturado antes de hacer login.
        session_regenerate_id(true);

		self::$usuario_en_sesion = $usuario;
        $_SESSION[self::SESSION_SESION] = self::$usuario_en_sesion;
	}

	/**
	 * Cierra la sesión de un usuario.
	 */
	public static function cierra() : void
	{
        self::$usuario_en_sesion = null;
		unset($_SESSION[self::SESSION_SESION]);

		session_destroy();

		session_start();
	}

    /**
     * Comprueba si la sesión está iniciada.
     *
     * Para ello, simplemente comprueba si self::$usuario_en_sesion no es nula.
     *
     * TODO: Comprobar que los valores de self::$usuario_en_sesion aún coindicen
     * con los que hay en la base de datos.
     */
    public static function isSesionIniciada() : bool
    {
        return self::$usuario_en_sesion !== null;
    }

	/**
	 * Devuelve el usuario que ha iniciado sesión.
     *
     * @requires Que haya una sesión iniciada.
	 */
	public static function getUsuarioEnSesion() : Usuario
	{
        return self::$usuario_en_sesion;
    }

    /**
     * Genera una respuesta HTTP con datos JSON y un código estado HTTP, y para 
     * la ejecución del script
     * 
     * @param int   $httpCode HTTP status code
     * @param array $messages Messages to send in the response
     */
    public static function apiRespondError(int $httpCode, array $messages) : void
    {
        $errorData = array(
            'status' => 'error',
            'error' => $httpCode,
            'messages' => $messages
        );

        http_response_code($httpCode);

        header('Content-Type: application/json; charset=utf-8');
        
        echo json_encode($errorData);
        
        die();
    }

    /**
     * Requiere que haya una sesión iniciada para acceder al contenido.
     * En caso de que no haya ninguna sesión iniciada, redirige al inicio de
     * sesión.
     * 
     * @param bool $api Indica si se está utilizano el método en la API, por lo 
     *                  que, en lugar de redirigir, debería mostrar un error 
     *                  HTTP.
     */
    public static function requerirSesionIniciada($api = false) : void
    {
        if (! self::isSesionIniciada()) {
            if (! $api) {
                Vista::encolaMensajeError('Necesitas haber iniciado sesión para acceder a este contenido.', '/sesion/iniciar/');
            } else {
                self::apiRespondError(401, array('No autenticado.')); // HTTP 401 Unauthorized (unauthenticated).
            }
        }
    }

    /**
     * Requiere que NO haya una sesión iniciada para acceder al contenido.
     * En caso de que haya alguna sesión iniciada, redirige a inicio.
     * 
     * @param bool $api Indica si se está utilizano el método en la API, por lo 
     *                  que, en lugar de redirigir, debería mostrar un error 
     *                  HTTP.
     */
    public static function requerirSesionNoIniciada($api = false) : void
    {
        if (self::isSesionIniciada()) {
            if (! $api) {
                Vista::encolaMensajeError('No puedes acceder a esta página habiendo iniciado sesión.', '');
            } else {
                self::apiRespondError(409, array('No debería estar autenticado.')); // HTTP 409 Conflict.
            }
        }
    }
    
    /**
     * Requiere que haya una sesión iniciada con permisos de personal docente
     * para acceder al contenido. En caso negativo, redirige al inicio de 
     * sesión.
     * 
     * @param bool $api Indica si se está utilizano el método en la API, por lo 
     *                  que, en lugar de redirigir, debería mostrar un error 
     *                  HTTP.
     */
    public static function requerirSesionPd($api = false) : void
    {
        self::requerirSesionIniciada($api);

        if (! self::$usuario_en_sesion->isPd()) {
            if (! $api) {
                Vista::encolaMensajeError('No tienes permisos suficientes para acceder a este contenido.', '');
            } else {
                self::apiRespondError(403, array('No autorizado.')); // HTTP 401 Forbidden.
            }
        }
    }
    
    /**
     * Requiere que haya una sesión iniciada con permisos de personal de 
     * secretaría para acceder al contenido. En caso negativo, redirige al 
     * inicio de sesión.
     * 
     * @param bool $api Indica si se está utilizano el método en la API, por lo 
     *                  que, en lugar de redirigir, debería mostrar un error 
     *                  HTTP.
     */
    public static function requerirSesionPs($api = false) : void
    {
        self::requerirSesionIniciada($api);

        if (! self::$usuario_en_sesion->isPs()) {
            if (! $api) {
                Vista::encolaMensajeError('No tienes permisos suficientes para acceder a este contenido.', '');
            } else {
                self::apiRespondError(403, array('No autorizado.')); // HTTP 401 Forbidden.
            }
        }
    }
    
    /**
     * Requiere que haya una sesión iniciada pero SIN permisos de personal de 
     * secretaría para acceder al contenido. En caso negativo, redirige al 
     * inicio de sesión.
     * 
     * @param bool $api Indica si se está utilizano el método en la API, por lo 
     *                  que, en lugar de redirigir, debería mostrar un error 
     *                  HTTP.
     */
    public static function requerirSesionNoPs($api = false) : void
    {
        self::requerirSesionIniciada($api);

        if (self::$usuario_en_sesion->isPs()) {
            if (! $api) {
                Vista::encolaMensajeError('Esta vista solo permite el acceso de personal docente y estudiantes.', '');
            } else {
                self::apiRespondError(403, array('No autorizado.')); // HTTP 401 Forbidden.
            }
        }
    }
}
