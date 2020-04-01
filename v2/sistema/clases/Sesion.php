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

use \Awsw\Gesi\Datos\Usuario;

class Sesion
{
	// Nombre de la cookie de sesión.
	const NOMBRE_SESION = "gesi_sesion";

    // Usuario que ha iniciado sesión.
    private static $usuario_en_sesion = null;

    /**
     * Inicializa la gestión de la sesión de usuario.
     */
    public static function init() : void
    {
        if (
            isset($_SESSION[self::NOMBRE_SESION]) &&
            is_object($_SESSION[self::NOMBRE_SESION]) &&
            $_SESSION[self::NOMBRE_SESION] instanceof Usuario
        ) {
            self::$usuario_en_sesion = $_SESSION[self::NOMBRE_SESION];
        }
    }

	/**
	 * Inicia la sesión de un usuario.
	 *
	 * @requires No hay ninguna sesión ya iniciada.
	 */
	public static function iniciar(Usuario $usuario) : void
	{
        // Actualizamos la última vez que el usuario inició sesión a ahora.
        $usuario->dbActualizaUltimaSesion();

        // Por seguridad, forzamos que se genere una nueva cookie de sesión por 
        // si la han capturado antes de hacer login.
        session_regenerate_id(true);

		self::$usuario_en_sesion = $usuario;
        $_SESSION[self::NOMBRE_SESION] = self::$usuario_en_sesion;
	}

	/**
	 * Cierra la sesión de un usuario.
	 */
	public static function cerrar() : void
	{
        self::$logged_in_user = null;
		unset($_SESSION[self::NOMBRE_SESION]);

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
            "id" => $_SESSION[self::NOMBRE_SESION]
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
}
