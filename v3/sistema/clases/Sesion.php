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
        /*return Usuario::dbExiste(array(
            "id" => $_SESSION[self::SESSION_SESION]
        ));*/

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
     * Requiere que haya una sesión iniciada para acceder al contenido.
     * En caso de que no haya ninguna sesión iniciada, redirige al inicio de
     * sesión.
     * 
     * TODO: Informar al usuario sobre por qué se le ha redirigido.
     */
    public static function requerirSesionIniciada() : void
    {
        if (! self::isSesionIniciada()) {
            Vista::encolaMensajeError('Necesitas haber iniciado sesión para acceder a este contenido.', '/sesion/iniciar/');
        }
    }
    
    /**
     * Requiere que haya una sesión iniciada con permisos de personal docente
     * para acceder al contenido. En caso negativo, redirige al inicio de 
     * sesión.
     * 
     * TODO: Informar al usuario sobre por qué se le ha redirigido.
     */
    public static function requerirSesionPd() : void
    {
        self::requerirSesionIniciada();

        if (! self::$usuario_en_sesion->isPd()) {
            Vista::encolaMensajeError('No tienes permisos suficientes para acceder a este contenido.', '');
        }
    }
    
    /**
     * Requiere que haya una sesión iniciada con permisos de personal de 
     * secretaría para acceder al contenido. En caso negativo, redirige al 
     * inicio de sesión.
     * 
     * TODO: Informar al usuario sobre por qué se le ha redirigido.
     */
    public static function requerirSesionPs() : void
    {
        self::requerirSesionIniciada();

        if (! self::$usuario_en_sesion->isPs()) {
            Vista::encolaMensajeError('No tienes permisos suficientes para acceder a este contenido.', '');
        }
    }
}
