<?php

/**
 * Front controller.
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

require_once __DIR__ . "/sistema/configuracion.php";

use Awsw\Gesi\App;
use Awsw\Gesi\Controladores\Controlador;

Controlador::setGetBase(App::getSingleton()->getBaseControlador());

/**
 * Puntos de entrada de vistas relacionadas con landing.
 */

\Awsw\Gesi\Controladores\Home::controla();

/**
 * Puntos de entrada de vistas relacionadas con asignaturas.
 */

\Awsw\Gesi\Controladores\Asignatura::controla();

/**
 * Puntos de entrada de vistas relacionadas con la biblioteca.
 */

\Awsw\Gesi\Controladores\Biblioteca::controla();

/**
 * Puntos de entrada de vistas relacionadas con eventos.
 */

\Awsw\Gesi\Controladores\Evento::controla();

/**
 * Puntos de entrada de vistas relacionadas con foros.
 */

\Awsw\Gesi\Controladores\Foro::controla();

/**
 * Puntos de entrada de vistas relacionadas con grupos.
 */

\Awsw\Gesi\Controladores\Grupo::controla();

/**
 * Puntos de entrada de vistas relacionadas con mensajes de Secretaría.
 */

\Awsw\Gesi\Controladores\MensajeSecretaria::controla();

/**
 * Puntos de entrada de vistas relacionadas con la sesión.
 */

\Awsw\Gesi\Controladores\Sesion::controla();

/**
 * Vistas relacionadas con usuarios
 */

\Awsw\Gesi\Controladores\Usuario::controla();

/**
 * Vista por defecto.
 */

Controlador::default(function () {
	\Awsw\Gesi\Vistas\Vista::dibuja(new \Awsw\Gesi\Vistas\Error\Error404());
});

?>