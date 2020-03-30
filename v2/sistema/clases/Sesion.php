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

class Sesion
{
	// Nombre de la cookie de sesión.
	const NOMBRE_SESION = "gesi_sesion";

    // Usuario que ha iniciado sesión.
    private static $logged_in_user = null;

    /**
     * Inicializa la gestión de la sesión de usuario.
     */
    public static function init() {
        if (
            isset($_SESSION[self::NOMBRE_SESION]) &&
            is_object($_SESSION[self::NOMBRE_SESION]) &&
            $_SESSION[self::NOMBRE_SESION] instanceof Usuario
        ) {
            self::$logged_in_user = $_SESSION[self::NOMBRE_SESION];
        }
    }

	/**
	 * Inicia la sesión de un usuario.
	 *
	 * @requires No hay ninguna sesión ya iniciada.
	 */
	public static function login(Usuario $user) : void
	{
		self::$logged_in_user = $user;
        $_SESSION[self::NOMBRE_SESION] = self::$logged_in_user;
	}

	/**
	 * Cierra la sesión de un usuario.
	 */
	public static function logout() : void
	{
        self::$logged_in_user = null;
		unset($_SESSION[self::NOMBRE_SESION]);

		session_destroy();

		session_start();
	}

    /**
     * Comprueba si la sesión está iniciada.
     *
     * Para ello, simplemente comprueba si self::$logged_in_user no es nula.
     *
     * TODO: Comprobar que los valores de self::$logged_in_user aún coindicen
     * con los que hay en la base de datos.
     */
    public static function isLogged() : bool
    {
        /*return Usuario::dbExiste(array(
            "id" => $_SESSION[self::NOMBRE_SESION]
        ));*/

        return self::$logged_in_user !== null;
    }

	/**
	 * Devuelve el usuario que ha iniciado sesión.
     *
     * @requires Que haya una sesión iniciada.
	 */
	public static function getLoggedInUser() : Usuario
	{
        return self::$logged_in_user;
    }
}
